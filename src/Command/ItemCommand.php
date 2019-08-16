<?php
namespace App\Command;

use Cake\ORM\TableRegistry;
use steinm6\CronHelper\CronHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Utility\Text;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use Cake\I18n\Date;

use SMTPValidateEmail\Validator as SmtpEmailValidator;

class ItemCommand extends Command
{
    var $cron;
    var $itemsTable;

    public function initialize()
    {
        parent::initialize();
        $this->itemsTable = TableRegistry::getTableLocator()->get('Items');

        $this->cron = new CronHelper(TMP . 'cronjob' . DS . 'category');
        if (!$this->cron->lock()) {
            exit;
        }
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $domains = $this->itemsTable->Domains
            ->find()
            ->where([
                'Domains.smtp_validate' => false,
                'Domains.mx_yandex IS' => null
            ])
            ->contain('Items', function($q) {
                return $q->where([
                    'Items.email IS NOT' => null,
                    'Items.is_live' => false,
                    'Items.date_manualChecked IS' => null
                ]);
            });

        foreach($domains as $domain) {
            if (empty($domain->items)) {
                continue;
            }

            $emails = [];
            foreach($domain->items as $item) {
                $emails[] = $item->email;
            }

            try {
                $validator = new SmtpEmailValidator($emails, 'send@dallin.uz');
                $validator->debug = true;
                $results   = $validator->validate();

                foreach($results as $key => $result) {
                    if ($key == 'domains') {
                        continue;
                    }

                    foreach($domain->items as $item) {
                        if ($key == $item->email) {
                            $item->is_live = $result;
                            $this->itemsTable->save($item);

                            break;
                        }
                    }
                }

                $domain->smtp_validate = true;
                $this->itemsTable->Domains->save($domain);

                debug($results);
            }
            catch(Exception $e) {
                exit;
            }

            exit;
        }

        $this->cron->unlock();
    }
}

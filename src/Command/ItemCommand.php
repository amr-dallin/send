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
        $domain = $this->itemsTable->Domains
            ->find()
            ->where(['Domains.date_checked IS' => null])
            ->contain('Items', function ($q) {
                return $q->find('live');
            })
            ->first();

        $emails = [];
        foreach($domain->items as $item) {
            $emails[] = $item->email;
        }

        $date = new Date();
        if (empty($emails)) {
            echo 'No email addresses ' . $domain->domain;
            $domain->date_checked = $date->format('c');
            $this->itemsTable->Domains->save($domain);
            $this->cron->unlock();
            exit;
        }

        $validation = new SmtpEmailValidator($emails, 'send@dallin.uz');
        $validation->debug = true;
        $results = $validation->validate();
        debug($results);

        foreach($results as $key => $result) {
            if ($key == 'domains') {
                continue;
            }

            foreach($domain->items as $item) {
                if ($key == $item->email) {
                    $item->smtp_validate = $result;
                    $this->itemsTable->save($item);

                    break;
                }
            }
        }

        $domain->date_checked = $date->format('c');
        $this->itemsTable->Domains->save($domain);

        $this->cron->unlock();
    }
}

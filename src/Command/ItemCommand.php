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
        $item = $this->itemsTable
            ->find()
            ->where([
                'Items.domain_id' => 183,
                'Items.is_live' => false,
                'Items.date_manualChecked IS' => null
            ])
            ->first();

        if (empty($item)) {
            echo 'No items';
            exit;
        }

        try {
            $validator = new SmtpEmailValidator($item->email, 'send@dallin.uz');
            $validator->debug = true;
            $results   = $validator->validate();

            foreach($results as $key => $result) {
                if ($key == 'domains') {
                    continue;
                }

                if ($key == $item->email) {
                    $item->date_manualChecked = date('c');
                    $item->is_live = $result;
                    $this->itemsTable->save($item);

                    break;
                }
            }

            debug($results);
        }
        catch(Exception $e) {
            $item->date_manualChecked = date('c');
            $this->itemsTable->save($item);
            debug($results);
        }

        exit;

        $this->cron->unlock();
    }
}

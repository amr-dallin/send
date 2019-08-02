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
        $email = ['amr.dallin@gmail.com', 'mail@dallin.uz', 'ilmir@gmail.com'];
        $validation = new SmtpEmailValidator($emails, $sender);
        $validation->debug = true;

        $this->cron->unlock();
    }
}

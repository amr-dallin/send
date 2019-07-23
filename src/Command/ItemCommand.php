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

//use SMTPValidateEmail\Validator as SmtpEmailValidator;

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
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
            new SpoofCheckValidation()
        ]);

        $items = $this->itemsTable
            ->find()
            ->select(['Items.id', 'Items.email'])
            ->where([
                'Items.email IS NOT' => null,
                'Items.live IS' => null
            ])
            ->toArray();

        foreach($items as $item) {
            $result = 0;
            if ($validator->isValid($item->email, $multipleValidations)) {
                $result = 1;
            }
            $item->live = $result;
            $this->itemsTable->save($item);
        }

        $this->cron->unlock();
    }
}

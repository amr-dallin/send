<?php
namespace App\Command;

use Cake\ORM\TableRegistry;
use steinm6\CronHelper\CronHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Utility\Text;

class CategoryCommand extends Command
{
    var $cron;
    var $categoriesTable;

    public function initialize()
    {
        parent::initialize();
        $this->categoriesTable = TableRegistry::getTableLocator()->get('Categories');

        $this->cron = new CronHelper(TMP . 'cronjob' . DS . 'category');
        if (!$this->cron->lock()) {
            exit;
        }
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->categoriesTable->analysed();
        $this->cron->unlock();
    }
}

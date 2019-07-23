<?php
namespace App\Command;

use Cake\ORM\TableRegistry;
use steinm6\CronHelper\CronHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Utility\Text;

class SectionCommand extends Command
{
    var $cron;
    var $sectionsTable;

    public function initialize()
    {
        parent::initialize();
        $this->sectionsTable = TableRegistry::getTableLocator()->get('Sections');

        $this->cron = new CronHelper(TMP . 'cronjob' . DS . 'section');
        if (!$this->cron->lock()) {
            exit;
        }
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->sectionsTable->analysed();
        $this->cron->unlock();
    }
}

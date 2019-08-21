<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Items');
        $this->loadModel('Domains');
    }

    public function display()
    {
        $countItems = $this->Items->find()->count();
        $countItemsWithEmail = $this->Items->find('withEmail')->count();

        $distributionItemsWithEmailByRegions = $this->Items
            ->find('distributionByRegions')
            ->find('withEmail');

        // RFC check analysis
        $rfcFailedCheckItems = $this->Items
            ->find('rfcFailedCheck')
            ->find('list')
            ->toArray();

        $countRfcFailedCheckItems = $this->Items
            ->find('rfcFailedCheck')
            ->count();

        // Spoof check analysis
        $spoofFailedCheckItems = $this->Items
            ->find('spoofFailedCheck')
            ->find('list')
            ->toArray();

        $countSpoofFailedCheckItems = $this->Items
            ->find('spoofFailedCheck')
            ->count();


        // DNS check analysis
        $dnsFailedCheckItems = $this->Items
            ->find('dnsFailedCheck')
            ->find('list')
            ->toArray();

        $countDnsFailedCheckItems = $this->Items
            ->find('dnsFailedCheck')
            ->count();

        // Domain SMTP analysis
        $smtpFailedCheckDomains = $this->Domains
            ->find('smtpFailedCheck')
            ->find('list')
            ->toArray();

        $countSmtpFailedCheckDomains = $this->Domains
            ->find('smtpFailedCheck')
            ->count();

        $countDomainSmtpFailedCheckItems = $this->Items
            ->find('domainSmtpFailedCheck')
            ->count();

        // Emails SMTP analysis
        $dieEmails = $this->Items->find('list')
            ->find('die')
            ->toArray();
        $countDieEmails = $this->Items->find('die')->count();

        $countLiveEmails = $this->Items->find('live')->count();
        $countIncorrectEmails  = $this->Items->find('incorrect')->count();

        $this->set(compact(
            'countItems',
            'countItemsWithEmail',
            'distributionItemsWithEmailByRegions',
            'rfcFailedCheckItems',
            'countRfcFailedCheckItems',
            'spoofFailedCheckItems',
            'countSpoofFailedCheckItems',
            'dnsFailedCheckItems',
            'countDnsFailedCheckItems',
            'smtpFailedCheckDomains',
            'countSmtpFailedCheckDomains',
            'countDomainSmtpFailedCheckItems',
            'dieEmails',
            'countDieEmails',
            'countLiveEmails',
            'countIncorrectEmails'
        ));
    }
}

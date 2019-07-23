<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Sections Controller
 *
 * @property \App\Model\Table\SectionsTable $Sections
 *
 * @method \App\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SectionsController extends AppController
{
    public function index()
    {
        $cities = [2];

        $tableCampaigns = TableRegistry::getTableLocator()->get('Campaigns');
        $campaign = $tableCampaigns->getCampaignItemList(245);

        debug($campaign);
        exit;

        $sections = $this->Sections
            ->find('result', ['city_ids' => $cities])
            ->toArray();

        debug($sections);
        exit;
    }

    public function regionSectionList()
    {
        $this->request->allowMethod('ajax');

        $tableCampaigns = TableRegistry::getTableLocator()->get('Campaigns');
        $campaign = $tableCampaigns->getCampaignItemList($this->request->query['campaign_id']);

        $cities = $this->request->getData('Cities.id');

        $sections = $this->Sections
            ->find('result', [
                'city_ids' => $cities,
                'item_ids' => $campaign->items
            ])
            ->toArray();

        $this->viewBuilder()->setClassName('Ajax.Ajax');
        $this->set(compact('sections', 'campaign', 'cities'));
    }
}

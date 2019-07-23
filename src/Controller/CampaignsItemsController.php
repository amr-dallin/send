<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * CampaignsItems Controller
 *
 * @property \App\Model\Table\CampaignsItemsTable $CampaignsItems
 *
 * @method \App\Model\Entity\CampaignsItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampaignsItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Campaigns', 'Items']
        ];
        $campaignsItems = $this->paginate($this->CampaignsItems);

        $this->set(compact('campaignsItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Campaigns Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $campaignsItem = $this->CampaignsItems->get($id, [
            'contain' => ['Campaigns', 'Items']
        ]);

        $this->set('campaignsItem', $campaignsItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campaign = $this->CampaignsItems->Campaigns
            ->getCampaignItemList($this->request->query['campaign_id']);

        if ($this->request->is('post')) {
            if ($this->CampaignsItems->addSubscribers([
                'category_ids' => $this->request->getData('Categories.id'),
                'city_ids' => $this->request->getData('Cities.id'),
                'campaign' => $campaign
            ])) {
                $this->Flash->success(__('The subscribers added'));

                return $this->redirect(['controller' => 'Campaigns', 'action' => 'view', $campaign->id]);
            }
            $this->Flash->error(__('The subscribers not added. Please, try again.'));
        }

        $tableRegions = TableRegistry::getTableLocator()->get('Regions');
        $regions = $tableRegions->find()
            ->order(['Regions.title' => 'ASC'])
            ->contain('Cities')
            ->toArray();

        $this->set(compact('campaign', 'regions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Campaigns Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $campaignsItem = $this->CampaignsItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $campaignsItem = $this->CampaignsItems->patchEntity($campaignsItem, $this->request->getData());
            if ($this->CampaignsItems->save($campaignsItem)) {
                $this->Flash->success(__('The campaigns item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaigns item could not be saved. Please, try again.'));
        }
        $campaigns = $this->CampaignsItems->Campaigns->find('list', ['limit' => 200]);
        $items = $this->CampaignsItems->Items->find('list', ['limit' => 200]);
        $this->set(compact('campaignsItem', 'campaigns', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Campaigns Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $campaignsItem = $this->CampaignsItems->get($id);
        if ($this->CampaignsItems->delete($campaignsItem)) {
            $this->Flash->success(__('The campaigns item has been deleted.'));
        } else {
            $this->Flash->error(__('The campaigns item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

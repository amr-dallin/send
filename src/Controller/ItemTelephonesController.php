<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemTelephones Controller
 *
 * @property \App\Model\Table\ItemTelephonesTable $ItemTelephones
 *
 * @method \App\Model\Entity\ItemTelephone[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemTelephonesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items']
        ];
        $itemTelephones = $this->paginate($this->ItemTelephones);

        $this->set(compact('itemTelephones'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Telephone id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemTelephone = $this->ItemTelephones->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('itemTelephone', $itemTelephone);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemTelephone = $this->ItemTelephones->newEntity();
        if ($this->request->is('post')) {
            $itemTelephone = $this->ItemTelephones->patchEntity($itemTelephone, $this->request->getData());
            if ($this->ItemTelephones->save($itemTelephone)) {
                $this->Flash->success(__('The item telephone has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item telephone could not be saved. Please, try again.'));
        }
        $items = $this->ItemTelephones->Items->find('list', ['limit' => 200]);
        $this->set(compact('itemTelephone', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Telephone id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemTelephone = $this->ItemTelephones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemTelephone = $this->ItemTelephones->patchEntity($itemTelephone, $this->request->getData());
            if ($this->ItemTelephones->save($itemTelephone)) {
                $this->Flash->success(__('The item telephone has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item telephone could not be saved. Please, try again.'));
        }
        $items = $this->ItemTelephones->Items->find('list', ['limit' => 200]);
        $this->set(compact('itemTelephone', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Telephone id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemTelephone = $this->ItemTelephones->get($id);
        if ($this->ItemTelephones->delete($itemTelephone)) {
            $this->Flash->success(__('The item telephone has been deleted.'));
        } else {
            $this->Flash->error(__('The item telephone could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

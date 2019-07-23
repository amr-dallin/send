<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CategoriesItems Controller
 *
 * @property \App\Model\Table\CategoriesItemsTable $CategoriesItems
 *
 * @method \App\Model\Entity\CategoriesItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Items']
        ];
        $categoriesItems = $this->paginate($this->CategoriesItems);

        $this->set(compact('categoriesItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Categories Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoriesItem = $this->CategoriesItems->get($id, [
            'contain' => ['Categories', 'Items']
        ]);

        $this->set('categoriesItem', $categoriesItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoriesItem = $this->CategoriesItems->newEntity();
        if ($this->request->is('post')) {
            $categoriesItem = $this->CategoriesItems->patchEntity($categoriesItem, $this->request->getData());
            if ($this->CategoriesItems->save($categoriesItem)) {
                $this->Flash->success(__('The categories item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categories item could not be saved. Please, try again.'));
        }
        $categories = $this->CategoriesItems->Categories->find('list', ['limit' => 200]);
        $items = $this->CategoriesItems->Items->find('list', ['limit' => 200]);
        $this->set(compact('categoriesItem', 'categories', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categories Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriesItem = $this->CategoriesItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriesItem = $this->CategoriesItems->patchEntity($categoriesItem, $this->request->getData());
            if ($this->CategoriesItems->save($categoriesItem)) {
                $this->Flash->success(__('The categories item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categories item could not be saved. Please, try again.'));
        }
        $categories = $this->CategoriesItems->Categories->find('list', ['limit' => 200]);
        $items = $this->CategoriesItems->Items->find('list', ['limit' => 200]);
        $this->set(compact('categoriesItem', 'categories', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categories Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriesItem = $this->CategoriesItems->get($id);
        if ($this->CategoriesItems->delete($categoriesItem)) {
            $this->Flash->success(__('The categories item has been deleted.'));
        } else {
            $this->Flash->error(__('The categories item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

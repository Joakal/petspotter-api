<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Breeds Controller
 *
 * @property \App\Model\Table\BreedsTable $Breeds
 * @method \App\Model\Entity\Breed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BreedsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $breeds = $this->Breeds->find('all');

        $this->set([
            'breeds' => $breeds,
            '_serialize' => 'breeds',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * View method
     *
     * @param string|null $id Breed id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $breed = $this->Breeds->get($id, [
            'contain' => ['Breeds'],
        ]);

        $this->set(compact('breed'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $breed = $this->Breeds->newEmptyEntity();
        if ($this->request->is('post')) {
            $breed = $this->Breeds->patchEntity($breed, $this->request->getData());
            if ($this->Breeds->save($breed)) {
                $this->Flash->success(__('The breed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The breed could not be saved. Please, try again.'));
        }
        $this->set(compact('breed'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Breed id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $breed = $this->Breeds->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $breed = $this->Breeds->patchEntity($breed, $this->request->getData());
            if ($this->Breeds->save($breed)) {
                $this->Flash->success(__('The breed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The breed could not be saved. Please, try again.'));
        }
        $this->set(compact('breed'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Breed id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $breed = $this->Breeds->get($id);
        if ($this->Breeds->delete($breed)) {
            $this->Flash->success(__('The breed has been deleted.'));
        } else {
            $this->Flash->error(__('The breed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

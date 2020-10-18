<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Validation\Validator;

/**
 * Locations Controller
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $locations = $this->paginate($this->Locations);

        $this->set([
            'locations' => $locations,
            '_serialize' => 'locations',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('location'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Locations->newEmptyEntity();
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set(compact('location'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set(compact('location'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Bounding box method
     *
     * @param float|null $lat Latiude.
     * @param float|null $lon Longitude.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function box()
    {
        $validator = new Validator();
        $validator
        ->requirePresence(['nelat', 'nelng', 'swlat', 'swlng'])
        ->add('nelat', 'decimal')
        ->add('nelng', 'decimal') 
        ->add('swlat', 'decimal') 
        ->add('swlng', 'decimal');
        $query = $this->request->getQueryParams();
        $errors = $validator->validate($query);

        if (count($errors) > 0) {
            $this->set([
                'errors' => $errors,
                '_serialize' => 'errors',
            ]);
            $this->RequestHandler->renderAs($this, 'json');
            return;
        }

        $lat = $query['nelat'];
        $lon = $query['nelng'];
        $endLat = $query['swlat'];
        $endLon = $query['swlng'];
        
        
        $locations = $this->paginate($this->Locations
            ->find()
            ->select(['id', 'name', 'lat', 'lon'])
            ->where(['lat <' =>  $lat])
            ->where(['lon <' => $lon])
            ->where(['lat >' => $endLat])
            ->where(['lon >' => $endLon])
        );

        $this->set([
            'locations' => $locations,
            '_serialize' => 'locations',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }
}

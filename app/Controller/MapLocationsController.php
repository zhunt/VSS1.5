<?php
App::uses('AppController', 'Controller');
/**
 * MapLocations Controller
 *
 * @property MapLocation $MapLocation
 */
class MapLocationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->MapLocation->recursive = 0;
		$this->set('mapLocations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->MapLocation->id = $id;
		if (!$this->MapLocation->exists()) {
			throw new NotFoundException(__('Invalid map location'));
		}
		$this->set('mapLocation', $this->MapLocation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MapLocation->create();
			if ($this->MapLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The map location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location could not be saved. Please, try again.'));
			}
		}
		$venues = $this->MapLocation->Venue->find('list');
		$mapLocationTypes = $this->MapLocation->MapLocationType->find('list');
		$maps = $this->MapLocation->Map->find('list');
		$this->set(compact('venues', 'mapLocationTypes', 'maps'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MapLocation->id = $id;
		if (!$this->MapLocation->exists()) {
			throw new NotFoundException(__('Invalid map location'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MapLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The map location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MapLocation->read(null, $id);
		}
		$venues = $this->MapLocation->Venue->find('list');
		$mapLocationTypes = $this->MapLocation->MapLocationType->find('list');
		$maps = $this->MapLocation->Map->find('list');
 
                
		$this->set(compact('venues', 'mapLocationTypes', 'maps'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->MapLocation->id = $id;
		if (!$this->MapLocation->exists()) {
			throw new NotFoundException(__('Invalid map location'));
		}
		if ($this->MapLocation->delete()) {
			$this->Session->setFlash(__('Map location deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Map location was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->MapLocation->recursive = 0;
		$this->set('mapLocations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->MapLocation->id = $id;
		if (!$this->MapLocation->exists()) {
			throw new NotFoundException(__('Invalid map location'));
		}
		$this->set('mapLocation', $this->MapLocation->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
                $this->MapLocation->Behaviors->unload('Sluggable');
                
		if ($this->request->is('post')) {
			$this->MapLocation->create();
			if ($this->MapLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The map location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location could not be saved. Please, try again.'));
			}
		}
		$venues = $this->MapLocation->Venue->find('list', array(
                        'recursive' => 0,
                        'order' => array('City.name', 'Venue.full_name'),
                        'conditions' => array('Venue.publish_state_id' => VENUE_PUBLISHED), 
                        'fields' => array('Venue.id', 'Venue.full_name', 'City.name') 
                        ) 
                        );
                
                $cities = $this->MapLocation->City->find('list', array(
                   'recursive' => 0, 
                   'order' => array('Province.name', 'City.name'),
                   'fields' => array('City.id', 'City.name', 'Province.name')
                ));
                $provinces = $this->MapLocation->Province->find('list');  
                
		$mapLocationTypes = $this->MapLocation->MapLocationType->find('list');
		$maps = $this->MapLocation->Map->find('list');
		$this->set(compact('venues', 'mapLocationTypes', 'maps', 'cities', 'provinces'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
                $this->MapLocation->Behaviors->unload('Sluggable');
                
		$this->MapLocation->id = $id;
		if (!$this->MapLocation->exists()) {
			throw new NotFoundException(__('Invalid map location'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MapLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The map location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MapLocation->read(null, $id);
		}
		
                
		$venues = $this->MapLocation->Venue->find('list', array(
                        'recursive' => 0,
                        'order' => array('City.name', 'Venue.full_name'),
                        'conditions' => array('Venue.publish_state_id' => VENUE_PUBLISHED), 
                        'fields' => array('Venue.id', 'Venue.full_name', 'City.name') 
                        ) 
                        );
                
                $cities = $this->MapLocation->City->find('list', array(
                   'recursive' => 0, 
                   'order' => array('Province.name', 'City.name'),
                   'fields' => array('City.id', 'City.name', 'Province.name')
                ));
                $provinces = $this->MapLocation->Province->find('list');                
                
		$mapLocationTypes = $this->MapLocation->MapLocationType->find('list');
		$maps = $this->MapLocation->Map->find('list');
		$this->set(compact('venues', 'mapLocationTypes', 'maps', 'cities', 'provinces'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->MapLocation->id = $id;
		if (!$this->MapLocation->exists()) {
			throw new NotFoundException(__('Invalid map location'));
		}
		if ($this->MapLocation->delete()) {
			$this->Session->setFlash(__('Map location deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Map location was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

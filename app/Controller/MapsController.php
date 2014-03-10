<?php
App::uses('AppController', 'Controller');
/**
 * Maps Controller
 *
 * @property Map $Map
 */
class MapsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Map->recursive = 0;
		$this->set('maps', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Map->id = $id;
		if (!$this->Map->exists()) {
			throw new NotFoundException(__('Invalid map'));
		}
		$this->set('map', $this->Map->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Map->create();
			if ($this->Map->save($this->request->data)) {
				$this->Session->setFlash(__('The map has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map could not be saved. Please, try again.'));
			}
		}
		$mapLocations = $this->Map->MapLocation->find('list');
		$this->set(compact('mapLocations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Map->id = $id;
		if (!$this->Map->exists()) {
			throw new NotFoundException(__('Invalid map'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Map->save($this->request->data)) {
				$this->Session->setFlash(__('The map has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Map->read(null, $id);
		}
		$mapLocations = $this->Map->MapLocation->find('list');
		$this->set(compact('mapLocations'));
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
		$this->Map->id = $id;
		if (!$this->Map->exists()) {
			throw new NotFoundException(__('Invalid map'));
		}
		if ($this->Map->delete()) {
			$this->Session->setFlash(__('Map deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Map was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Map->recursive = 0;
		$this->set('maps', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Map->id = $id;
		if (!$this->Map->exists()) {
			throw new NotFoundException(__('Invalid map'));
		}
		$this->set('map', $this->Map->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Map->create();
			if ($this->Map->save($this->request->data)) {
				$this->Session->setFlash(__('The map has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map could not be saved. Please, try again.'));
			}
		}
                
                $cities = $this->Map->City->find('list', array(
                   'recursive' => 0, 
                   'order' => array('Province.name', 'City.name'),
                   'fields' => array('City.id', 'City.name', 'Province.name')
                ));
                $provinces = $this->Map->Province->find('list'); 
                
		$mapLocations = $this->Map->MapLocation->find('list');
		$this->set(compact('mapLocations', 'provinces', 'cities'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Map->id = $id;
		if (!$this->Map->exists()) {
			throw new NotFoundException(__('Invalid map'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Map->save($this->request->data)) {
				$this->Session->setFlash(__('The map has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Map->read(null, $id);
		}
                $cities = $this->Map->City->find('list', array(
                   'recursive' => 0, 
                   'order' => array('Province.name', 'City.name'),
                   'fields' => array('City.id', 'City.name', 'Province.name')
                ));
                $provinces = $this->Map->Province->find('list');                 
		$mapLocations = $this->Map->MapLocation->find('list');
		$this->set(compact('mapLocations', 'cities', 'provinces'));
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
		$this->Map->id = $id;
		if (!$this->Map->exists()) {
			throw new NotFoundException(__('Invalid map'));
		}
		if ($this->Map->delete()) {
			$this->Session->setFlash(__('Map deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Map was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

<?php
App::uses('AppController', 'Controller');
/**
 * MapLocationTypes Controller
 *
 * @property MapLocationType $MapLocationType
 */
class MapLocationTypesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->MapLocationType->recursive = 0;
		$this->set('mapLocationTypes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->MapLocationType->id = $id;
		if (!$this->MapLocationType->exists()) {
			throw new NotFoundException(__('Invalid map location type'));
		}
		$this->set('mapLocationType', $this->MapLocationType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MapLocationType->create();
			if ($this->MapLocationType->save($this->request->data)) {
				$this->Session->setFlash(__('The map location type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location type could not be saved. Please, try again.'));
			}
		}
		$maps = $this->MapLocationType->Map->find('list');
		$this->set(compact('maps'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MapLocationType->id = $id;
		if (!$this->MapLocationType->exists()) {
			throw new NotFoundException(__('Invalid map location type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MapLocationType->save($this->request->data)) {
				$this->Session->setFlash(__('The map location type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location type could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MapLocationType->read(null, $id);
		}
		$maps = $this->MapLocationType->Map->find('list');
		$this->set(compact('maps'));
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
		$this->MapLocationType->id = $id;
		if (!$this->MapLocationType->exists()) {
			throw new NotFoundException(__('Invalid map location type'));
		}
		if ($this->MapLocationType->delete()) {
			$this->Session->setFlash(__('Map location type deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Map location type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->MapLocationType->recursive = 0;
		$this->set('mapLocationTypes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->MapLocationType->id = $id;
		if (!$this->MapLocationType->exists()) {
			throw new NotFoundException(__('Invalid map location type'));
		}
		$this->set('mapLocationType', $this->MapLocationType->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
                $this->MapLocationType->Behaviors->unload('Sluggable');
		if ($this->request->is('post')) {
			$this->MapLocationType->create();
			if ($this->MapLocationType->save($this->request->data)) {
				$this->Session->setFlash(__('The map location type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location type could not be saved. Please, try again.'));
			}
		}
		$maps = $this->MapLocationType->Map->find('list');
		$this->set(compact('maps'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
                $this->MapLocationType->Behaviors->unload('Sluggable');
                
		$this->MapLocationType->id = $id;
		if (!$this->MapLocationType->exists()) {
			throw new NotFoundException(__('Invalid map location type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MapLocationType->save($this->request->data)) {
				$this->Session->setFlash(__('The map location type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The map location type could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MapLocationType->read(null, $id);
		}
		$maps = $this->MapLocationType->Map->find('list');
		$this->set(compact('maps'));
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
		$this->MapLocationType->id = $id;
		if (!$this->MapLocationType->exists()) {
			throw new NotFoundException(__('Invalid map location type'));
		}
		if ($this->MapLocationType->delete()) {
			$this->Session->setFlash(__('Map location type deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Map location type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

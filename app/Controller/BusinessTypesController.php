<?php
App::uses('AppController', 'Controller');
/**
 * BusinessTypes Controller
 *
 * @property BusinessType $BusinessType
 */
class BusinessTypesController extends AppController {


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BusinessType->recursive = 0;
		$this->set('businessTypes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->BusinessType->id = $id;
		if (!$this->BusinessType->exists()) {
			throw new NotFoundException(__('Invalid business type'));
		}
		$this->set('businessType', $this->BusinessType->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BusinessType->create();
			if ($this->BusinessType->save($this->request->data)) {
				$this->Session->setFlash(__('The business type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The business type could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->BusinessType->id = $id;
		if (!$this->BusinessType->exists()) {
			throw new NotFoundException(__('Invalid business type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BusinessType->save($this->request->data)) {
				$this->Session->setFlash(__('The business type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The business type could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->BusinessType->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->BusinessType->id = $id;
		if (!$this->BusinessType->exists()) {
			throw new NotFoundException(__('Invalid business type'));
		}
		if ($this->BusinessType->delete()) {
			$this->Session->setFlash(__('Business type deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Business type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

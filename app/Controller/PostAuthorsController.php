<?php
App::uses('AppController', 'Controller');
/**
 * PostAuthors Controller
 *
 * @property PostAuthor $PostAuthor
 */
class PostAuthorsController extends AppController {

    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('view', 'index');
    }    

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->PostAuthor->recursive = 0;
		$this->set('postAuthors', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->PostAuthor->id = $id;
		if (!$this->PostAuthor->exists()) {
			throw new NotFoundException(__('Invalid post author'));
		}
		$this->set('postAuthor', $this->PostAuthor->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PostAuthor->create();
			if ($this->PostAuthor->save($this->request->data)) {
				$this->Session->setFlash(__('The post author has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post author could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->PostAuthor->id = $id;
		if (!$this->PostAuthor->exists()) {
			throw new NotFoundException(__('Invalid post author'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PostAuthor->save($this->request->data)) {
				$this->Session->setFlash(__('The post author has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post author could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PostAuthor->read(null, $id);
		}
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
		$this->PostAuthor->id = $id;
		if (!$this->PostAuthor->exists()) {
			throw new NotFoundException(__('Invalid post author'));
		}
		if ($this->PostAuthor->delete()) {
			$this->Session->setFlash(__('Post author deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post author was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

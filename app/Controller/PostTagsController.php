<?php
App::uses('AppController', 'Controller');
/**
 * PostTags Controller
 *
 * @property PostTag $PostTag
 */
class PostTagsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PostTag->recursive = 0;
		$this->set('postTags', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PostTag->id = $id;
		if (!$this->PostTag->exists()) {
			throw new NotFoundException(__('Invalid post tag'));
		}
		$this->set('postTag', $this->PostTag->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PostTag->create();
			if ($this->PostTag->save($this->request->data)) {
				$this->Session->setFlash(__('The post tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post tag could not be saved. Please, try again.'));
			}
		}
		$posts = $this->PostTag->Post->find('list');
		$this->set(compact('posts'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->PostTag->id = $id;
		if (!$this->PostTag->exists()) {
			throw new NotFoundException(__('Invalid post tag'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PostTag->save($this->request->data)) {
				$this->Session->setFlash(__('The post tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post tag could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PostTag->read(null, $id);
		}
		$posts = $this->PostTag->Post->find('list');
		$this->set(compact('posts'));
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
		$this->PostTag->id = $id;
		if (!$this->PostTag->exists()) {
			throw new NotFoundException(__('Invalid post tag'));
		}
		if ($this->PostTag->delete()) {
			$this->Session->setFlash(__('Post tag deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post tag was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->PostTag->recursive = 0;
		$this->set('postTags', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->PostTag->id = $id;
		if (!$this->PostTag->exists()) {
			throw new NotFoundException(__('Invalid post tag'));
		}
		$this->set('postTag', $this->PostTag->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PostTag->create();
			if ($this->PostTag->save($this->request->data)) {
				$this->Session->setFlash(__('The post tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post tag could not be saved. Please, try again.'));
			}
		}
		$posts = $this->PostTag->Post->find('list');
		$this->set(compact('posts'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->PostTag->id = $id;
		if (!$this->PostTag->exists()) {
			throw new NotFoundException(__('Invalid post tag'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PostTag->save($this->request->data)) {
				$this->Session->setFlash(__('The post tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post tag could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PostTag->read(null, $id);
		}
		$posts = $this->PostTag->Post->find('list');
		$this->set(compact('posts'));
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
		$this->PostTag->id = $id;
		if (!$this->PostTag->exists()) {
			throw new NotFoundException(__('Invalid post tag'));
		}
		if ($this->PostTag->delete()) {
			$this->Session->setFlash(__('Post tag deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post tag was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

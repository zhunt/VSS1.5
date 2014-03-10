<?php
App::uses('AppController', 'Controller');
/**
 * Chains Controller
 *
 * @property Chain $Chain
 */
class ChainsController extends AppController {
    var $helpers = array('Html', 'Form');

    
        function admin_ajax_add() {
            if ( $this->RequestHandler->isAjax() ){

                $chain = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/', "'"));

                if ( empty($chain) ) {
                    $data = array('status' => 'error', 'msg' => 'Error occured');
                } else {
                    $id = $this->Chain->updateChain( $chain);

                    if ( $id != false)
                        $data = array('status' => 'ok', 'msg' => 'All good');
                    else
                        $data = array('status' => 'error', 'msg' => 'Error occured');
                }

                $chains = $this->Chain->find('list', array(
                        'order' => array('Chain.name')
                    ) );

                $this->set( compact('chains', 'data', 'id'));

            }
        }
        
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Chain->recursive = 0;
		$this->set('chains', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Chain->id = $id;
		if (!$this->Chain->exists()) {
			throw new NotFoundException(__('Invalid chain'));
		}
		$this->set('chain', $this->Chain->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Chain->recursive = 0;
		$this->set('chains', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Chain->id = $id;
		if (!$this->Chain->exists()) {
			throw new NotFoundException(__('Invalid chain'));
		}
		$this->set('chain', $this->Chain->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Chain->create();
			if ($this->Chain->save($this->request->data)) {
				$this->Session->setFlash(__('The chain has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The chain could not be saved. Please, try again.'));
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
		$this->Chain->id = $id;
		if (!$this->Chain->exists()) {
			throw new NotFoundException(__('Invalid chain'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Chain->save($this->request->data)) {
				$this->Session->setFlash(__('The chain has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The chain could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Chain->read(null, $id);
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
		$this->Chain->id = $id;
		if (!$this->Chain->exists()) {
			throw new NotFoundException(__('Invalid chain'));
		}
		if ($this->Chain->delete()) {
			$this->Session->setFlash(__('Chain deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Chain was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

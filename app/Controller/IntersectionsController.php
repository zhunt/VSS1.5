<?php
App::uses('AppController', 'Controller');
/**
 * Intersections Controller
 *
 * @property Intersection $Intersection
 */
class IntersectionsController extends AppController {
    var $helpers = array('Html', 'Form');
    
    function admin_ajax_add() {
       
        if ( $this->RequestHandler->isAjax() ){

            $cityId = intval($this->params['url']['cityId']);
            $cityRegion = trim($this->params['url']['name']);
            //debug($cityRegion);
            //debug($cityId);
            if ( $cityId < 1 || empty($cityRegion) ) {
                $data = array('status' => 'error', 'msg' => 'Error occured');
            } else {
                $id = $this->Intersection->updateIntersection( $cityRegion, $cityId);

                if ( $id != false)
                    $data = array('status' => 'ok', 'msg' => 'All good');
            }

            $intersections = $this->Intersection->find('list', array(
                    'conditions' => array('Intersection.city_id' => $cityId ),
                    'order' => array('Intersection.name')
                ));

            $this->set( compact('intersections', 'data', 'id'));

        } 
    }
    
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Intersection->recursive = 0;
		$this->set('intersections', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Intersection->id = $id;
		if (!$this->Intersection->exists()) {
			throw new NotFoundException(__('Invalid intersection'));
		}
		$this->set('intersection', $this->Intersection->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Intersection->create();
			if ($this->Intersection->save($this->request->data)) {
				$this->Session->setFlash(__('The intersection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The intersection could not be saved. Please, try again.'));
			}
		}
		$cities = $this->Intersection->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Intersection->id = $id;
		if (!$this->Intersection->exists()) {
			throw new NotFoundException(__('Invalid intersection'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Intersection->save($this->request->data)) {
				$this->Session->setFlash(__('The intersection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The intersection could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Intersection->read(null, $id);
		}
		$cities = $this->Intersection->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * delete method
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
		$this->Intersection->id = $id;
		if (!$this->Intersection->exists()) {
			throw new NotFoundException(__('Invalid intersection'));
		}
		if ($this->Intersection->delete()) {
			$this->Session->setFlash(__('Intersection deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Intersection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

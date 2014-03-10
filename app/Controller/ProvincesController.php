<?php
App::uses('AppController', 'Controller');
/**
 * Provinces Controller
 *
 * @property Province $Province
 */
class ProvincesController extends AppController {
    var $components = array('Seo');
    public $helpers = array('Cache');      

    public $cacheAction = array(
        'view' => 36000,
        'index'  => 48000
    );     
   
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('map', 'index', 'view');
    }  
    
    public function view() {
        
             $slug = Sanitize::paranoid( $this->params['slug'], array( '_', '-') );
             if (!$slug) {
                throw new NotFoundException(__('Invalid slug'));
             } 
            
             $this->Province->recursive = 0;
            $province = $this->Province->findBySlug($slug, array('contain' => false) );
            
            $cities = $this->Province->City->find('all', array(
                    'fields' => array('name', 'slug', 'venue_count'),
                    'order' => 'City.name ASC',
                    'conditions' => array('City.province_id' => $province['Province']['id'], 'City.venue_count >' => 0),
                    'contain' => array('CityRegion' => array('name', 'slug') )
                    
                )
            );
           // debug($province);
           //debug($cities);
            
            $cityList = Hash::extract($cities, '{n}.City.name');
            $cityList = array_merge($cityList, (array)$province['Province']['name'] );
            sort($cityList);
            
            
            $seo = $this->Seo->setCityPageMeta( array(
                                                'descText' => 'List of Book, Comics and Magazine store in Province of ' . $province['Province']['name'] , 
                                                'titleText' => 'Book, Comics and Magazine store in Province of ' . $province['Province']['name'],
                                                'keywords' => $cityList ));
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];
           
            $this->set('title_for_layout', $seo['title']);
            
            $openGraph = $this->Seo->setOpengraph( array(
                    'seo' => $seo, 
                    'url' => Configure::read('Website.url') . $this->request->here
                ) );              
		
            $this->set( compact( 'province', 'cities', 'seo', 'openGraph', 'metaDescription', 'metaKeywords') );       
    }
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Province->recursive = 0;
		$this->set('provinces', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Province->id = $id;
		if (!$this->Province->exists()) {
			throw new NotFoundException(__('Invalid province'));
		}
		$this->set('province', $this->Province->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Province->create();
			if ($this->Province->save($this->request->data)) {
				$this->Session->setFlash(__('The province has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The province could not be saved. Please, try again.'));
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
		$this->Province->id = $id;
		if (!$this->Province->exists()) {
			throw new NotFoundException(__('Invalid province'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Province->save($this->request->data)) {
				$this->Session->setFlash(__('The province has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The province could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Province->read(null, $id);
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
		$this->Province->id = $id;
		if (!$this->Province->exists()) {
			throw new NotFoundException(__('Invalid province'));
		}
		if ($this->Province->delete()) {
			$this->Session->setFlash(__('Province deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Province was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

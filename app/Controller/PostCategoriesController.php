<?php
App::uses('AppController', 'Controller');
/**
 * PostCategories Controller
 *
 * @property PostCategory $PostCategory
 */
class PostCategoriesController extends AppController {

    var $components = array('Seo');
    public $helpers = array('Cache', 'Shortcode');
    var $uses = array('PostCategory', 'Post');
    
    public $paginate = array('Post' => array() );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'search');
    }  
    
    function search () {
        debug ( $this->request->params );
        
        $seoText = array();
        $seoText['term'] = null;
        $searchTerm = array();
        //$categoryId = null;
        // check if category
        if ( isset($this->request->params['named']['category'])) {
            $slug = Sanitize::paranoid($this->request->params['named']['category'] , array( '_', '-') ); debug($slug);
            $result = $this->PostCategory->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); debug($result);
            
            if ( $result['PostCategory']['parent_id'] == null) {
                $parentId = $result['PostCategory']['id'];
                $categoryId = $this->PostCategory->find('list', 
                                array('conditions' => array('PostCategory.parent_id' => $parentId), 
                                        'fields' => array('id'), 
                                        'contain' => false) );
               
            } else {
                $categoryId = $result['PostCategory']['id'];  
                
            }
            $seoText['term'][] = $result['PostCategory']['name'];
        }
        
        // city param
        if ( isset($this->request->params['named']['city'])) {
            $slug = Sanitize::paranoid($this->request->params['named']['city'] , array( '_', '-') ); debug($slug);
            $result = $this->Post->City->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); debug($result);
            $cityId = $result['City']['id'];  
            $seoText['location'][] = $result['City']['name'];
        }
        
        
            $this->paginate = array( 'Post' => array(
                    'limit' => 8,
                    'conditions' => array('Post.publish_state_id' => VENUE_PUBLISHED
                                            //'Post.post_category_id' => $categoryId
                    //'VenuesVenueFeature.venue_feature_id' => $featureId,    
                    //'Venue.city_id' => 36,
                    //'Venue.city_region_id',
                    //'Venue.city_neighbourhood_id',
                    //'Venue.province_id'
                        
                        ), // conditions for city, region, neighbourhood 
                    'fields' => array('id', 'name', 'sub_name', 'dek', 'slug', 'post', 'created', 'image_1'),
                    'contain' => array(
                       'PostCategory.name',
                        ),
                //'group' => array('Venue.id')
                    'order' => array('Post.created DESC')
                    )
                );
            
           if ( isset($categoryId)) {
               $this->paginate['Post']['conditions']['Post.post_category_id'] = $categoryId;
           } 
           if (!isset($categoryId)) {
                unset($this->paginate['Post']['contain']['PostCategory.name']);
           }
           
           if (isset($cityId)) {
               $this->paginate['Post']['conditions']['Post.city_id'] = $cityId;
           }
           
             	
            
            debug($this->paginate); 
            
           $this->Post->recursive = 0;
           $this->set('posts', $this->paginate('Post')); 
           
           debug($seoText);
           
           if ( isset($this->request->params['paging']['Venue']['page'])) {
               $pageNumber = $this->request->params['paging']['Venue']['page'] . ' - ' . $this->request->params['paging']['Venue']['pageCount'];
           }
           
           $default = 'News and reviews';    
           $seo = $this->Seo->setSearchMeta( $seoText['term'] ,$seoText['location'], $pageNumber, $default);
          
           $searchTerm = $seo['keywords'];
           $metaDescription = $seo['desc'];
           $metaKeywords = $seo['keywords'];
           
           $this->set('title_for_layout', $seo['title']);
           
            $openGraph = $this->Seo->setOpengraph( array(
                    'seo' => $seo, 
                    'url' => Configure::read('Website.url') . $this->request->here
                ) );            
           
           
           
          
           
           
            $this->set( compact( 'searchTerm', 'seo', 'openGraph', 'metaDescription', 'metaKeywords'));
    }

    public function index() {
            $this->PostCategory->recursive = 0;
            $this->set('postCategories', $this->paginate());
    }
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->PostCategory->recursive = 0;
		$this->set('postCategories', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->PostCategory->id = $id;
		if (!$this->PostCategory->exists()) {
			throw new NotFoundException(__('Invalid post category'));
		}
		$this->set('postCategory', $this->PostCategory->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PostCategory->create();
			if ($this->PostCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The post category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post category could not be saved. Please, try again.'));
			}
		}
		$parentPostCategories = $this->PostCategory->ParentPostCategory->find('list');
		$this->set(compact('parentPostCategories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->PostCategory->id = $id;
		if (!$this->PostCategory->exists()) {
			throw new NotFoundException(__('Invalid post category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PostCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The post category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post category could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PostCategory->read(null, $id);
		}
		$parentPostCategories = $this->PostCategory->ParentPostCategory->find('list');
		$this->set(compact('parentPostCategories'));
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
		$this->PostCategory->id = $id;
		if (!$this->PostCategory->exists()) {
			throw new NotFoundException(__('Invalid post category'));
		}
		if ($this->PostCategory->delete()) {
			$this->Session->setFlash(__('Post category deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post category was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

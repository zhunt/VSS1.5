<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {
    
    var $components = array('Seo');
    var $helpers = array('Shortcode', 'Cache');
    
    public $paginate = array('Post' => array() );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('view', 'index');
    }   
    
    public $cacheAction = array(
        'view' => 36000,
        'index' => '+12 hours',
    );     
    
/**
 * index method
 *
 * @return void
 */
	public function index() {
            
            if ($this->RequestHandler->isRss() ) { 
                $posts = $this->Post->find('all', array('conditions' => array('Post.publish_state_id' => VENUE_PUBLISHED ), 'contain' => false,  'limit' => 20,  'order' => 'Post.created DESC'));
                return $this->set(compact('posts'));
            }  else {            
                $this->paginate = array( 'Post' => array('order' => 'Post.created desc') );
                    $this->Post->recursive = 0;
                    $this->set('posts', $this->paginate('Post'));
            }
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            
             $slug = Sanitize::paranoid( $this->params['slug'], array( '_', '-') );
             if (!$slug) {
                throw new NotFoundException(__('Invalid slug'));
             }
             
             // ** Doesn't check for not published **
             $post = $this->Post->findBySlug($slug);
             
            // set the SEO fields
            $seo = $this->Seo->setPostMeta($post);
           // debug($seo);
            $this->set('title_for_layout', $seo['title'] );
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];

            $openGraph = $this->Seo->setOpengraph( array(
                        'seo' => $seo, 
                        'url' => Configure::read('Website.url') . $this->request->here,
                        'post' => $post
                    ) );
            
            
            // ***** get related posts *****
            // get tag ids
            
            //debug($post);
            $tags = Hash::extract($post, 'PostTag.{n}.id');
            //debug($tags);
            $relatedPosts = array();
            if ($tags) {
                
                $this->Post->bindModel(array('hasOne' => array('PostsPostTag')), false );
                $this->Post->contain(array('PostsPostTag'));
                
                //$fullList = array();
                $fullList2 = array();
                
                foreach($tags as $tag) {
                    $result = $this->Post->find('all', array(
                        'conditions' => array( 'PostsPostTag.post_tag_id' => $tag,
                            'Post.id !=' => $post['Post']['id'],
                            'Post.publish_state_id' => VENUE_PUBLISHED
                            ),
                        'fields' => array('id', 'name')
                        
                    ));
                    //debug($result);
                    $titles = Hash::extract($result, '{n}.Post.name');
                    $titlesId = Hash::extract($result, '{n}.Post.id');
                    //$newTitles = array_combine($titlesId, $titles);
                  
                    //$fullList = array_merge_recursive($fullList, $titles );
                    $fullList2 = array_merge_recursive($fullList2, $titlesId );
                }
              
                $counts2 = array_count_values($fullList2);
                
                arsort($counts2);
                
                $postIds = array_slice($counts2, 0, 5, true); //debug($postIds);
                $relatedPosts = array();
                foreach ($postIds as $id => $count) {
                    
                    $relatedPosts[] = $this->Post->find('first', array('conditions' => array('Post.id' => $id), 'contain' => false, 'fields' => array('name', 'slug', 'dek', 'image_1')));
                    
                }
                
                //debug($relatedPosts);
                
            }
            // ***** get related posts END *****
            
            
            // ** get map points **
            if ( !empty($post['Map']) ) {
                $mapData = $this->Post->Map->find('first', array('conditions' => array('Map.id' => $post['Map']['id'])));
                $this->set( compact('mapData'));
            }
            
            
            $showAdminPanel = false;
            if ( $this->isAuthorized($this->Auth->user() ) )
                $showAdminPanel = true;            
             
             $this->set( compact('post', 'metaDescription', 'metaKeywords', 'openGraph', 'showAdminPanel', 'relatedPosts' ) );
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		$relatedBusinessTypes = $this->Post->RelatedBusinessType->find('list');
		$provinces = $this->Post->Province->find('list');
		$postCategories = $this->Post->PostCategory->find('list');
		$postAuthors = $this->Post->PostAuthor->find('list');
		$venues = $this->Post->Venue->find('list');
		$cities = $this->Post->City->find('list');
		$publishStates = $this->Post->PublishState->find('list');
		$postTags = $this->Post->PostTag->find('list');
		$this->set(compact('relatedBusinessTypes', 'provinces', 'postCategories', 'postAuthors', 'venues', 'cities', 'publishStates', 'postTags'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$relatedBusinessTypes = $this->Post->RelatedBusinessType->find('list');
		$provinces = $this->Post->Province->find('list');
		$postCategories = $this->Post->PostCategory->find('list');
		$postAuthors = $this->Post->PostAuthor->find('list');
		$venues = $this->Post->Venue->find('list');
		$cities = $this->Post->City->find('list');
		$publishStates = $this->Post->PublishState->find('list');
		$postTags = $this->Post->PostTag->find('list');
		$this->set(compact('relatedBusinessTypes', 'provinces', 'postCategories', 'postAuthors', 'venues', 'cities', 'publishStates', 'postTags'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->Post->delete()) {
			$this->Session->setFlash(__('Post deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Post->recursive = 0;
		$this->set('posts', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('post', $this->Post->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		$relatedBusinessTypes = $this->Post->RelatedBusinessType->find('list', array('order' => 'name'));
		$provinces = $this->Post->Province->find('list', array('order' => 'name'));
		$postCategories = $this->Post->PostCategory->find('list', array('order' => 'name'));
		$postAuthors = $this->Post->PostAuthor->find('list', array('order' => 'name'));
		$venues = $this->Post->Venue->find('list', array('order' => 'name'));
		$cities = $this->Post->City->find('list', array('order' => 'name'));
                $maps = $this->Post->Map->find('list', array('order' => 'name'));
		$publishStates = $this->Post->PublishState->find('list');
		$postTags = $this->Post->PostTag->find('list', array('order' => 'name'));
		$this->set(compact('relatedBusinessTypes', 'provinces', 'postCategories', 'postAuthors', 'venues', 'cities', 'maps', 'publishStates', 'postTags'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
                
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$relatedBusinessTypes = $this->Post->RelatedBusinessType->find('list', array('order' => 'name'));
		$provinces = $this->Post->Province->find('list', array('order' => 'name'));
		$postCategories = $this->Post->PostCategory->find('list', array('order' => 'name'));
		$postAuthors = $this->Post->PostAuthor->find('list', array('order' => 'name'));
                
		$venues = $this->Post->Venue->find('list', array(
                        'recursive' => 0,
                        'order' => array('City.name', 'Venue.full_name'),
                        'conditions' => array('Venue.publish_state_id' => VENUE_PUBLISHED), 
                        'fields' => array('Venue.id', 'Venue.full_name', 'City.name') 
                        ) 
                        );
                
		$cities = $this->Post->City->find('list', array('order' => 'name'));
                $maps = $this->Post->Map->find('list', array('order' => 'name'));
		$publishStates = $this->Post->PublishState->find('list');
		$postTags = $this->Post->PostTag->find('list');
		$this->set(compact('relatedBusinessTypes', 'provinces', 'postCategories', 'postAuthors', 'venues', 'cities', 'maps', 'publishStates', 'postTags'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->Post->delete()) {
			$this->Session->setFlash(__('Post deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

}


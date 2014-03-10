<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 */
class CitiesController extends AppController {
    var $uses = array('Venue', 'City', 'Province');
    var $components = array('Seo');
    public $helpers = array('Cache');
    
    public $cacheAction = array(
        'view' => 36000,
        'index'  => 48000
    );     
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view');
    }    

/**
 * index method
 *
 * @return void
 */
        /*
         * Displays list of cities grouped by province
         */
	public function index() {
            
            $provinces = $this->Province->find('all', array(
                    'fields' => array('name', 'slug'),
                    'order' => 'Province.name ASC',
                    'contain' => array('City' => array('order' => 'City.name ASC', 'conditions' => array('venue_count >' => 0), 'fields' => array( 'name', 'slug', 'venue_count') ) )
                    )
                );
            
           //debug($provinces);
            $seo = $this->Seo->setCityPageMeta( array(
                                                'descText' => 'List of bookstores across Canada by province and city', 
                                                'titleText' => 'Bookstores by city and province',
                                                'keywords' => array('Vancouver', 'Victoria', 'Burnaby', 'Abbotsford') ));
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];
           
            $this->set('title_for_layout', $seo['title']);
            
            $openGraph = $this->Seo->setOpengraph( array(
                    'seo' => $seo, 
                    'url' => Configure::read('Website.url') . $this->request->here
                ) );              
		
            $this->set( compact( 'provinces', 'seo', 'openGraph', 'metaDescription', 'metaKeywords') );
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view() {
            
             $slug = Sanitize::paranoid( $this->params['slug'], array( '_', '-') );
             if (!$slug) {
                throw new NotFoundException(__('Invalid slug'));
             }
             
             $city = $this->City->findBySlug($slug);
             //debug($slug); debug($city);
             
             if (!$city) {
                 throw new NotFoundException(__('You have discovered a new city, we can not help you.'));
             }
           
             $cityId = intval($city['City']['id']);
             // get the newest listing for this city
            $result = $this->Venue->find('all', array(
                                        'conditions' => array('Venue.publish_state_id ' => VENUE_PUBLISHED, 'Venue.city_id' => $cityId ),
                                        'fields' => array('name','slug', 'sub_name', 'geo_lat', 'geo_lng', 'seo_desc'),    
                                        'contain' => array('City.name', 'Province.name', 'BusinessType1.name'),
                                        'order' => 'Venue.created DESC',
                                        'limit' => 4) 
                                    );
            $newVenues = $result; //debug($newVenues); exit;
            
            // get the regions and neighbourhoods
            $regions = $this->City->find('all', array(
                                    'conditions' => array( 'City.id' => $cityId ),
                                    'contain' => array('CityRegion', 'CityNeighbourhood')
                                    ) 
                                );
           //debug($regions);  exit;
           $cities = $city;
           
           // products 
           $products = $this->Venue->find('all', array(
                   'conditions' => array('Venue.publish_state_id ' => VENUE_PUBLISHED, 'Venue.city_id' => $cityId ),
                   'fields' => array('name'),
                   'contain' => array(
                       'VenueFeature' => array('fields' => array('name', 'slug', 'group'), 'conditions' => array('flag_show' => true) ))
                   )
                   );
         // debug($products);  
          
          $features = Hash::extract( $products, '{n}.VenueFeature.{n}' );
           
           $slugs = Hash::extract( $products, '{n}.VenueFeature.{n}.slug' );
           $totals = array_count_values($slugs);
           
           $newFeatures = array();
           $products = array();
           $services = array();
           $amenities = array();
           foreach ( $features as $i => $row) {
               $slug = $row['slug'];
               $features[$i]['count'] = $totals[$slug];
               unset($features[$i]['VenuesVenueFeature'] );
               $newFeatures[$slug] = $features[$i];
               
               if ( $row['group'] == 'SERVICE')
                   $services[$slug] = $features[$i];
               else if ( $row['group'] == 'PRODUCT')
                   $products[$slug] = $features[$i];
               else if ( $row['group'] == 'AMENITY')
                   $amenities[$slug] = $features[$i];
           }
           
           asort( $newFeatures );
           asort( $services );
           asort( $products );
           asort( $amenities );
           
           // get list of chains for this city
           $chains = $this->Venue->find('all', array(
                   'conditions' => array('Venue.publish_state_id ' => VENUE_PUBLISHED, 'Venue.city_id' => $cityId, 'Venue.chain_id >' => 0 ),
                   'fields' => array('name'),
                   'contain' => array(
                       'Chain' => array('fields' => array('name', 'slug'), 'order' => 'Chain.name ASC' ))
                   )
                   );
         
           $cityChains = Hash::combine($chains, '{n}.Chain.slug', '{n}.Chain.name' );
           //debug($chains);
           
           // get list of venue types for this city
          $businessTypes = $this->Venue->find('all', array(
                   'conditions' => array('Venue.publish_state_id ' => VENUE_PUBLISHED, 'Venue.city_id' => $cityId ),
                   'fields' => array('name'),
                   'contain' => array(
                       'BusinessType1' => array('fields' => array('name', 'slug'), 'order' => 'BusinessType1.name ASC' ),
                       'BusinessType2' => array('fields' => array('name', 'slug'), 'order' => 'BusinessType2.name ASC' ),
                       'BusinessType3' => array('fields' => array('name', 'slug'), 'order' => 'BusinessType3.name ASC' )
                       )
                   )
                   );           
           //debug($businessTypes);
           $businessTypes1 = Hash::combine($businessTypes, '{n}.BusinessType1.slug', '{n}.BusinessType1.name' );
           $businessTypes2 = Hash::combine($businessTypes, '{n}.BusinessType2.slug', '{n}.BusinessType2.name' );
           $businessTypes3 = Hash::combine($businessTypes, '{n}.BusinessType3.slug', '{n}.BusinessType3.name' );

           $businessTypes = array_merge($businessTypes1, $businessTypes2, $businessTypes3);
           unset($businessTypes['']);
           asort($businessTypes);
           
           $cityBusinessTypes = $businessTypes;
           
            // set the SEO fields
            $seo = $this->Seo->setCityMeta($cities, array('descText' => 'Bookstores in ', 'titleText' => 'Bookstores, Comics, Used Books'));
             
            $this->set('title_for_layout', $seo['title'] );
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];  
            
            $openGraph = $this->Seo->setOpengraph( array(
                    'seo' => $seo, 
                    'url' => Configure::read('Website.url') . $this->request->here
                ) );              
            

           $this->set( compact('newVenues', 'cities', 'cityChains', 'cityBusinessTypes', 'regions', 'services', 'products', 'amenities', 'seo', 'openGraph', 'metaDescription', 'metaKeywords') );  
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->City->recursive = 0;
		$this->set('cities', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->City->id = $id;
		if (!$this->City->exists()) {
			throw new NotFoundException(__('Invalid city'));
		}
		$this->set('city', $this->City->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$this->Session->setFlash(__('The city has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.'));
			}
		}
		$provinces = $this->City->Province->find('list');
		$parentCities = $this->City->ParentCity->find('list');
		$this->set(compact('provinces', 'parentCities'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->City->id = $id;
		if (!$this->City->exists()) {
			throw new NotFoundException(__('Invalid city'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->City->save($this->request->data)) {
				$this->Session->setFlash(__('The city has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->City->read(null, $id);
		}
		$provinces = $this->City->Province->find('list');
		$parentCities = $this->City->ParentCity->find('list');
		$this->set(compact('provinces', 'parentCities'));
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
		$this->City->id = $id;
		if (!$this->City->exists()) {
			throw new NotFoundException(__('Invalid city'));
		}
		if ($this->City->delete()) {
			$this->Session->setFlash(__('City deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('City was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

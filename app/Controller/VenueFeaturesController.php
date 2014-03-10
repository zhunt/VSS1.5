<?php
App::uses('AppController', 'Controller');
/**
 * VenueFeatures Controller
 *
 * @property VenueFeature $VenueFeature
 */
class VenueFeaturesController extends AppController {

    var $uses = array('VenueFeature', 'Venue', 'Province');
    var $components = array('Seo');
    public $helpers = array('Cache');
    
    public $paginate = array('Venue' => array() );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'search');
    }  
    
    public $cacheAction = array(
        'view' => 36000,
        'index'  => 48000
    );     

/**
 * index method
 *
 * @return void
 */
	public function index($type = null) { 
            
            if ( $type == 'product')
                $type = 'PRODUCT';
            else
                $type = 'SERVICE';

            $provinces = $this->Province->find('all', array(
                    'fields' => array('name', 'slug'),
                    'order' => 'Province.name ASC',
                    'contain' => array(
                        'City' => array(
                            'order' => 'City.name ASC', 
                            'conditions' => array('venue_count >' => 0), 
                            'fields' => array( 'name', 'slug', 'venue_count'),
                            'Venue' => array('fields' => array( 'id' ), 
                                'VenueFeature' => array(
                                    'fields' => array('name', 'slug', 'group'), 
                                    'conditions' => array('VenueFeature.group' => $type, 'VenueFeature.flag_show' => TRUE ) ) )
                            ),
                          
                        )
                    )
                );
            
            // now pull out the features for each city, combine and build count 
            foreach ( $provinces as $i => $city ) {
                foreach( $city['City'] as $j => $venue) {
                    $pathName = $i . '.City.' . $j . '.Venue.{n}.VenueFeature.{n}.name';
                    $pathSlug = $i . '.City.' . $j . '.Venue.{n}.VenueFeature.{n}.slug';
                    
                    //debug($path);
                    $resultName = Hash::extract($provinces, $pathName); 
                    $resultSlug = Hash::extract($provinces, $pathSlug); 
                    $features = array_combine($resultSlug, $resultName  );
                    $totals = array_count_values($resultSlug);
                    $featureAndCount = array_merge_recursive($features, $totals);
                    //debug($featureAndCount);
                    unset( $provinces[$i]['City'][$j]['Venue'] ); // get rid of Venue & VenueFeature - not needed
                    $provinces[$i]['City'][$j]['features'] = $featureAndCount;
                }
            }
            
            //debug($provinces);
           
            // ----------------
            
            if ( $type == 'PRODUCT') {
                $seo = $this->Seo->setCityPageMeta( array(
                                                'descText' => 'List bookstores in BC by city', 
                                                'titleText' => 'bookstore features by City and Province',
                                                'keywords' => array('bookstores', 'comic books', 'used books', 'Canada') ));
                $displayType = 'Bookstore Features';
                $displayTypeSlug = 'product';
            } else  { // services
                $seo = $this->Seo->setCityPageMeta( array(
                                                'descText' => 'List of bookstores by Province and city', 
                                                'titleText' => 'Bookstores Services and Amenities by City and Province',
                                                'keywords' => array('bookstores', 'comic books', 'used books') ));  
                $displayType = 'Bookstore Services';
                $displayTypeSlug = 'service';
            }
            
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];
           
            $this->set('title_for_layout', $seo['title']);  
            
            $openGraph = $this->Seo->setOpengraph( array(
                    'seo' => $seo, 
                    'url' => Configure::read('Website.url') . $this->request->here
                ) );                
		
            $this->set( compact( 'provinces', 'displayType', 'displayTypeSlug', 'seo', 'openGraph', 'metaDescription', 'metaKeywords') );
            
	}
        
        
        /*
         * General feature search funtion
         * also handles searching provinces, citys, city regions, etc.
         */
        public function search() {
           // debug ( $this->request->params );
            
                $seoText = array();
                $seoText['term'] = null;
                $searchTerm = array();
               
             // check if city/city_region/neighbourhood/etc passed in  
             if ( isset($this->request->params['named']['city'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['city'] , array( '_', '-') );
                $result = $this->Venue->City->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                $cityId = $result['City']['id'];  
                $seoText['location'][] = ' in city of ' . $result['City']['name'];
             }  
             if ( isset($this->request->params['named']['city_neighbourhood'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['city_neighbourhood'] , array( '_', '-') ); 
                $result = $this->Venue->CityNeighbourhood->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                $cityNeighbourhoodId = $result['CityNeighbourhood']['id'];
                $seoText['location'][] = ' in '. $result['CityNeighbourhood']['name'];
             }
             if ( isset($this->request->params['named']['city_region'])) {
                 $slug = Sanitize::paranoid($this->request->params['named']['city_region'] , array( '_', '-') ); 
                 $result = $this->Venue->CityRegion->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                 $cityRegionId = $result['CityRegion']['id'];
                 $seoText['location'][] = ' in '. $result['CityRegion']['name'];
             }
             if ( isset($this->request->params['named']['province'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['province'] , array( '_', '-') );  
                $result = $this->Province->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) );
                $provinceId = $result['Province']['id'];
                $seoText['location'][] = ' in '. $result['Province']['name'];
             }
             
             // check for product / service / amenity / etc.
              $featureId = null;
              
             if ( isset($this->request->params['named']['product'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['product'] , array( '_', '-') );  
                $result = $this->Venue->VenueFeature->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                $featureId = $result['VenueFeature']['id'];  
                $seoText['term'][] = $result['VenueFeature']['name'];
                $searchTerm[] = $result['VenueFeature']['name'];
             }
             if ( isset($this->request->params['named']['service'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['service'] , array( '_', '-') );  
                $result = $this->Venue->VenueFeature->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                $featureId = $result['VenueFeature']['id'];  
                $seoText['term'][] = $result['VenueFeature']['name'];
                $searchTerm[] = $result['VenueFeature']['name'] . ' service';
             }             
             if ( isset($this->request->params['named']['amenity'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['amenity'] , array( '_', '-') );  
                $result = $this->Venue->VenueFeature->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                $featureId = $result['VenueFeature']['id'];  
                $seoText['term'][] = $result['VenueFeature']['name'];
                $searchTerm[] = $result['VenueFeature']['name'];
             }    
             if ( isset($this->request->params['named']['store_type'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['store_type'] , array( '_', '-') );  
                $result = $this->Venue->VenueFeature->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) ); 
                $featureId = $result['VenueFeature']['id'];  
                $seoText['term'][] = $result['VenueFeature']['name'];
                $searchTerm[] = $result['VenueFeature']['name'];
             } 
             
             // store category ( computer store, video games, etc. )
             if ( isset($this->request->params['named']['business_category'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['business_category'] , array( '_', '-') );  
                $result = $this->Venue->BusinessType1->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) );
                $storeCategoryId = $result['BusinessType1']['id'];  
                $seoText['term'][] = $result['BusinessType1']['name'];
                $searchTerm[] = $result['BusinessType1']['name'];
             }
             
             // chain
             if ( isset($this->request->params['named']['chain'])) {
                $slug = Sanitize::paranoid($this->request->params['named']['chain'] , array( '_', '-') );  
                $result = $this->Venue->Chain->find('first', array('conditions' => array('slug' => $slug), 'contain' => false) );
                $chainId = $result['Chain']['id'];  
                $seoText['term'][] = $result['Chain']['name'];
                $searchTerm[] = $result['Chain']['name']. ' locations';
             }             
             
             
             
             // now build query
            $this->Venue->bindModel(array('hasOne' => array('VenuesVenueFeature')), false );
            $this->Venue->contain(array('VenuesVenueFeature'));
            
            $this->paginate = array( 'Venue' => array(
                    'limit' => 8,
                    'conditions' => array('Venue.publish_state_id' => VENUE_PUBLISHED,
                    'VenuesVenueFeature.venue_feature_id' => $featureId,    
                    //'Venue.city_id' => 36,
                    //'Venue.city_region_id',
                    //'Venue.city_neighbourhood_id',
                    //'Venue.province_id'
                        
                        ), // conditions for city, region, neighbourhood 
                    'fields' => array('id', 'name', 'sub_name', 'address', 'slug', 'geo_lat','geo_lng', 'seo_desc'),
                    'contain' => array(
                       'VenuesVenueFeature',
                        'BusinessType1.name', 'BusinessType2.name', 'BusinessType3.name',
                        'City.name', 'Intersection.name',
                        'VenueFeature' => array('conditions' => array('VenueFeature.id' => $featureId ), 'fields' => 'name')
                        ),
                'group' => array('Venue.id')
                
                    )
                );
            
           if ( isset($storeCategoryId)) {
               $this->paginate['Venue']['conditions']['OR'] = array(
                   'Venue.business_type_1_id' => $storeCategoryId,
                   'Venue.business_type_2_id' => $storeCategoryId,
                   'Venue.business_type_3_id' => $storeCategoryId
                   );
           }
           
           if (!isset($featureId)) {
               unset($this->paginate['Venue']['conditions']['VenuesVenueFeature.venue_feature_id']); 
               unset($this->paginate['Venue']['contain']['VenueFeature']); 
               unset($this->paginate['Venue']['contain']['VenuesVenueFeature']); 
           }
            
           if ( isset($cityId)) {
               $this->paginate['Venue']['conditions']['Venue.city_id'] = $cityId;
           } 
           if ( isset($cityRegionId)) {
               $this->paginate['Venue']['conditions']['Venue.city_region_id'] = $cityRegionId;
           }     
           if ( isset($cityNeighbourhoodId)) {
               $this->paginate['Venue']['conditions']['Venue.city_neighbourhood_id'] = $cityNeighbourhoodId;
           }             
           if ( isset($provinceId)) {
               $this->paginate['Venue']['conditions']['Venue.province_id'] = $provinceId;
           }             
           if ( isset($chainId)) {
               $this->paginate['Venue']['conditions']['Venue.chain_id'] = $chainId;
           }            
           
          //debug( $this->paginate['Venue'] ); 
          //debug( $this->paginate('Venue') );
           $this->VenueFeature->recursive = 0;
           $this->set('venues', $this->paginate('Venue')); 
          
           
           if ( isset($this->request->params['paging']['Venue']['page'])) {
               $pageNumber = $this->request->params['paging']['Venue']['page'] . ' - ' . $this->request->params['paging']['Venue']['pageCount'];
           }
           
         
           $default = 'Bookstore services and amenities';    
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
        
        

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->VenueFeature->recursive = 0;
		$this->set('venueFeatures', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->VenueFeature->id = $id;
		if (!$this->VenueFeature->exists()) {
			throw new NotFoundException(__('Invalid venue feature'));
		}
		$this->set('venueFeature', $this->VenueFeature->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->VenueFeature->create();
			if ($this->VenueFeature->save($this->request->data)) {
				$this->Session->setFlash(__('The venue feature has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The venue feature could not be saved. Please, try again.'));
			}
		}
		$businessTypes = $this->VenueFeature->BusinessType->find('list');
		$this->set(compact('businessTypes'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->VenueFeature->id = $id;
		if (!$this->VenueFeature->exists()) {
			throw new NotFoundException(__('Invalid venue feature'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VenueFeature->save($this->request->data)) {
				$this->Session->setFlash(__('The venue feature has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The venue feature could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->VenueFeature->read(null, $id);
		}
		$businessTypes = $this->VenueFeature->BusinessType->find('list');
		$this->set(compact('businessTypes'));
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
		$this->VenueFeature->id = $id;
		if (!$this->VenueFeature->exists()) {
			throw new NotFoundException(__('Invalid venue feature'));
		}
		if ($this->VenueFeature->delete()) {
			$this->Session->setFlash(__('Venue feature deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Venue feature was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

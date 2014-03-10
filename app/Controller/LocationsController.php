<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');

/**
 * Locations Controller
 *
 * @property Location $Location
 */
class LocationsController extends AppController {
    

    var $uses = array();
    var $components = array('Location');
    
    var $addressData, $rawData;
        
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('map');
    }
	
	/*
	* map method
	* display map of venues
	*/
	public function map( $id = null) {
		if ($id != null) {
			$this->Location->id = $id;
			if (!$this->Location->exists()) {
				throw new NotFoundException(__('Invalid location'));
			}
			$this->set('location', $this->Location->read(null, $id));
		} else {
			$this->set('location', $this->Location->find('all') );
			
			$mapCords = $this->Location->find('all');
			$map = array();
			
			//debug($mapCords); exit;
			
			foreach ( $mapCords as $cord) {
				$map[] = array('id' => $cord['Location']['id'], 
								'name' => $cord['Location']['name'], 
								'address' => $cord['Location']['address'],
								'geo_lat' => $cord['Location']['geo_lat'],
								'geo_lng' => $cord['Location']['geo_long']  );
			}
			
			$this->set('mapJson', json_encode($map) );

		}
				
	}
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Location->recursive = 0;
		$this->set('locations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		$this->set('location', $this->Location->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Location->create();
			if ($this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.'));
			}
		}
		$businessTypes = $this->Location->BusinessType->find('list');
		$this->set(compact('businessTypes'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Location->read(null, $id);
		}
		$businessTypes = $this->Location->BusinessType->find('list');
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
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		if ($this->Location->delete()) {
			$this->Session->setFlash(__('Location deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Location was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
    /* 
     * Returns latt/long of an address (used on frot end?)
     */
    function geocode_address() {
        Configure::write('debug',0);
        $this->autoRender = false;
        
        $data = array();
        $address = $this->params['url']['address'];
        
        $locationInfo = $this->Location->geocodeAddress($address);
        

        if ($locationInfo ) {       
            $data['status'] = 'ok';
            $data['lat'] = $locationInfo['lat'];
            $data['lng'] = $locationInfo['lng'];
        }
        else {
            $data['status'] = $status;
        }

        //$data = array( 'status' => 'ok', 'lat' => 1.0, 'lng' => 2.5 );
        echo json_encode( $data );
    }

    


    /*
     * Geo-codes a new venue
     * Called by encoder form on venue index page
     */
    function admin_encode_address() {
        
        $this->loadModel('Venue');
        $this->Venue->VenueDetail->Behaviors->unload('Sluggable');
       // Configure::write('debug',0);
       
        //$this->autoRender = false;
        
        
        $address = trim($this->data['Venue']['raw_address']);
        
        $locationInfo = $this->Location->geocodeAddress($address);

        if ( isset($this->data['Venue']['phone']) ) {
                $phone = trim($this->data['Venue']['phone']);

        }else {
                $phone = '000.000.0000';
        }
        $trackingNumber =  preg_replace("/[^0-9]/","", $phone );


        if ( isset($this->data['Venue']['website']) ) {
                $website = trim($this->data['Venue']['website']);
        }else {
                $website = '';
        }
        
        /* Got this back:
         * array(
	'lat' => (float) 45.516322,
	'lng' => (float) -73.5776725,
	'street_address' => '3895 Boulevard Saint-Laurent',
	'postal_code' => 'H2W 1L2',
	'province' => 'Quebec',
	'province_id' => '5',
	'region' => 'Communauté-Urbaine-de-Montréal',
	'region_id' => '27',
	'city' => 'Montreal',
	'city_id' => '41',
	'city_region' => null,
	'city_region_id' => false,
	'city_neighbourhood' => 'Mile End',
	'city_neighbourhood_id' => '31'
)
         */

            $data = array(
                'Venue' => array(
                    'name' => $this->data['Venue']['name'],
                    'slug' => '',
                    'sub_name' => '',
                    'address' => $this->_stripWhitespace( $locationInfo['street_address'] ),
                    'postal_code' => $locationInfo['postal_code'],
                    'phone_1' => $phone,
                    'website_url' => $website,
                    'geo_lat' => $locationInfo['lat'],
                    'geo_lng' => $locationInfo['lng'],
                    'province_id' => $locationInfo['province_id'],
                    'region_id' => $locationInfo['region_id'],
                    'city_id' => $locationInfo['city_id'],
                    'city_region_id' => ($locationInfo['city_region_id']) ? $locationInfo['city_region_id'] : 0,
                    'city_neighbourhood_id' => ($locationInfo['city_neighbourhood_id']) ? $locationInfo['city_neighbourhood_id'] : 0,
                    'intersection_id' => 0,
                    'publish_state_id' => 0,
                    'chain_id' => 0,
                    'tracking_num' => $trackingNumber
                    ),
                'VenueDetail' => array( 
                    'streetview_lat' => $locationInfo['lat'], 
                    'streetview_lng' => $locationInfo['lng'], 
                    'streetview_heading' => 0, 
                    'streetview_pitch' => 0, 
                    'streetview_zoom' => 1  
                    )
            );

            // try and guess intersection and region by looking at nearby venues
            $nearbyVenue = $this->Location->getNearbyIntersection($locationInfo['lat'], $locationInfo['lng']);
            
            if ( ($data['Venue']['city_region_id'] < 1) && $nearbyVenue['cityRegionId'] ) 
                $data['Venue']['city_region_id'] = $nearbyVenue['cityRegionId'];
            
            if ( ($data['Venue']['city_neighbourhood_id'] < 1) && $nearbyVenue['cityNeighbourhoodId'] ) 
                $data['Venue']['city_neighbourhood_id'] = $nearbyVenue['cityNeighbourhoodId'];
            
            if ( $nearbyVenue['intersectionId'] ) 
                $data['Venue']['intersection_id'] = $nearbyVenue['intersectionId'];
            
            // finally set the seo fields
            
            $intersection = '';
            if ( !empty($nearbyVenue['intersectionName']))
                $intersection = ', near ' . $nearbyVenue['intersectionName'] . ' ';
            
            $data['Venue']['seo_title'] = $data['Venue']['name'];
            $data['Venue']['seo_desc'] = $data['Venue']['name'] . ' is at ' . $data['Venue']['address'] . $intersection . ' in ' . $locationInfo['city'];
            $data['Venue']['description'] = '<p><b>' . $data['Venue']['name'] . 
                                                '</b> is at ' . $data['Venue']['address'] . $intersection . ' in ' . 
                                                $locationInfo['city'] . '</p>';


            $this->Venue->create();
            $this->Venue->saveAll($data ); // array('validate' => false)
            
            if ($this->Venue->validates()) {
                $venueId = $this->Venue->id;
                $this->redirect( '/admin/venues/edit/' . $venueId );
            } else {
                // didn't validate logic
               debug($this->Venue->validationErrors);
               exit;
            }
            
    }
    



    
    
    /* 
     * Returns latt/long of an address
     */
    function admin_geocode_address() {
        Configure::write('debug',0);
        //debug($this->params);
        // s$data = array();
        $address = $this->params['url']['address'];
        $this->autoRender = false;

        $result = $this->Location->geocodeAddress($address);

        if ( $result ) {
            $data['status'] = 'ok';
            $data['lat'] = $result['lat'];
            $data['lng'] = $result['lng'];
        }
        else {
            $data['status'] = $status;
        }

        echo json_encode( $data );
    }    
    /* -------------------------- */
  
    
    /*
     * Utility functions
     * 
     */
    function _stripWhitespace( $text) {
        return( trim(preg_replace('/\s\s+/', ' ', $text ) ) );
    }
}

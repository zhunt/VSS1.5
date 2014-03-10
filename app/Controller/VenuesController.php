<?php
App::uses('AppController', 'Controller');


// used for import
App::import('Vendor', 'phpQuery/phpQuery');

/**
 * Venues Controller
 *
 * @property Venue $Venue
 */
class VenuesController extends AppController {

    var $components = array('RequestHandler', 'Seo', 'VenueSupport', 'VenueFeatures', 'Location');
    var $helpers = array('Text', 'Time', 'Cache'); 
    
    public $paginate = array('Venue' => array() );

    public $cacheAction = array(
        'view' => 36000,
        'view_map' => 36000,
        'index' => '+12 hours',
    );   
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('view', 'index', 'view_redirect' ,'view_map');
    }       
    
    
    public function view_redirect() {
        $this->redirect( '/company/' . $this->params['slug'] , 301, true);
    }
    /*
     * list of new venues added
     */
    public function index() {
       if ($this->RequestHandler->isRss() ) { 
            $venues = $this->Venue->find('all', array(
                'conditions' => array('Venue.publish_state_id' => VENUE_PUBLISHED ), 
                'contain' => false,  
                'limit' => 20,  
                'order' => 'Venue.modified DESC'));
            return $this->set(compact('venues'));
        }        
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
             
             $venue = $this->Venue->findBySlug($slug);
             //debug($slug); debug($city);
             
             if (!$venue) {
                 throw new NotFoundException(__('You have discovered a new venue, we can not help you.'));
             }
             
             $geoCords = $venue['Venue']['geo_lat'] .',' . $venue['Venue']['geo_lng'];
            
            // set the SEO fields
            $seo = $this->Seo->setVenueMeta($venue);
             
            $this->set('title_for_layout', $seo['title'] );
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];
            
            $openGraph = $this->Seo->setOpengraph( array(
                        'seo' => $seo, 
                        'url' => Configure::read('Website.url') . $this->request->here,
                        'venue' => $venue
                    ) );
            
            $microformat = $this->Seo->setMicroformat($venue);
            
            // set-up store type, amenities, products, services
            $storetypes = $this->VenueFeatures->getVenueFeatures($venue, 'STORE_TYPE');
            $products = $this->VenueFeatures->getVenueFeatures($venue, 'PRODUCT');
            $services = $this->VenueFeatures->getVenueFeatures($venue, 'SERVICE');
            $amenities = $this->VenueFeatures->getVenueFeatures($venue, 'AMENITY');
            
            $storeCategories = array( 
                array( 'name' => $venue['BusinessType1']['name'], 'slug' => $venue['BusinessType1']['slug']),
                array( 'name' => $venue['BusinessType2']['name'], 'slug' => $venue['BusinessType2']['slug']),
                array( 'name' => $venue['BusinessType3']['name'], 'slug' => $venue['BusinessType3']['slug'])
                );
            
            $venuesNearby = $this->Venue->getNearbyVenues( $venue['Venue']['geo_lat'], $venue['Venue']['geo_lng'], $venue['Venue']['id'] );
            
            $venuesNearby = $this->VenueSupport->processNearbyVenues( $venuesNearby);
           
            //debug( $this->Auth->user() );
            //debug( $this->isAuthorized($this->Auth->user() ) );
            
            // show edit link if logged-in
            $showAdminPanel = false;
            if ( $this->isAuthorized($this->Auth->user() ) )
                $showAdminPanel = true;
            
            // debug($venuesNearby);
            $this->set( compact('venue', 'showAdminPanel', 'geoCords', 'seo', 'openGraph', 'microformat', 'metaDescription', 'metaKeywords', 'storetypes', 'storeCategories', 'amenities', 'services', 'products', 'venuesNearby'));
    }

        /*
         * Dispalys a larger, interactive map of venue
         * 
         * Does pretty much the exact same thing as regular view
         */
    public function view_map() {
            
             $slug = Sanitize::paranoid( $this->params['slug'], array( '_', '-') );
             if (!$slug) {
                throw new NotFoundException(__('Invalid slug'));
             }
             
             $venue = $this->Venue->findBySlug($slug);
           
             
             if (!$venue) {
                 throw new NotFoundException(__('You have discovered a new venue, we can not help you.'));
             }
             
             $geoCords = $venue['Venue']['geo_lat'] .',' . $venue['Venue']['geo_lng'];
            
            // set the SEO fields
            $seo = $this->Seo->setVenueMapMeta($venue);
             
            $this->set('title_for_layout', $seo['title'] );
            $metaDescription = $seo['desc'];
            $metaKeywords = $seo['keywords'];
            
            $openGraph = $this->Seo->setOpengraph( array(
                        'seo' => $seo, 
                        'url' => Configure::read('Website.url') . $this->request->here,
                        'venue' => $venue
                    ) );
            
            $microformat = $this->Seo->setMicroformat($venue);
            
            // set-up store type, amenities, products, services
            $storetypes = $this->VenueFeatures->getVenueFeatures($venue, 'STORE_TYPE');
            $products = $this->VenueFeatures->getVenueFeatures($venue, 'PRODUCT');
            $services = $this->VenueFeatures->getVenueFeatures($venue, 'SERVICE');
            $amenities = $this->VenueFeatures->getVenueFeatures($venue, 'AMENITY');
            
            $storeCategories = array( 
                array( 'name' => $venue['BusinessType1']['name'], 'slug' => $venue['BusinessType1']['slug']),
                array( 'name' => $venue['BusinessType2']['name'], 'slug' => $venue['BusinessType2']['slug']),
                array( 'name' => $venue['BusinessType3']['name'], 'slug' => $venue['BusinessType3']['slug'])
                );
            
            $venuesNearby = $this->Venue->getNearbyVenues( $venue['Venue']['geo_lat'], $venue['Venue']['geo_lng'], $venue['Venue']['id'] );
            
            $venuesNearby = $this->VenueSupport->processNearbyVenues( $venuesNearby);
            
            // show edit link if logged-in
            $showAdminPanel = false;
            if ( $this->isAuthorized($this->Auth->user() ) )
                $showAdminPanel = true;
            
            // debug($venuesNearby);
            $this->set( compact('venue', 'showAdminPanel', 'geoCords', 'seo', 'openGraph', 'microformat', 'metaDescription', 'metaKeywords', 'storetypes', 'storeCategories', 'amenities', 'services', 'products', 'venuesNearby'));
    }        
/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {
                    $this->Venue->create();
                    if ($this->Venue->save($this->request->data)) {
                        $this->Session->setFlash(__('The venue has been saved'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash(__('The venue could not be saved. Please, try again.'));
                        debug($this->Venue->validationErrors);
                    }
        }
        $provinces = $this->Venue->Province->find('list');
        $businessType1s = $this->Venue->BusinessType1->find('list');
        $publishStates = $this->Venue->PublishState->find('list');
                
                $venueProducts = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name'),
                    'recursive' => 0,
                    'conditions' => array('BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('VenueFeature.name')
                    ) );
                
                $venueProducts = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name'),
                    'recursive' => 0,
                    'conditions' => array('BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('VenueFeature.name')
                    ) );                

                $venueProducts = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'PRODUCT', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('VenueFeature.name')
                    ) );

                $venueServices = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'SERVICE', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('VenueFeature.name')
                    ) );                

        $this->set(compact('venueProducts', 'venueServices', 'venueServices', 'venueAmenities', 'provinces', 'businessType1s', 'publishStates'));
    }

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
        
        /*
         * Clone a venue
         */
    function admin_clone_venue() {
        //$this->autoRender = false;
        
        $this->Venue->VenueDetail->Behaviors->unload('Sluggable'); 
        $this->Venue->VenueFeature->Behaviors->unload('Sluggable'); 

        $id = Sanitize::paranoid( $this->request->query['venueId']);
        $address = $this->request->query['address'];
        debug($address); debug($id);
       
        if ($id) {
            $venue = $this->Venue->find('first', array(
                'contain' => array('VenueDetail', 'VenueFeature'),
                'conditions' => array('Venue.id' => $id)));
            
            $location = $this->Location->geocodeAddress($address);
            
            $nearby = $this->Location->getNearbyIntersection( $location['lat'], $location['lng']);
            
            $newVenue = $this->VenueSupport->cloneVenue( $venue, $location, array('nearby' => $nearby ) );
            
            // finally set the seo fields, leaving clone data in
            $newVenue['Venue']['seo_title'] = $newVenue['Venue']['name'] . ' ' . $location['city'] . ' ' . $newVenue['Venue']['seo_title'];
            $newVenue['Venue']['seo_desc'] = $newVenue['Venue']['name'] . ' is at ' . $newVenue['Venue']['address'] . ' in ' . $location['city'];


            $newVenue['Venue']['tracking_num'] =  preg_replace("/[^0-9]/","", $newVenue['Venue']['phone_1'] );  

            $intersection = '';
            if ( !empty($nearby['intersectionName']))
                $intersection = ', near ' . $nearby['intersectionName'] . ' ';
           
                
            $newVenue['Venue']['description'] = '<p>This <b>' . $newVenue['Venue']['name'] . 
                                                '</b> is at ' . $newVenue['Venue']['address'] . $intersection . ' in ' . 
                                                $location['city'] . '</p>' . "\n\n" . $newVenue['Venue']['description'];
            
          
            $this->Venue->create();
            
            debug($newVenue);
            $this->Venue->saveAll($newVenue, array('validate' => false));
            
            $venueId = $this->Venue->id;
            $this->redirect( '/admin/venues/edit/' . $venueId );
            
        }
    }        
    
    
    function admin_multi_clone_venue() {
        $this->Venue->VenueDetail->Behaviors->unload('Sluggable'); 
        $this->Venue->VenueFeature->Behaviors->unload('Sluggable');      

        if ($this->request->is('post') || $this->request->is('put')) {
          
            // make sure we have a base venue
            if (empty($this->data['Venue']['base_venue_id']) )
                throw new NotFoundException(__('Invalid base venue'));
           
            $baseVenueId = $this->data['Venue']['base_venue_id'];
            
            $baseVenue = $this->Venue->find('first', array(
                'contain' => array('VenueDetail', 'VenueFeature'),
                'conditions' => array('Venue.id' => $baseVenueId)));
            
            // now loop though entries
            
            $data = Hash::extract($this->data, 'Venue.{n}');
            
            $venuesSaved = 0;
          
            foreach( $data as $i => $row) {
               
                //debug($row);
                
                if (empty($row['address'])) continue;
                
                $location = $this->Location->geocodeAddress($row['address']);

                $nearby = $this->Location->getNearbyIntersection( $location['lat'], $location['lng']);

                $params = array( 'nearby' => $nearby);
                
                if ( !empty($row['phone_1']))
                    $params['phone'] = trim($row['phone_1']);
                
                if ( $row['ignore_hours'] != 1 ) {
                    $params['hours'] = array(
                        'hours_sun' => $row['hours_sun'],
                        'hours_mon' => $row['hours_mon'],
                        'hours_tue' => $row['hours_tue'],
                        'hours_wed' => $row['hours_wed'],
                        'hours_thu' => $row['hours_thu'],
                        'hours_fri' => $row['hours_fri'],
                        'hours_sat' => $row['hours_sat']
                    );
                }
                
                if ( !empty($row['website']))
                    $params['website'] = trim($row['website']);
                
                $newVenue = $this->VenueSupport->cloneVenue( $baseVenue, $location, $params );
                debug($newVenue);
                
                if ($newVenue) {
                    
                     if ( !$newVenue['Venue']['city_neighbourhood_id'])
                        $newVenue['Venue']['city_neighbourhood_id'] = 0;
                     

                     
                    // finally set the seo fields, leaving clone data in
                    $newVenue['Venue']['seo_title'] = $newVenue['Venue']['name'] . ' ' . $location['city'] . ' ' . $newVenue['Venue']['seo_title'];
                    $newVenue['Venue']['seo_desc'] = $newVenue['Venue']['name'] . ' is at ' . $newVenue['Venue']['address'] . ' in ' . $location['city'];

                    $intersection = '';
                    if ( !empty($nearby['intersectionName']))
                        $intersection = ', near ' . $nearby['intersectionName'] . ' ';

                    $newVenue['Venue']['description'] = '<p>This <b>' . $newVenue['Venue']['name'] . 
                                                        '</b> is at ' . $newVenue['Venue']['address'] . $intersection . ' in ' . 
                                                        $location['city'] . '</p>' . "\n\n" . $newVenue['Venue']['description'];

                    $newVenue['Venue']['tracking_num'] =  preg_replace("/[^0-9]/","", $newVenue['Venue']['phone_1'] );                                    

                    $this->Venue->create();
                    $this->Venue->saveAll($newVenue, array('validate' => false));       
                    
                    $venuesSaved++;
                    
                }
                
                
            }
            $this->Session->setFlash( 'Saved: ' . $venuesSaved );
        }
        
        $id = intval( $this->request->query['venueId']);
        
        $baseVenue = $this->Venue->findById($id);
        if (!$baseVenue)
            throw new NotFoundException(__('Invalid venue'));
        
        debug($id);
        
        $this->set( compact('baseVenue'));
        
        
    }
    
    /*
     * using tehe venue as a base, clone using data from supplied urls
     */
    public function admin_import_clone_venue() {
      
        $this->Venue->VenueDetail->Behaviors->unload('Sluggable'); 
        $this->Venue->VenueFeature->Behaviors->unload('Sluggable');
        
        $this->Venue->Behaviors->load( 'Sluggable', array('field' => 'slug_title' ) );

        if ($this->request->is('post') || $this->request->is('put')) {

            // make sure we have a base venue
            if (empty($this->data['Venue']['base_venue_id']) )
                throw new NotFoundException(__('Invalid base venue'));
           
            $baseVenueId = $this->data['Venue']['base_venue_id'];
            
            $baseVenue = $this->Venue->find('first', array(
                'contain' => array('VenueDetail', 'VenueFeature'),
                'conditions' => array('Venue.id' => $baseVenueId)));
           // debug($baseVenue);
            
           // debug($this->data);
            // now get the urls
            $urls = explode("\n", $this->data['Venue']['urls'] );
            debug($urls);
            
            $baseDesc = $this->data['Venue']['base_description'];
            
            // now scrape the page
            $venueData = array();
            
            
            // check if any store urls are already in database
            foreach ($urls as $url) {
                $url = trim($url);
                
       
                
               
                $venueData[] = $this->scrapeChaptersPage($url);
                
                
            }
            
            //debug($venueData);
            //exit;
            if (empty($venueData))
                return;
            
            // now make clones
            foreach($venueData as $i => $row) { debug($row);
                if ( empty($row['address']))
                    continue;
                
                if ($row == false)
                    continue;
                
                $location = $this->Location->geocodeAddress($row['address']); 

                $nearby = $this->Location->getNearbyIntersection( $row['lat'], $row['lng']);

                $params = array( 'nearby' => $nearby);
                
                if ( !empty($row['phone']))
                    $params['phone'] = trim($row['phone']);
                
                
                $params['hours'] = array(
                    'hours_sun' => $row['hours'][0],
                    'hours_mon' => $row['hours'][1],
                    'hours_tue' => $row['hours'][2],
                    'hours_wed' => $row['hours'][3],
                    'hours_thu' => $row['hours'][4],
                    'hours_fri' => $row['hours'][5],
                    'hours_sat' => $row['hours'][6],
                );
                
                
                if ( !empty($row['website']))
                    $params['website'] = trim($row['website']);
                
                if ( !empty($row['featureIds']) )
                    $params['features'] = $row['featureIds'];
                
                $newVenue = $this->VenueSupport->cloneVenue( $baseVenue, $location, $params );
                //debug($newVenue);                
                
                // now fill in the rest
                if ($newVenue) {
                    
                    // last-minute fix if the address wasn't encoded properly - we already have correct Lat/Lng from scrape
                    $newVenue['Venue']['address'] = trim($newVenue['Venue']['address']);
                    if ( empty($newVenue['Venue']['address']) )
                        $newVenue['Venue']['address'] = $row['address'];
                    
                    
                    
                    
                    $newVenue['Venue']['name'] = trim($row['name']);
                    $newVenue['Venue']['sub_name'] = trim($row['sub_name']);
                    $newVenue['Venue']['slug_title'] = $row['name'] . ' ' . $location['city'];
                    
                    $newVenue['Venue']['lat'] = $row['lat'];
                    $newVenue['Venue']['lng'] = $row['lng'];
                    
                    // finally set the seo fields, leaving clone data in
                    $newVenue['Venue']['seo_title'] = $newVenue['Venue']['name'] . ' ' . $location['city'];// . ' ' . $newVenue['Venue']['seo_title'];
                    $newVenue['Venue']['seo_desc'] = $newVenue['Venue']['name'] . ' is at ' . $newVenue['Venue']['address'] . ' in ' . $location['city'];

                    $intersection = '';
                    if ( !empty($nearby['intersectionName']))
                        $intersection = ', near ' . $nearby['intersectionName'] . ' ';

                    $newVenue['Venue']['description'] = '<p>This <b>' . $newVenue['Venue']['name'] . 
                                                        '</b> is at ' . $newVenue['Venue']['address'] . $intersection . ' in ' . 
                                                        $location['city'] . '</p>' . "\n\n" . $baseDesc;
                    
                    $newVenue['Venue']['description'] .= "\n" . implode(', ', (array)$row['notes_services']);
                    
                    if ( !$newVenue['Venue']['city_neighbourhood_id'])
                        $newVenue['Venue']['city_neighbourhood_id'] = 0;
                    
                     if (isset( $row['notes']) ) {
                         $newVenue['Venue']['notes'] = $row['notes'] . "\n";
                     }    
                     
                     if ( isset( $row['website_url']))
                         $newVenue['Venue']['website_url'] = $row['website_url'];
                     
                     
                     // remove profile image
                     $newVenue['VenueDetail']['profile_image'] = '';
                    
                    debug($newVenue);
                    
                    // check if venue already exists
                    $result = $this->Venue->find('count', array('contain' => false, 
                        'conditions' => array(
                            'Venue.name' => $newVenue['Venue']['name'], 'Venue.sub_name' => $newVenue['Venue']['sub_name']
                            ) 
                        ) 
                        );
                    echo '$result: ' . $result . '<br>';
                    if ($result < 1 ) {   
                        $this->Venue->create();
                        $id = $this->Venue->saveAll($newVenue, array('validate' => 'true'));       

                        //debug( $this->Venue->invalidFields() );

                        echo 'Added venue ' . $id . '<br>';
                    } else {
                        echo 'Skipping ' . $newVenue['Venue']['sub_name'] .'<br>';
                    }
                    
                    //$venuesSaved++;
                    //exit;
                    
                }   
            }
        }
        
        $id = intval( $this->request->query['venueId']);
        
        $baseVenue = $this->Venue->findById($id);
        if (!$baseVenue)
            throw new NotFoundException(__('Invalid venue'));
        
        debug($id);
        
        $this->set( compact('baseVenue'));
        
    }
    
    /*
     *  load a json stream in
     */
    function admin_batch_import() {
        
        $this->Venue->VenueDetail->Behaviors->unload('Sluggable'); 
        $this->Venue->VenueFeature->Behaviors->unload('Sluggable');
        
        $this->Venue->Behaviors->load( 'Sluggable', array('field' => 'slug_title' ) );        
        
        if ($this->request->is('post')) {
             // debug($this->request->data);
                        
            $jsonData = json_decode( $this->request->data['Venue']['json'], true);
            
            $features = isset( $jsonData['features']) ? $jsonData['features'] : ''; 
            
            if ( !empty($features) ) 
                $featuresList = $this->matchUpFeatureIds($features);
            
           //debug( $jsonData);
            $venues = $jsonData['venues']; 
            
           
            
            $baseDescription = $this->request->data['Venue']['description'];
            
/* 

    "venues": [
        {
            "name": "Barnes & Noble",
            "sub_name": "Glendale Americana",
            "geo_latt": "34.144412",
            "geo_long": "-118.255083",
            "notes": "Location: 2303 \nAddress: The Americana at Brand\n210 Americana Way\nGlendale, CA \n91210\n818-545-9146\n \nFeatures: Complimentary Wi-FiToys & GamesB&N@SchoolCaf\u00e9  \nHours: Sun-Sat 9:00AM-11:00PM \n",
            "url": "http:\/\/store-locator.barnesandnoble.com\/store\/2303",
            "phone": "818.545.9146",
            "address": "The Americana at Brand, 210 Americana Way, Glendale, CA , 91210",
            "features": [
                "free_wifi",
                "kids_toys",
                "educational_resources",
                "cafe",
                "online_store",
                "gift_cards"
            ],
            "hours": {
                "sun": "9:00am - 11:00pm",
                "mon": "9:00am - 11:00pm",
                "tue": "9:00am - 11:00pm",
                "wed": "9:00am - 11:00pm",
                "thu": "9:00am - 11:00pm",
                "fri": "9:00am - 11:00pm",
                "sat": "9:00am - 11:00pm"
            },
            "features_text": "Features available at this Barnes & Noble include: Complimentary Wi-Fi, toys and games, B&N@School and Cafe",
            "tracking_num": "8185459146"
        },
        {
            "name": "Barnes & Noble",
            "sub_name": "The Grove at Farmers Market",
            "geo_latt": "34.072840",
            "geo_long": "-118.356309",
            "notes": "Location: 2089 \nAddress: 189 The Grove Drive Suite K 30\nLos Angeles, CA \n90036\n323-525-0270\n \nFeatures: Complimentary Wi-FiToys & GamesB&N@SchoolCaf\u00e9  \nHours: Sun-Sat 9:00AM-11:00PM \n",
            "url": "http:\/\/store-locator.barnesandnoble.com\/store\/2089",
            "phone": "323.525.0270",
            "address": "189 The Grove Drive Suite K 30, Los Angeles, CA , 90036",
            "features": [
                "free_wifi",
                "kids_toys",
                "educational_resources",
                "cafe",
                "online_store",
                "gift_cards"
            ],
            "hours": {
                "sun": "9:00am - 11:00pm",
                "mon": "9:00am - 11:00pm",
                "tue": "9:00am - 11:00pm",
                "wed": "9:00am - 11:00pm",
                "thu": "9:00am - 11:00pm",
                "fri": "9:00am - 11:00pm",
                "sat": "9:00am - 11:00pm"
            },
            "features_text": "Features available at this Barnes & Noble include: Complimentary Wi-Fi, toys and games, B&N@School and Cafe",
            "tracking_num": "3235250270"
        },
        
 *    "venues":[
      {
         "name":"Southdale 24 Hrs 7 Days\/Wk Coed Club",
         "address":"635 Southdale Road East, Unit 103, London, ON, N6E 3W6",
         "phone":"519.685.2111",
         "email":"londonsouthdale@goodlifefitness.com",
         "hours":[ // monday - sunday
            "24 Hours",
            "24 Hours",
            "24 Hours",
            "24 Hours",
            "24 Hours",
            "24 Hours",
            "24 Hours"
         ],
         "classes":[
            "All Terrain",
            "Awesome Abs",
           ...
         ],
         "features":[
            "Cardio-Vascular Equipment",
            "Child Minding",
            "Free-weight Area",
            "Group Cycling",
            "Group Exercise Classes",
            "Personal Training",
            "Pro Shop",
            "Sauna",
            "Strength Training Equipment",
            "Stretching Zone",
            "TRX",
            "Tanning",
            "Towel Service",
            "Visual Fitness Planner"
         ],
         "notes":"url: http:\/\/goodlifefitness.com\/ClubDetails.aspx?ClubNo=008\nurl mobile: http:\/\/m.goodlifefitness.com\/locator2.aspx?ClubID=008\n\nChildcare Hours: Monday09:15 - 11:45 & 17:15 - 20:00 | Tuesday09:15 - 11:45 & 17:15 - 19:45 | Wednesday09:15 - 11:45 & 17:15 - 19:45 | Friday09:15 - 11:45 | Saturday08:15 - 11:45\n",
         "website":"http:\/\/goodlifefitness.com\/ClubDetails.aspx?ClubNo=008",
         "description_block_1":"\n<p>Classes at this gym include: All Terrain, Awesome Abs, BodyAttack, BodyCombat, BodyFlow, BodyPump, BodyStep, BodyVive, CXWORX, Flexi-bar, Newbody, Zumba<\/p>\n",
         "description_block_2":"\n<p>Features of this gym include: Cardio-Vascular Equipment, Child Minding, Free-weight Area, Group Cycling, Group Exercise Classes, Personal Training, Pro Shop, Sauna, Strength Training Equipment, Stretching Zone, TRX, Tanning, Towel Service, Visual Fitness Planner<\/p>\n",
         "features_list":[
 */            

            $data = array();
            $counter = 0;
            foreach ( $venues as $i => $row) { // flag_show     business_type_id    group
                
                // check if it exists already
                
                $result = $this->Venue->findByTrackingNum($row['tracking_num']);
                if ( $result ) {
                    debug('skipping ' . $row['name'] . ' matching tracking number:' . $row['tracking_num']  );
                    continue;
                }
                
                    
                // 
                // swap-in replacment text [BLOCK1] / [BLOCK2]
                
                $description = str_replace( 
                        array('[FEATURES]'), // '[BLOCK1]', '[BLOCK2]', 
                        array( $row['features_text'] ) , // $row['description_block_1'], $row['description_block_2'],
                        $baseDescription);
                
                // debug($description); continue;
                
                $geo = $this->Location->geocodeAddress($row['address']);
                
                if ( stripos($row['name'], '24 Hrs') ) {
                    $row['features'][] = 'Open Late / 24 Hours';
                    
                    debug($row['features']);
                }

                $chainId = 1; // Barns and Nobel        
                
                $data = array( 
                    
                    'Venue' => array(
                        'name' => trim($row['name']),
                        'sub_name' => trim($row['sub_name']),
                        'address' => $geo['street_address'],
                        'city_id' => intval($geo['city_id']),
                        'province_id' => intval($geo['province_id']),
                        'postal_code' => $geo['postal_code'],
                        'geo_lat' => ( $row['geo_latt']) ? $row['geo_latt'] : $geo['lat'],
                        'geo_lng' => ( $row['geo_long']) ? $row['geo_long'] : $geo['lng'],
                        'region_id' => intval($geo['region_id']),
                        'city_region_id' => intval($geo['city_region_id']),
                        'city_neighbourhood_id' => intval($geo['city_neighbourhood_id']),
                        'phone_1' => $row['phone'],
                        'website_url' => $row['website'],
                        'hours_mon' => $row['hours']['mon'],
                        'hours_tue' => $row['hours']['tue'],
                        'hours_wed' => $row['hours']['wed'],
                        'hours_thu' => $row['hours']['thu'],
                        'hours_fri' => $row['hours']['fri'],
                        'hours_sat' => $row['hours']['sat'],
                        'hours_sun' => $row['hours']['sun'],
                        'chain_id' => $chainId,
                        'notes' => $row['notes'],
                        'description' => $description,
                        'tracking_num' => $row['tracking_num']
                        //'last_verified' => DboSource::expression('NOW()'),
                        
                        
                        
                        //'group' => $row['group'],
                        //'flag_show' => $row['show']
                    ),
                    'VenueFeature' => array('VenueFeature' => $this->getFeaturesFromDB( $row['features'] ) )
                    );
                    
                    $data['Venue']['business_type_1_id'] = 1; // defult type, e.g. bookstore 
                
                    if ( isset( $row['business_type'][0]) ) {
                        if ( $row['business_type'][0] == 'Gym' )
                            $data['Venue']['business_type_1_id'] = 1;
                        elseif ( $row['business_type'][0] == "Womens' Gym" )
                            $data['Venue']['business_type_1_id'] = 3;    
                    }
                    
                    if ( isset( $row['business_type'][1]) ) {
                    if ( $row['business_type'][1] == 'Gym' )
                            $data['Venue']['business_type_2_id'] = 1;
                        elseif ( $row['business_type'][1] == "Womens' Gym" )
                            $data['Venue']['business_type_2_id'] = 3;
                    }
                    
                    $data['Venue']['slug_title'] = 'barns nobel ' . $geo['city']; 
              // save
                $this->Venue->create();
               
               // debug($data); exit;
                if ( $this->Venue->saveAll($data, array('validate' => 'true') ) ) {
                  echo ('saved ' . $data['Venue']['name']);
                  //debug($data);
                } else {
                    // didn't validate logic
                    debug( $this->Venue->validationErrors);
                    debug($data);
                }



               
                
                $counter++;
                //if ($counter > 10) exit;
                
            }

        }
        
      
        
    }

    /*
    * Gets Ids from database for features passed in by slug
    */  
    function getFeaturesFromDB( $features) {
        $idList[] = array();
        foreach( $features as $name ) {
             $result = $this->Venue->VenueFeature->findBySlug($name);
             $idList[] = intval( $result['VenueFeature']['id'] ); 
        }
        return($idList);
    
    }
    

    /*
     * matchUpFeatureIds
     * 
     * Returns:
     *  (int) 15 => array(
        'name' => 'Pilates Mat',
        'match_to' => 'Pilates Mat',
        'show' => (int) 1,
        'group' => 'PRODUCT',
        'id' => '16'
     */
    function matchUpFeatureIds($features) {
        foreach( $features as $i => $row) {
            $feature = trim($row['match_to']);
            
            $result = $this->Venue->VenueFeature->findByName($feature);
            
            $features[$i]['id'] = intval( $result['VenueFeature']['id'] );
            
        }
        return $features;
    }
    
    /*
     * getFeaturesArray
     * 
     * params:
     * $venueFeatures : features a venue has
     * $featuresList : full list of features
     */
    function getFeaturesArray( $venueFeatures, $featuresList) {
        $data = array();
        foreach( $venueFeatures as $feature) {
            foreach( $featuresList as $row) {
                if ( $feature == $row['name'])
                   $data[] = $row['id'];
            }
        }
        return $data;
    }
    

            
        
        
/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
                //debug($this->request);
                
                
                // move into data array
                
                if ( !isset($this->params['pass']['new_filter']) ) {
                    foreach($this->params['named'] as $k=>$v)
                    {
                        // set data as is normally expected
                        $this->request->data['Venue'][$k] = $v;
                    }
                }
                
                //debug($this->request);
                
        $this->Venue->recursive = 0; // debug($this->paginate());
                
                $provinces = $this->Venue->Province->find('list', array('order' => 'name'));
                $cities = $this->Venue->City->find('list', array('order' => 'name'));
                $chains = $this->Venue->Chain->find('list', array('order' => 'name'));
                $businessTypes = $this->Venue->BusinessType1->find('list', array('order' => 'name'));
                
               
                
                // for the form
               if (isset($this->request['params']['named']['Venue']) ) {
                   $this->params['named'] = $this->request->data['Venue'];
                   
                    $provinceId = $this->request['params']['named']['Venue']['province_id'];
                    $cityId = $this->request['params']['named']['Venue']['city_id'];
                    $chainId = $this->request['params']['named']['Venue']['chain_id'];
                    $businessTypeId = $this->request['params']['named']['Venue']['business_type_id'];
               } else {
                   
               }
               
                // add the filters
                if ( isset( $this->data['Venue']['province_id'] ) && (!empty($this->data['Venue']['province_id']) ) ) {
                    $this->paginate['Venue']['conditions']['Venue.province_id'] = $this->data['Venue']['province_id'];
                }
                if ( isset( $this->data['Venue']['city_id'] ) && (!empty($this->data['Venue']['city_id']) ) ) {
                    $this->paginate['Venue']['conditions']['Venue.city_id'] = $this->data['Venue']['city_id'];
                }      
                if ( isset( $this->data['Venue']['chain_id'] ) && (!empty($this->data['Venue']['chain_id']) ) ) {
                    $this->paginate['Venue']['conditions']['Venue.chain_id'] = $this->data['Venue']['chain_id'];
                }    
                if ( isset( $this->data['Venue']['business_type_id'] ) && (!empty($this->data['Venue']['business_type_id']) ) ) {
                    $this->paginate['Venue']['conditions']['OR'] = array( 
                        'Venue.business_type_1_id' => $this->data['Venue']['business_type_id'],
                        'Venue.business_type_2_id' => $this->data['Venue']['business_type_id'],
                        'Venue.business_type_3_id' => $this->data['Venue']['business_type_id'] );
                }                 
                
                $this->paginate['Venue']['limit'] = 100;
                
                //debug( $this->paginate['Venue'] );
                
                $this->set( compact('pass', 'provinces', 'provinceId', 'cities', 'cityId', 'chains', 'chainId', 'businessTypes', 'businessTypeId'));
                
        $this->set('venues', $this->paginate() );
    }
        
        public function admin_ajax_index() {
            $result = $this->Venue->find('all', array('contain' => false) );
        }

        /**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
    public function admin_view($id = null) {
        $this->Venue->id = $id;
        if (!$this->Venue->exists()) {
            throw new NotFoundException(__('Invalid venue'));
        }
        $this->set('venue', $this->Venue->read(null, $id));
    }

/**
 * admin_add method NOT USED
 *
 * @return void
 */
    public function admin_add() {
        
        if ($this->request->is('post') || $this->request->is('put')) {
                    // combine all 3 into one VenueFeature array to save
                        $this->request->data['VenueFeature']['VenueFeature'] = array_merge(
                               (array) $this->request->data['Venue']['VenueAmenity'],
                                (array) $this->request->data['Venue']['VenueProduct'],
                                (array) $this->request->data['Venue']['VenueService']
                                );
                        
                 // debug($this->request->data); 
            if ($this->Venue->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The venue has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The venue could not be saved. Please, try again.'));
            }
        }
                
              
                // get the IDs of the saved features
                //$selectedFeatures = Hash::extract( $this->request->data['VenueFeature'], '{n}.id' );
                
        $provinces = $this->Venue->Province->find('list', array('order' => 'name'));
                $cities = $this->Venue->City->find('list', array('order' => 'name'));
                $chains = $this->Venue->Chain->find('list', array('order' => 'name'));
                $intersections = $this->Venue->City->Intersection->find('list', array('order' => 'name'));
                $cityNeighbourhoods = $this->Venue->City->CityNeighbourhood->find('list', array('order' => 'name'));
                $cityRegions = $this->Venue->City->CityRegion->find('list', array('order' => 'name'));
                
        $businessType1s = $this->Venue->BusinessType1->find('list', array('order' => 'name'));
        
        $publishStates = $this->Venue->PublishState->find('list');
                
                $venueProducts = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name', 'BusinessType.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'PRODUCT', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('BusinessType.name', 'VenueFeature.name')
                    ) );

                $venueServices = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name', 'BusinessType.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'SERVICE', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('BusinessType.name', 'VenueFeature.name')
                    ) );
                
                $venueAmenities = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name', 'BusinessType.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'AMENITY', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('BusinessType.name', 'VenueFeature.name')
                    ) );
                
        $this->set(compact( 'cities', 'chains', 'intersections', 'cityNeighbourhoods', 'cityRegions', 'provinces', 'businessType1s', 'venueProducts', 'venueServices', 'venueAmenities', 'publishStates'));
                
        
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
                // 
                $this->Venue->VenueDetail->Behaviors->unload('Sluggable');
                
        $this->Venue->id = $id;
        if (!$this->Venue->exists()) {
            throw new NotFoundException(__('Invalid venue'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
                    // combine all 3 into one VenueFeature array to save
                        $this->request->data['VenueFeature']['VenueFeature'] = array_merge(
                               (array) $this->request->data['Venue']['VenueAmenity'],
                                (array) $this->request->data['Venue']['VenueProduct'],
                                (array) $this->request->data['Venue']['VenueService']
                                );
                        
                 // debug($this->request->data); 
            if ($this->Venue->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The venue has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The venue could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Venue->read(null, $id);
        }
                
              
                // get the IDs of the saved features
                $selectedFeatures = Hash::extract( $this->request->data['VenueFeature'], '{n}.id' );
                
        $provinces = $this->Venue->Province->find('list', array('order' => 'name'));
                $cities = $this->Venue->City->find('list', array('order' => 'name'));
                $chains = $this->Venue->Chain->find('list', array('order' => 'name'));
                $intersections = $this->Venue->City->Intersection->find('list', array('conditions' => array('city_id' => $this->data['Venue']['city_id']), 'order' => 'name'));
                $cityNeighbourhoods = $this->Venue->City->CityNeighbourhood->find('list', array('conditions' => array('city_id' => $this->data['Venue']['city_id']),'order' => 'name'));
                $cityRegions = $this->Venue->City->CityRegion->find('list', array('conditions' => array('city_id' => $this->data['Venue']['city_id']), 'order' => 'name'));                
                
                
        $businessType1s = $this->Venue->BusinessType1->find('list', array('order' => 'name'));
        $businessType2s = $this->Venue->BusinessType2->find('list', array('order' => 'name'));
        $publishStates = $this->Venue->PublishState->find('list', array('order' => 'name'));
                
                $venueProducts = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name', 'BusinessType.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'PRODUCT', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('BusinessType.name', 'VenueFeature.name')
                    ) );

                $venueServices = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name', 'BusinessType.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'SERVICE', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('BusinessType.name', 'VenueFeature.name')
                    ) );
                
                $venueAmenities = $this->Venue->VenueFeature->find('list', array('fields' =>
                    array('VenueFeature.id', 'VenueFeature.name', 'BusinessType.name'),
                    'recursive' => 0,
                    'conditions' => array('VenueFeature.group' => 'AMENITY', 'BusinessType.flag_show' => 1, 'VenueFeature.flag_show' => 1),    
                    'order' => array('BusinessType.name', 'VenueFeature.name')
                    ) );
                
        $this->set(compact( 'cities', 'chains', 'intersections', 'cityNeighbourhoods', 'cityRegions', 'provinces', 'businessType1s', 'venueProducts', 'venueServices', 'venueAmenities', 'publishStates', 'selectedFeatures'));
                
        
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
        $this->Venue->id = $id;
        if (!$this->Venue->exists()) {
            throw new NotFoundException(__('Invalid venue'));
        }
        if ($this->Venue->delete()) {
            $this->Session->setFlash(__('Venue deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Venue was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
        
    /*
     * scapes BestBuy (US) pages
     */
    function scrapePageInfo( $url = 'http://stores.bestbuy.com/6/') {
        
        $data = array();
        
        //$this->out('processing: ' . $url, 1);
        phpQuery::newDocumentFileHTML($url);   
        
        $titleElement = pq('title')->html();
        //debug($titleElement);
        $name = pq('h1#site_title a')->html();
        
        // make sure venue isn't closed
        if (strpos( strtolower($name), 'closed'))
            return false;   
        
        if (strpos( strtolower($name), 'mobile'))
            return false;          
        
        $subname = explode('-', $name);
        $name = trim($subname[0]);
        $subname = trim($subname[1]);
        
        $data['name'] = $name;
        $data['sub_name'] = $subname;
        //$this->out($name . ' + ' . $subname,1);
            
        $address = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div p.geo strong')->text();
               
        $address = str_replace("\n", ', ', trim($address));
        
        $data['address'] = $address;
        //debug($address);
        
        // Phone
        $phone = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div p.geo span span')->text();
        
        $phone = explode("\n", $phone);
        
        if (is_array($phone))
            $phone = $phone[0];
        
        $data['phone'] = $phone;
        //debug($phone);
        
        // Geo - pull out the line starting with 'GEO:'
        $geoBlock = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div span')->text();
        
        preg_match('/GEO: (.*)/', $geoBlock, $matchs);
        
        $geoBlock = explode(',', $matchs[1]);
        $geoLat = trim($geoBlock[0]); $geoLng = trim($geoBlock[1]);
        
        //$this->out($address,1);
        //$this->out($phone,1);
        //$this->out( $geoLat . ' - ' . $geoLng,1);
        $data['geo_lat'] = $geoLat;
        $data['geo_lng'] = $geoLng;
        // Hours
        
        for ($i=0; $i < 7; $i++) {
            $hoursBlock0 = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div.hours ul li.day' . $i )->text();
            $hoursBlock0 = Sanitize::paranoid( $hoursBlock0, array(' ', ':') );

            $hoursBlock0 = str_ireplace( array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') , '', $hoursBlock0);

            $hoursBlock0 = trim( str_ireplace( array('a', 'p') , array('am - ', 'pm') , $hoursBlock0) );
            $hours[$i] = $hoursBlock0;
            
        }
        
        $data['hours'] = $hours;
        //$this->out( print_r($hours));
        
        // services 
        $services = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div.store_services ul')->html();
        
        $services = strip_tags( html_entity_decode($services), 'li');
        
        $services = explode("\n", trim($services) );
        
        $data['services'] = $services;
        
        $data['website'] = $url;
        
        //$this->out( print_r($services));
        return($data);
    }  
    
    /*
     * Scapes address info from HHGregg stores (US)
     */
    function scrapePageInfoHhgregg($url) {
        App::uses('HttpSocket', 'Network/Http');
        
        $http = new HttpSocket();
        $response = $http->get($url);
      
        // Get the status code for the response.
        $code = $response->code;
        echo ($code) . '<br>';
        
        if ( $code != 200)
            echo('problem loading page for $url ' . $url ) . '<br>';

        phpQuery::newDocumentHTML($response->body);
    
        // store name
        $name = pq('div#store_name')->html();
        //$this->out('Name: ' . $name,1);
        $data['name'] = 'hhgregg';
        $data['sub_name'] = $name;
        
        $result = $this->Venue->find('count', array('contain' => false, 'conditions' => array('Venue.name' => $data['name'], 'Venue.sub_name' => $data['sub_name']) ) );
        if ($result > 0) {
            echo 'Skipping ' . $data['sub_name'] .'<br>';
            return false;
        }
        
        $phone = trim(pq('div#wrapper div#store_details.content_box div.detail a.phone')->html());
        $data['phone'] = $phone;
        
        $address = pq('div#wrapper div#store_details.content_box div.detail')->html();
        
        $address = strip_tags($address, '<li><br>' );
        $address = explode("\n", $address);
        //$this->out( 'Address: ' . print_r($address),1);
        
        // now get
        $addressBlock = '';
        $hours = '';
        foreach ( $address as $i => $row) {
            $row = trim(strtolower($row));
            if ($row == 'address<br>') {
                $addressBlock = trim($address[ $i + 1 ]) . ' , ' . trim($address[ $i + 2 ]);
                // remove phone number from address block
                $addressBlock = preg_replace('/[0-9]{3}\-[0-9]{3}\-[0-9]{4}/', '', $addressBlock);
                //debug($addressBlock);
                $addressBlock = trim(str_replace('<br>', '', $addressBlock));
            }
            if ($row == 'store hours<br>') {
                $hours = trim($address[ $i + 1 ]);
                $hours = explode('<br>', $hours);
                //debug($hours);
                foreach( $hours as $key => $val) {
                    $temp = explode(':', $val, 2);
                    if ( sizeof($temp) == 2) {
                        $hours[ strtolower($temp[0]) ] = $temp[1];
                        unset( $hours[$key]);
                    } else {
                        unset( $hours[$key]);
                    }
                }
                
            }
        }        
        $data['address'] = $addressBlock;
        
        $newHours = array();
        foreach ($hours as $day => $val) {
            if ($day == 'mon-fri') {
                $newHours[1] = $val;
                $newHours[2] = $val;
                $newHours[3] = $val;
                $newHours[4] = $val;
                $newHours[5] = $val;
            }
            if ($day == 'sun') {
                $newHours[0] = $val;
            }
            if ($day == 'sat') {
                $newHours[6] = $val;
            }            
        }   
        
        $data['hours'] = $newHours;
        
        $data['services'] = array();
        
       debug($data);
        return $data;
    }
    
    
 
    /*
     * used to re-format hours to ACD format
     */
    function processGamestopHours( $str) {
        debug($str);
        // Sun: 0, Mon: 1, Sat: 6
        $newHours = array();
        $rows = explode(',', $str); //debug($rows );
        if (is_array($rows) ) {
            foreach( $rows as $row) {
           
           // normalize days, remove odd spacing    
           debug('In: ' . $row);     
           $row = trim(strtolower($row));
           $row =  str_replace( 
                   array('mon - fri', 'sun-', 'mon-fri-', 'mon - fri', 'sat-'), 
                   array('mon-fri', 'sun ', 'mon-fri', 'mon-fri', 'sat '), 
                   $row);     
                
           
            
          
           
            // split days from hours portion    
            $weekDay = explode(' ', trim($row));
            $day = trim(strtolower($weekDay[0])); 
            $hours = $weekDay[1];
            $hours = str_replace('-', ' - ', $hours);
            
            $hours = preg_replace('/([0-9])([am]|[pm])/','\1:00\2', $hours);
            $hours = str_replace(':30:00', ':30', $hours);
            //debug($day); debug($hours);
            switch ( $day) {
                case 'mon-sat':
                    $newHours[1] = $hours;
                    $newHours[2] = $hours;
                    $newHours[3] = $hours;
                    $newHours[4] = $hours;
                    $newHours[5] = $hours;
                    $newHours[6] = $hours;
                    break;
                case 'sun':
                    $newHours[0] = $hours;
                    break;
                case 'sat':
                    $newHours[6] = $hours;
                    break;
                case 'mon-thu':
                    $newHours[1] = $hours;
                    $newHours[2] = $hours;
                    $newHours[3] = $hours;
                    $newHours[4] = $hours;
                    break;
                case 'fri-sat':
                    $newHours[5] = $hours;
                    $newHours[6] = $hours;
                    break;
                case 'mon-fri':
                    $newHours[1] = $hours;
                    $newHours[2] = $hours;
                    $newHours[3] = $hours;
                    $newHours[4] = $hours;
                    $newHours[5] = $hours;                    
                    break;
                case 'mon-sun':
                    $newHours[0] = $hours;
                    $newHours[1] = $hours;
                    $newHours[2] = $hours;
                    $newHours[3] = $hours;
                    $newHours[4] = $hours;
                    $newHours[5] = $hours;
                    $newHours[6] = $hours;
                    break;
                
                default:
                    debug('**** NO MATCH FOR ' . $day .' ****');                
            }
            
            // finall fix 
            foreach( $newHours as $i => $hour){
                if ( $hour == '10 - 9')
                   $newHours[$i] = '10:00am - 9:00pm';
               if ( $hour == '9:30 - 9')
                   $newHours[$i] = '9:30am - 9:00pm';
               if ( $hour == '11 - 7')
                   $newHours[$i] = '11:00am - 7:00pm';      
               if ( $hour == '9:30 - 7')
                   $newHours[$i] = '9:30am - 7:00pm';                 
               if ( $hour == '12 - 5')
                   $newHours[$i] = '12:00pm - 5:00pm';                 
               if ( $hour == '10 - 6')
                   $newHours[$i] = '10:00am - 6:00pm';  
               if ( $hour == '11 - 5')
                   $newHours[$i] = '11:00am - 5:00pm';                
               
            }
            

        }
        
       
        //exit;
        return $newHours;
        
        }
    } 
    
    /*
     * For Chapters
     */
    function scrapeChaptersPage($url ) {
        
        
       App::import('Vendor', 'phpQuery/phpQuery');
       
        phpQuery::newDocumentFileHTML($url);   
        

        
     
        //$locationName = pq('div#__mdl_Store div.main h1')->html();
        
        // find the Javascript blocks
        $scripts = pq('script')->html();
        
        //debug($scripts);
        
       
        // ... and extract the mapInfo from the script 
        $result = preg_match_all('/var mapInfo=\[(.*)\];/s', $scripts, $arr, PREG_PATTERN_ORDER);
        //debug($result);
        $result = $arr[0][0];
        
        // ... chop off the extra bits
        $result = str_replace( array('var mapInfo=[', '}];', '"'), '', $result);
        //debug($result );
        
        // ... extract the location, etc. key and value from the script 
        $results2 = preg_match_all('/([a-zA-Z]{1,10}):([^,]{1,200}),/s', $result, $arr, PREG_PATTERN_ORDER);;
        // ... and re-build as php array
        $locationData = array_combine($arr[1], $arr[2]);
         
        // debug($locationData);
        
        // Now start building the firlds that will be saved
        $subname = trim( $locationData['name'] );
        $name = trim( $locationData['storeType'] );
        
        $address = $locationData['address'] . ',' . $locationData['city'] . ',' . $locationData['province'] . ',' . $locationData['postalCode'];
       
        $locationUrl = $locationData['url'];
        
        // Phone
        $phone = $locationData['phone'];
        
        
        
        $geoLat = $locationData['latitude']; $geoLng = $locationData['longitude'];
       
       
        // Hours
        $hoursBlock = pq('div.containerStoreAddress div.Hours' )->text();
        
        $hoursBlock = str_ireplace( array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ), ',', $hoursBlock );
        
        $hoursBlock = str_replace( array('to', 'friday', 'saturday' ), '-', $hoursBlock );
        
        $hoursBlock = explode( ',', $hoursBlock );
        
        // sunday, mon-fri, saturday
        $hours = array();
        $hours[0] = $hoursBlock[1];
        $hours[1] = $hoursBlock[2];
        $hours[2] = $hoursBlock[3];
        $hours[3] = $hoursBlock[4];
        $hours[4] = $hoursBlock[5];
        $hours[5] = $hoursBlock[6];
        $hours[6] = $hoursBlock[7];
        
        //debug($hours);
        //$this->out( print_r($hours));
        
        $services = pq('.StoreFeatureText')->text();
        
        $services = explode( "\n", $services);  
        
        $services = Sanitize::paranoid($services, array(''));
        
        foreach($services as $key => $val ){
            $val = trim($val);
            if ( empty($val) )
                unset( $services[$key]);
            else
                $services[$key] = $val;
        }
        
        
        //debug( print_r($services) ) ;
        
        $venue = array(
            'name' => $name,
            'sub_name' => $subname,
            'address' => $address,
            'lng' => $geoLat,
            'lat' => $geoLng,
            'phone' => str_replace( array( '(',') ', '-' ), array('', '.', '.') , $phone) ,
            'hours' => $hours,
            'notes' => 'website: ' . $url . "\n", 
            'notes_services' => "\n" .'<p>Features at this store include: ' . implode( $services, ', ') . '.</p>',
            'services' => $services,
            'featureIds' => $this->processChaptersFeatures($services),
            'website_url' => $url,
        );        

       // debug($venue); exit;
        return $venue;
    }
    
    
    function processChaptersFeatures($services) {
        
        $chaptersFeaturesList = array(
            2 => 'Starbucks',
            4 => 'Indigo wi-fi powered by Bell',
            14 => 'IndigoKids',    
        );
        
        $venueFeatures = array();
        foreach( $services as $service) {
            if (in_array($service, $chaptersFeaturesList )) {
                $key = array_search($service, $chaptersFeaturesList);
                $venueFeatures[] = $key;
            }
            
        }
        return $venueFeatures;
    }
    
    /* for Futureshop */
    /*
     * used to crawl seach result pages for urls
     */
    function scrapeFutureshopPageJson($url ) {
        //$url = 'http://www.futureshop.ca/api/v2/json/locations/682?lang=en-CA&proximity=100';
        $http = new HttpSocket();
        debug( $url);
        $response = $http->get($url);
      
        // Get the status code for the response.
        $code = $response->code;
        //$this->out($code,1);
        //debug($response); 
        $results = json_decode($response->body, true);
        
        //debug($results); 
      

        $venues = array();
        
        $row = $results['locations'][0];
        //debug($row); exit;
       
            //$subName = trim( str_replace( array('Gamestop','Game Stop', '-'), '', $row['DisplayName'] ) );
            
            $venue = array(
                'name' => 'Best Buy',
                'sub_name' => $row['name'],
                'address' => "{$row['address1']}, {$row['city']}, {$row['region']}, {$row['postalCode']}, {$row['country']}",
                'lng' => $row['lat'],
                'lat' => $row['lng'],
                'phone' => str_replace( array( '(',') ', '-' ), array('', '.', '.') , $row['phone1']) ,
                'hours' => $this->processFutureshopHours($row['hours']),
                'notes' => $row['landmark'],  
                'notes_services' => $this->processFutureshopServices($row['services']),
            );
       
        //debug($venue); 
        //exit;
        return $venue;
        
    }
    
    /*
     * get services
     */
    function processFutureshopServices($rows) {
        $result = '';
        if (is_array($rows)) {
            foreach ($rows as $i => $row) {
                $result[] = $row['serviceName'];
            }
            //$result = implode(', ', $result);
        }
        return $result;
    }
    
    /*
     * used to re-format hours to ACD format
     */
    function processFutureshopHours( $hours) {
       // debug($str);
        
        $newHours = array(
            0 => $hours[6],
            1 => $hours[1], // over-ride short hours on monday holiday
            2 => $hours[1],
            3 => $hours[2],
            4 => $hours[3],
            5 => $hours[4],
            6 => $hours[5],
        );
        
        foreach ($newHours as $i => $hour) {
            $hours = trim(strtolower( str_replace( 
                    array( 'August 6' ,'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ) 
                    , '', $hour) ) );
            $hours = $string = preg_replace('/\s+/', '', $hours);

          
            $hours = trim(str_replace( array('am', 'pm'), array( ':00am', ':00pm'), $hours));
            $hours = str_replace( array(':30:00'), array(':30'), $hours);
            
            $hours = str_replace( array('-'), array(' - '), $hours);
            
            $newHours[$i] = $hours;
        }
        return $newHours;
        
       
      
        
    }    
    
    
}

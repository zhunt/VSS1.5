<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');
App::uses('Hash', 'Utility');

class ImportVenuesShell extends Shell {

    var $uses = array('Venue', 'City',
                        'Region', 'Province', 'VenueProduct', 'VenueService',
                        'VenueMeta');


    var $venueTypeId = 0;

    var $rawData; 
    var $addressData;
    
 
    var $source = 'http://www.yyztech.ca/';
    var $province = 'Ontario';
    var $provinceCountry = 'Ontario, Canada';
    
    var $businessTypes = array('Service / Consulting');
    //var $businessTypes = array('Internet Cafe / LAN Gaming');
    //var $businessTypes = array('Computer Store'); // holds the business_type(s) of a venue, default computer store
    var $featureReplacments = array(
            array(
                    'find' => array( 'Apple hardware', 'Computer systems' ),
                    'replace' => 'Apple Mac Dealer',
                    'business_category' => 'Computer Store' // 1
            ),
            array(
                    'find' => array( 'iPod / iPhone Accessories'),
                    'replace' => 'iPhone / iPad Accessories'
            ),	
            array(
                    'find' => array( 'Apple hardware'),
                    'replace' => 'Apple Hardware'
            ),		
            array(
                    'find' => array( 'Video Game Systems'),
                    'replace' => 'Video Game Systems'
            ),
            array(
                    'find' => array( 'Used / Refurbished Hardware'),
                    'replace' => 'Refurbished Products'
            ),
            array(
                    'find' => array( 'Printer/media supplies'),
                    'replace' => 'Printer / Media Supplies'
            ),	
            array(
                    'find' => array( 'Phones & PDA'),
                    'replace' => '',
                    'business_category' => 'Phones and Accessories' // 14 
            ),	
            array(
                    'find' => array( 'Consumer electronics'),
                    'replace' => '',
                    'business_category' => 'Electronics' // 3 
            ),	
            array(
                    'find' => array( 'Virus removal'),
                    'replace' => 'PC Tune-up / Virus Removal',
                    'business_category' => '' // 3 
            ),        
        
            array(
                    'find' => array( 'PC Components'),
                    'replace' => 'PC Parts',
                    //'business_category' => 'Electronics' // 3 
            ),	
            array(
                    'find' => array( 'Online Computer Store'),
                    'replace' => 'Online Store',
                    //'business_category' => 'On-Line Store' // 3 
            ),	        
            array(
                    'find' => array( 'Mac Repair'),
                    'replace' => 'Mac Repairs',
                    'business_category' => 'Computer Store' // 3 
            ),	        
            array(
                    'find' => array( 'Laptop Repair'),
                    'replace' => 'Laptop Repairs',
                    'business_category' => 'Computer Store' // 3 
            ),	        
             array(
                    'find' => array( 'iPod / iPhone Repair'),
                    'replace' => 'iPhone / Phone Repairs',
                    'business_category' => 'Phones and Accessories' // 3 
            ),	              
            array(
                    'find' => array( 'Security Systems / Parts'),
                    'replace' => 'Security / Surveillance',
                    'business_category' => 'Electronics' // 3 
            ),	
            array(
                    'find' => array( 'Data Back-up / Data Retrieval'),
                    'replace' => 'Data Back-up / Recovery',
                    'business_category' => 'Computer Store' // 3 
            ),	  
            array(
                    'find' => array( 'Computer rentals'),
                    'replace' => 'Rentals',
                    'business_category' => 'Computer Store' // 3 
            ),	        
        
        

        );
    
    /*
     * -----------------------------------------------------------------------
     * -----------------------------------------------------------------------
     */

    function main() {
       
        $HttpSocket = new HttpSocket();

        //$this->out('Venues to import amenities, products, services from');
        $venueTypeId = $this->in('Venue type Id?', null, 1);
        if ( $venueTypeId) {
        $results = $HttpSocket->get( $this->source . '/venues/export_venue_names/' . $venueTypeId);
		debug( $this->source . '/venues/export_venue_names/' . $venueTypeId );
        $results = json_decode($results, true);
        if ( empty($results)) {
            $this->out('no venues found'); debug($results );
            exit;
        }
		debug($results );
		
        // temp
        //$results = array_slice($results, 1, 2);

        // Loop though all the found venues        
        foreach($results as $i => $name) {
            $this->out('getting ' . $name);
            $venue = $HttpSocket->get( $this->source . '/venues/xml_export/' . $name);
            $venue = json_decode($venue, true);
		 //debug($venue); exit;	
            if ( empty($venue)) continue;

            // start building an array of types
           
            $businessTypes = array(); // set to default store type 
            
            $venue = $this->addLocationFields($venue);
            
            $venue = $this->addFeatures($venue);
            
            $venue = $this->setBusinessTypes($venue);
            
            $venue = $this->setDescription($venue);
            
            // not really another good place for this 
            $venue['Venue']['last_verified'] = $venue['VenueDetail']['last_verified']; 
            $venue['Venue']['website_url'] = $venue['VenueDetail']['website_url'];
            
            $venue = $this->addMetaFields($venue);
            
            
            // set-fields 
            $venue['Venue']['publish_state_id'] = 2;
            unset( $venue['Venue']['id']);
          //debug($venue); exit;	
          
            
            $this->saveData($venue);
        }


        }
    }
    
    function addLocationFields($venue) {

        // get address for geo-code
        $address = $venue['Venue']['address'] . ', ' . $venue['City']['name'] . ', ' . $this->province;
        
        $locationData = $this->_geocodeAddress($address); 
        $venue['Venue'] = array_merge( $venue['Venue'], $locationData);
        
        // also get the intersection 
        $intersection = $venue['Intersection']['name'];
        if ( $intersection) {
            $id = $this->Venue->Intersection->updateIntersection($intersection, $venue['Venue']['city_id']);
            $venue['Venue']['intersection_id'] = $id;
        }     
        


        return($venue);
    }
    
    /*
     * Takes data from meta fields, currently just Google Streetview data
     * Expand for YYZtech, SimcoeDining
     */
    function addMetaFields($venue) {
        if ( isset( $venue['VenueMeta'][0]) ) {
            $data = $venue['VenueMeta'][0];
            $newData = array();
            if ( isset($data['heading'])) {
                $newData = array(
                    'streetview_heading' => ($data['heading']) ? $data['heading'] : 0, //  => '76.20577134543785',
                    'streetview_pitch' => ($data['pitch']) ? $data['pitch'] : 0, // => '2.9377042312122',
                    'streetview_zoom' => ($data['zoom']) ? $data['zoom'] : 1, // => '2.3200000000000003',
                    'streetview_lat' => $data['lat'], // => '40.763749',
                    'streetview_lng' => $data['lng'], // => '-73.973396'
                    );
            }
            $venue['VenueDetail'] = $newData;
        }
        // check for photos ( /img/venue_photos/futures-bloor.jpg )
        if ($venue['Venue']['photo_1']) {
            $venue['VenueDetail']['profile_image'] = $venue['Venue']['photo_1'];
        }        
        return ($venue);
    }
    
    /*
     * geo-code address to get region/city/subregion/neighbourhood
     */
    function _geocodeAddress($address) {
        $request = 'address=' . $address . '&sensor=false';

        $HttpSocket = new HttpSocket();
       
        $result = $HttpSocket->get('http://maps.google.com/maps/api/geocode/json', $request);
        $result = json_decode($result, true);
        
        $status = $result['status'];
        $data = array();
        if ( $status == 'OK') {
            $addressFields = $result['results'][0]['address_components'];
            $this->addressData = $addressFields;
            
            $data['province_id'] = $this->_getVenueProvince();
            $data['region_id'] = $this->_getVenueRegion( $data['province_id']);
            $data['city_id'] = $this->_getVenueCity( $data['region_id'], $data['province_id'] );
            $data['city_neighbourhood_id'] = $this->_getVenueNeighbourhood( $data['city_id']);
            $data['city_region_id'] = $this->_getVenueCityRegion( $data['city_id']);
            $data['postal'] = $this->_lookupAddressField('postal_code');
            
        }
       // debug($data); exit;
        return($data);
    }
    
    /*
     * Get the venue and extract / reorder into features
     */
    function addFeatures($venue) {

        // $results = Hash::extract( $users, '{n}.User.id');
        // get a list of features
        $products = Hash::extract( $venue['VenueProduct'], '{n}.name');
        $services = Hash::extract( $venue['VenueService'], '{n}.name');
        $amenities = Hash::extract( $venue['VenueAmenity'], '{n}.name');
        $subTypes = Hash::extract( $venue['VenueSubtype'], '{n}.name');  
        
        $features = array_merge($products, $services, $amenities, $subTypes);
        
        $features = array_flip($features);
        $features = array_flip($features);
      
        
        $features = $this->buildFeaturesList($features);
        sort($features);
        
        $venue['VenueFeature']['VenueFeature'] = $features;
        
        $this->businessTypes = array_unique($this->businessTypes);
        //debug($this->businessTypes); // exit;
        
        
        
        
        
        return($venue);
    }

    function buildFeaturesList( $products ) {
        $filteredList = array(); // list of features ready to go into database
        foreach ($products as $i => $item) {
            foreach ( $this->featureReplacments as $j => $row) {
                if (in_array( $item, $row['find'])) {
                    $products[] = $row['replace'];
                    if ( !empty($row['business_category'] ) ) {
                        $this->businessTypes[] = $row['business_category'];
                    }
                }
            }

        }

        $products = array_unique($products);
        sort($products);
      
        //debug($products);
        
        foreach ($products as $i => $product) {
            $result = $this->Venue->VenueFeature->find('first', array('fields' => array('id', 'name'), 'conditions' => array('VenueFeature.name' => $product ) ));
            if ( $result) {
                $filteredList[ $result['VenueFeature']['id'] ] = $result['VenueFeature']['name'];
            } else {
                debug('Feature Not Found: ' . $product );
            }
        } debug($filteredList);
        return( array_keys($filteredList) );
    }
    
    function setBusinessTypes($venue) {
        if ( empty($this->businessTypes))
            $this->businessTypes = 'Computer Store';
        
        $fields = array('business_type_1_id', 'business_type_2_id', 'business_type_3_id');
        reset($fields);
        
        foreach ( $this->businessTypes as $item) {
            $result = $this->Venue->BusinessType1->find('first', array('conditions' => array('name' => $item), 'contain' => false ) );
            if ( $result ) {
                $venue['Venue'][ current($fields) ] = $result['BusinessType1']['id'];
                next($fields);
            }
               
        }
        
        return($venue); 
    }
    
    /*
     * Set seo_description, seo_meta, description fields
     */
    function setDescription($venue) {
        $venue['Venue']['description'] = $this->cleanHtml($venue['VenueDetail']['description']);
        $venue['Venue']['seo_desc'] = $venue['VenueDetail']['meta_description'];
        $venue['Venue']['seo_title'] = $venue['VenueDetail']['seo_title'];
        
        // clean-up
        unset($venue['VenueDetail']['description']);
        unset($venue['VenueDetail']['meta_description']);
        unset($venue['VenueDetail']['seo_title']);
        
        return($venue);
    }
    
    function saveData( $venue ){
        
        //debug($venue);exit;
        if ( !empty($venue) ) {
            
            $venue['Venue']['chain_id'] = $this->Venue->Chain->updateChain($venue['Chain']['name']);

            $mergeVenue = array_merge( $venue['Venue'], $venue['RestaurantHour'], $venue['VenueDetail'] );
            unset($mergeVenue['id']);
            unset($mergeVenue['venue_id']);
            unset($venue['VenueDetail']['meta_description']);
            
            $mergeVenue['phone_1'] = $venue['Venue']['phone'];
            $mergeVenue['postal_code'] = $venue['Venue']['postal'];
 
            $newVenue = array();
            
            $newVenue['Venue'] = $mergeVenue;
            $newVenue['VenueFeature']['VenueFeature'] = $venue['VenueFeature']['VenueFeature'];
            $newVenue['VenueDetail'] = $venue['VenueDetail'];
            
            
     
           // debug($newVenue); exit;
            $this->Venue->create();

            $this->Venue->Behaviors->disable('Sluggable');
            $this->Venue->saveAll($newVenue, array('validate' => false) );
            
            return; 
        }
    }
     /*
            
            $venueId = $this->Venue->id;

            // add products, amenities, etc.
            $this->updateFeatures( $venue, $venueId); // features
           
           // $this->_updatePayment( $venueId);
            $this->updateVenueType($venue, $venueId);
            $this->updateVenueSubTypes($venue, $venueId);

            // store main photo in meta table
            $this->_saveToMeta($venueId, 'photo_1', $venue['VenueDetail']['photo_1'] );
            
            // store payment types in meta table
            $this->_saveToMeta($venueId, 'payment_creditcard', intval($venue['VenueDetail']['flag_creditcard']) );
            $this->_saveToMeta($venueId, 'payment_bankcard', intval($venue['VenueDetail']['flag_bankcard']) );
            $this->_saveToMeta($venueId, 'payment_cash_only', intval($venue['VenueDetail']['flag_cash']) );
            $this->_saveToMeta($venueId, 'payment_atm_onsite', intval($venue['VenueDetail']['flag_atm']) );

            if ( isset( $venue['VenueDetail']['VenuePrice']['name']))
                $this->_saveToMeta($venueId, 'venue_price_range', $venue['VenueDetail']['VenuePrice']['name'] );

            // store atmosphere / dress-code in meta table
            if ( isset( $venue['VenueDetail']['VenueAtmosphere1']['name']))
                $this->_saveToMeta($venueId, 'venue_atmosphere1', $venue['VenueDetail']['VenueAtmosphere1']['name'] );
            if ( isset( $venue['VenueDetail']['VenueAtmosphere2']['name']))
                $this->_saveToMeta($venueId, 'venue_atmosphere2', $venue['VenueDetail']['VenueAtmosphere2']['name'] );
            if ( isset( $venue['VenueDetail']['VenueDressCode']['name']))
                $this->_saveToMeta($venueId, 'venue_dress_code', $venue['VenueDetail']['VenueDressCode']['name'] );

            // the rating
            if ( isset( $venue['VenueRating']['score'])) {
                $scoreData = array('VenueRating' => array(
                    'venue_id' => $venueId,
                    'score' => $venue['VenueRating']['score'],
                    'votes' => $venue['VenueRating']['votes'] ) );
               // $this->out( print_r($scoreData, true) );
                $this->Venue->VenueRating->create();
                $this->Venue->VenueRating->save($scoreData, array('validate' => false) );
            }

            // comments
            if ( isset($venue['VenueComment'])) {
                foreach ( $venue['VenueComment'] as $comment) {
                    if ( isset($comment['flag_featured']) )
                        $frontPage = 1;
                    else
                        $frontPage = 0;
                    
                    $commentData = array('Comment' => array(
                        'venue_id' => $venueId,
                       'author' => $comment['author'],
                       'comment' => $comment['comment'],
                        'flag_front_page' => $frontPage,
                        'comment_status_id' => 2, // published
                        'created' => $comment['created']
                    ));
                    $this->Venue->Comment->create();
                    $this->Venue->Comment->save($commentData, array('validate' => false) );
                }

            }

        }
        else {
            $venueId = $venue['Venue']['id'];
        }

        $this->out('$venueId: ' . $venueId );

    }
    */

    function updateVenueType( $venue, $venueId) {
        $venueType = trim($venue['VenueType']['name']);
        if ( $this->Venue->VenueType->findByName($venueType) )
            $venueTypeId = $this->Venue->VenueType->updateVenueType( $venueType, $venueId );
    }

   

    function _updatePayment($venueId) {
        if (empty($this->rawData['payments'])) return;

        $this->_saveToMeta($venueId, 'payment_types', 'cash');
        
        //VenueMeta
    }



    /*
     * Utility functions
     */
    function _stripWhitespace( $text) {
        return( trim(preg_replace('/\s\s+/', ' ', $text ) ) );
    }

    /*
     * remove anything not a number, replace with single space with '.'
     * should get 123.123.1234
     */
    function _removeNonNumbers($text, $replaceChar = '.') {
        if ( empty($text)) return null;

        $numbers = preg_replace('/[^\d]/', ' ', $text);
        //$this->out( '$numbers:' . $numbers );
        $numbers = $this->_stripWhitespace($numbers);
        return( str_replace(' ', $replaceChar, $numbers));
    }

    function _saveToMeta( $venueId, $key, $value) {
        $this->VenueMeta->create();

        $data = array( 'Venue' => array(
                            'id' => $venueId,
                            trim($key) => trim($value)
                            )
                      );
         $productId = $this->Venue->save($data);
    }

// ===========================================================================
// following functions copied from LocationController
    
    function _getVenueProvince() {
        $province = $this->_lookupAddressField('administrative_area_level_1');
       //debug('province:' . $province);
        return( ClassRegistry::init('Province')->updateProvince( trim($province)) );
    }
    
    function _getVenueRegion( $provinceId ) {
        $region = $this->_lookupAddressField('administrative_area_level_2');
       // debug('region:' . $region);
        // now ask model to get the id, adding new record if nessassary
        return( ClassRegistry::init('Region')->updateRegion( trim($region), $provinceId) );
    }

    function _getVenueCity( $regionId, $provinceId) {
        $city = $this->_lookupAddressField('locality');
       // debug('city:' . $city);
        return( ClassRegistry::init('City')->updateCity( trim($city), $regionId, $provinceId) );
    }
    
    function _getVenueCityRegion($cityId){
        $cityRegion = $this->_lookupAddressField('sublocality');
        return( ClassRegistry::init('CityRegion')->updateCityRegion( trim($cityRegion), $cityId) );
    }     
    
    function _getVenueNeighbourhood($cityId){ 
        $neighbourhood = $this->_lookupAddressField('neighborhood');
        return( ClassRegistry::init('CityNeighbourhood')->updateNeighbourhood( trim($neighbourhood), $cityId) );
    }    

    
    function _lookupAddressField($fieldName) {
        // loop through address array untill we find the matching field,
        //  then get its value

        // type: value , Type: array
        foreach( $this->addressData as $i => $address) {

            if ( isset($address['types']) ) {
                $type = $address['types'][0];
            } else {
                debug('type/Type not set');
            }
            if ( $type == $fieldName) { // debug($fieldName); //debug ($address['address_component']['long_name'] );
                return($address['long_name']);
            }
        }
    }  
    
    function cleanHtml($html) {
        libxml_use_internal_errors(true); //use this to prevent warning messages from displaying because of the bad HTML

        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $goodHtml = $doc->saveHTML();    
        
        $goodHtmlPartial = trim(ereg_replace('(.*)<body>(.*)</body>(.*)', '\2', $goodHtml));

        
        return($goodHtmlPartial);
    }

}
?>
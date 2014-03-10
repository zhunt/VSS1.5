<?php


App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');

class LocationComponent extends Component {

    var $addressData;
    
    // ----
    var $geocodeData = array();
    var $addressArray = array();
    
    
    /*
     * returns address cords plus Ids for city, neighbourhood, etc.
     */
    function geocodeAddress($address) {
        
        $result = array(); // stores address info. to resturn

        $request = 'address=' . $address . '&sensor=false';
        
        $HttpSocket = new HttpSocket();
        $request = $HttpSocket->get('http://maps.google.com/maps/api/geocode/json', $request);
        $request = json_decode($request, true);
        
        $status = $request['status'];   
        
        if ($status != 'OK')
            return false;
            //throw new NotFoundException(__('Geocode Error'));
        
        $this->geocodeData = $request; // store it
        
        $this->_setupAddress(); // set-up address for look-up
        
        // get lat/lng
        $geocodes = $this->_getLatLng();
        $result = $geocodes;
        
        // get the street address
        $streetAddress = $this->_getBlock('street_number') . ' ' . $this->_getBlock('route');
        $result['street_address'] = $streetAddress;
        $result['postal_code'] = $this->_getBlock('postal_code');
        
        // start with the top country (build this for FestivalRush)
        $country = $this->_getBlock('country');
        
        // then province
        $result['province'] = $this->_getBlock('administrative_area_level_1');
        $result['province_id'] = ClassRegistry::init('Province')->updateProvince( trim($result['province']));
        
        // next region
        $result['region'] = $this->_getBlock('administrative_area_level_2'); 
        $result['region_id'] = ClassRegistry::init('Region')->updateRegion( trim($result['region']), $result['province_id'] );
        
        // next city
        $result['city'] = $this->_getBlock('locality');
        $result['city_id'] = ClassRegistry::init('City')->updateCity( trim($result['city']), $result['region_id'], $result['province_id'] );
        
        // city region
        $result['city_region'] = $this->_getBlock('sublocality'); 
        $result['city_region_id'] = ClassRegistry::init('CityRegion')->updateCityRegion( trim($result['city_region']), $result['city_id']);
        
        // city neighbourhood
        $result['city_neighbourhood'] = $this->_getBlock('neighborhood'); 
        $result['city_neighbourhood_id'] =  ClassRegistry::init('CityNeighbourhood')->updateNeighbourhood( trim($result['city_neighbourhood']), $result['city_id']);
        
        return($result);
        
    }
    
    /*
     * Possible keys;
     * 	'street_number',
	'route', - street name
	'neighborhood',
	'sublocality', - city_region
	'locality', - city usually
	'administrative_area_level_2', - also city?
	'administrative_area_level_1', - province
	'country',
	'postal_code
     */
    function _getBlock( $key) {
        if ( isset($this->addressArray[$key]) )
            return $this->addressArray[$key];
        else
            return false;
    }
    /*
     * extracts the geo lat and log from result
     */
    function _getLatLng() {
        $result = Hash::extract($this->geocodeData['results'], '{n}.geometry.location');
        
        if ($result) {
            return ( array('lat' => $result[0]['lat'], 'lng' => $result[0]['lng'] ) );
        }
        return false;
        
    }
    
    function _setupAddress() {
        $keys = Hash::extract($this->geocodeData['results'], '{n}.address_components.{n}.types.0');
        $values = Hash::extract($this->geocodeData['results'], '{n}.address_components.{n}.long_name');
        
        $this->addressArray = array_combine($keys, $values);
    }
    
    /*
     * Get intersection based on nearby venue
     */
    function getNearbyIntersection( $geoLat, $geoLng) {
        $nearbyVenues = ClassRegistry::init('Venue')->getNearbyVenueIntersection($geoLat, $geoLng);
        
        $intersectionId = null;
        $cityRegionId = null;
        $cityNeighbourhoodId = null;
        $intersectionName = '';
        
        if (!empty($nearbyVenues)) {
            foreach( $nearbyVenues as $venue) { 
               if ( $venue['CityRegion']['id'] && empty($cityRegionId) )
                   $cityRegionId = $venue['CityRegion']['id'];
               if ( $venue['CityNeighbourhood']['id'] && empty($cityNeighbourhoodId) )
                   $cityNeighbourhoodId = $venue['CityNeighbourhood']['id']; 
               if ( $venue['Intersection']['id'] && empty($intersectionId) ) {
                   $intersectionId = $venue['Intersection']['id'];
                   $intersectionName = $venue['Intersection']['name'];
               }
            }
        }
       
        $result = array( 'cityRegionId' => $cityRegionId,
                    'cityNeighbourhoodId' => $cityNeighbourhoodId,
                    'intersectionId' => $intersectionId,
                    'intersectionName' => $intersectionName
            );
        
        return( $result );
    }
    
    
    
    //  ----------------- OLD CODE -------------------
    /*
    function getGeocodedAddress( $address) {
        $data = array();
        //$address = $this->params['url']['address'];
        $this->autoRender = false;

        $request = 'address=' . $address . '&sensor=false';

        $HttpSocket = new HttpSocket();
        debug($request);//exit;
        $result = $HttpSocket->get('http://maps.google.com/maps/api/geocode/xml', $request);

        // new 
        $result = $HttpSocket->get('http://maps.google.com/maps/api/geocode/json', $request);
        
        $result = json_decode($result, true);
        
        $status = $result['status'];
        
        if ($status == 'OK') {
            $location = $result['results'][0]['geometry']; // Set::extract('/GeocodeResponse/result/geometry/location', $resultXml);

            $addressFields = $result['results'][0]['address_components'];// Set::extract('/GeocodeResponse/result/address_component', $resultXml);

            $this->addressData = $addressFields; //debug($this->addressData); exit;

            $data['lat'] = $location['location']['lat'];

            $data['lng'] = $location['location']['lng'];
            
        }
        
        // end new
        //$resultXml = new Xml($result);

        //$resultXml = $resultXml->toArray();
        //$status = $resultXml['GeocodeResponse']['status'];
        debug( 'status: '.  $status);
        if ( $status == 'OK') {
            //$data['status'] = 'ok';
            //$location = Set::extract('/GeocodeResponse/Result/Geometry/Location', $resultXml);
            //$addressFields = Set::extract('/GeocodeResponse/Result/AddressComponent', $resultXml);
            //$this->addressData = $addressFields;
            //debug($location);
            //$data['lat'] = $location[0]['Location']['lat'];
            //$data['lng'] = $location[0]['Location']['lng'];

            // add address data from Google
            $data['province_id'] = $this->_getVenueProvince();
            $data['region_id'] = $this->_getVenueRegion( $data['province_id'] );
            $data['city_id'] = $this->_getVenueCity($data['region_id']);
            $data['city'] = $this->_getVenueCityName();
            //Notre Dame Drive Kamloops, BC V2C 5N9

            $data['postal'] = $this->_lookupAddressField('postal_code');

            $data['address'] = 
                $this->_lookupAddressField('street_number') . ' ' .
                $this->_lookupAddressField('route');
        }
        else {
            $data['status'] = $status;
        }
        return($data);
    }
*/
    /*
     * Utility functions
     */
/*
    function _getVenueProvince() {
        $province = $this->_lookupAddressField('administrative_area_level_1');
       // debug('province:' . $province);
        return( ClassRegistry::init('Province')->updateProvince( trim($province)) );
    }

    function _getVenueRegion( $provinceId) {
        $region = $this->_lookupAddressField('administrative_area_level_2');
        debug('region:' . $region);
        // now ask model to get the id, adding new record if nessassary
        return( ClassRegistry::init('Region')->updateRegion( trim($region),
                $provinceId ) );
    }

    function _getVenueCity( $regionId) {
        $city = $this->_lookupAddressField('locality');
        //debug('city:' . $city);
        return( ClassRegistry::init('City')->updateCity( trim($city), $regionId) );
    }

    function _getVenueCityName() {
        return($this->_lookupAddressField('locality'));
    }

    function _lookupAddressField($fieldName) {
        // loop through address array untill we find the matching field,
        //  then get its value

        // type: value , Type: array
        foreach( $this->addressData as $address) {

            if ( isset($address['AddressComponent']['type']) ) {
                $type = $address['AddressComponent']['type'];
            } else if ( isset($address['AddressComponent']['Type']) ) {
                $type = $address['AddressComponent']['Type'][0];
            }else {
                debug('type/Type not set');
            }
            if ( $type == $fieldName)
                return($address['AddressComponent']['long_name']);
        }
    }
*/
}
?>
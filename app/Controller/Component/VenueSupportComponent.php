<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class VenueSupportComponent extends Component {
    
    
    
    function processNearbyVenues($nearby) {
        foreach( $nearby as $i => $row ) {
            $nearby[$i]['Venue']['distance'] = $this->distance( $row[0]['distance'] );
        }
        return($nearby);
    }
    /*
     * Displays a number as distance, in metres and kilometres
     * params:
     * $distance (kilometres)
     */
    function distance( $distance, $unit = 'metres') {
        //debug($distance);
		//  1 kilometer = 0.621371192 miles
		
		if ( Configure::read('Vcc.measurement_units') == 'miles' || $unit == 'miles') {
			$distance = floatval($distance) * 0.621371192; 
			return( round(floatval($distance), 2) . ' miles' );
		} else {
			if ( $distance >= 1) {
				return( round(floatval($distance), 1) . 'km' );
			} else {
				return( round(floatval($distance) * 1000, 0) . 'm' );
			}
		}
    }
    /*
     * Builds a clone of a venue, removes fields
     * params:
     * nearby (array of nearby intersection, ect. ) 
     * phone, hours (array of days), 
     * features (added 16-Oct-12) (array of additinal features)
     */
    function cloneVenue( $venue, $location, $params = null ) {
        
       
        unset($venue['Venue']['id']);
        unset($venue['VenueDetail']['id']);
        unset($venue['Venue']['created']);
        unset($venue['Venue']['modified']);
        
        
        $venue['Venue']['publish_state_id'] = 1; // pending
        $venue['Venue']['geo_lat'] = $location['lat'];
        $venue['Venue']['geo_lng'] = $location['lng'];
        $venue['Venue']['slug'] = '';
        $venue['Venue']['address'] = $location['street_address'];
        $venue['Venue']['province_id'] = $location['province_id'];
        $venue['Venue']['region_id'] = $location['region_id'];
        $venue['Venue']['city_id'] = $location['city_id'];
        $venue['Venue']['city_region_id'] = $location['city_region_id'] ? $location['city_region_id'] : 0 ;
        $venue['Venue']['city_neighbourhood_id'] = $location['city_neighbourhood_id'];
        $venue['Venue']['postal_code'] = $location['postal_code'];
        $venue['Venue']['intersection_id'] = 0;
       
        // for streetview
        $venue['VenueDetail']['streetview_lat'] = $location['lat'];
        $venue['VenueDetail']['streetview_lng'] = $location['lng'];
        $venue['VenueDetail']['streetview_zoom'] = 1;
        $venue['VenueDetail']['streetview_heading'] = 0; 
        $venue['VenueDetail']['streetview_pitch'] = 0;
        
        
        
        if ( isset($params['nearby'])) {
            
            $nearbyVenue = $params['nearby'];

            if ( ($venue['Venue']['city_region_id'] < 1) && $nearbyVenue['cityRegionId'] ) 
                $venue['Venue']['city_region_id'] = $nearbyVenue['cityRegionId'];

            if ( ($venue['Venue']['city_neighbourhood_id'] < 1) && $nearbyVenue['cityNeighbourhoodId'] ) 
                $venue['Venue']['city_neighbourhood_id'] = $nearbyVenue['cityNeighbourhoodId'];

            if ( $nearbyVenue['intersectionId'] ) 
                $venue['Venue']['intersection_id'] = $nearbyVenue['intersectionId'];           

        }
        
        // phone passed in
        if ( isset($params['phone'])) {
            $venue['Venue']['phone_1'] = $params['phone'];
        } else {
            $venue['Venue']['phone_1'] = '000.000.0000';
        }
        
        // website passed in
        if ( isset($params['website'])) {
            $venue['Venue']['website_url'] = $params['website'];
        } 
        
        // hours passed in
        if ( isset($params['hours'])) {
            $venue['Venue']['hours_sun'] = $params['hours']['hours_sun'];
            $venue['Venue']['hours_mon'] = $params['hours']['hours_mon'];
            $venue['Venue']['hours_tue'] = $params['hours']['hours_tue'];
            $venue['Venue']['hours_wed'] = $params['hours']['hours_wed'];
            $venue['Venue']['hours_thu'] = $params['hours']['hours_thu'];
            $venue['Venue']['hours_fri'] = $params['hours']['hours_fri'];
            $venue['Venue']['hours_sat'] = $params['hours']['hours_sat'];
        }
        

        
        
        // set last verifed to today
        $venue['Venue']['last_verified'] = date( 'Y-m-d'); // today
        
        // now get all the features
        $features = Hash::extract( $venue['VenueFeature'], '{n}.id' );
        
        // additional features passed in (array of feature IDs)
        if ( isset($params['features'])) {
            $features = array_merge( $features, $params['features'] );
        }
        
        
        unset($venue['VenueFeature']);
        $venue['VenueFeature']['VenueFeature'] = $features;
        
        
        return($venue);
        
        /*
         * 
            unset($record['Venue']['id'],
                    $record['VenueDetail']['id'],
                    $record['Venue']['last_verified'],
                    $record['Venue']['created'],
                    $record['Venue']['modified']);

            // next 5 for/each clear out venue_id/id so orginal venue record not broken
            foreach( $record['VenueFeature'] as $i => $row) {
                unset( $record['VenueFeature'][$i]['VenuesVenueFeature']['id']);
                unset( $record['VenueFeature'][$i]['VenuesVenueFeature']['venue_id']);
            }

            debug($record);
            $record['Venue']['intersection_id'] = 0;
            $record['Venue']['city_neighbourhood_id'] = 0;
            $record['Venue']['city_region_id'] = 0;
            $record['Venue']['slug'] = '';
            $record['Venue']['publish_state_id'] = 0;
					
            $record['Venue']['phone'] = '000.000.0000';

            $data = $this->Location->geocodeAddress($address);
            //debug($data);

            $record['Venue']['geo_lat'] = $data['lat'];
            $record['Venue']['geo_lng'] = $data['lng'];
            $record['Venue']['address'] = $data['street_address'] .'.';
            $record['Venue']['postal_code'] = $data['postal_code'];
			
            // try and guess intersection and region by looking at nearby venues
            $nearbyVenues = $this->Location->getNearbyIntersection( $data['lat'], $data['lng'] );
            if ( !empty($nearbyVenues) ) {
                $record['Venue']['intersection_id'] = $nearbyVenues['intersectionId'];
                $record['Venue']['city_neighbourhood_id'] = $nearbyVenues['cityNeighbourhoodId'];
                $record['Venue']['city_region_id'] = $nearbyVenues['cityRegionId'];
            }			
			
            // add the city name as a guess for what this new venue should be
            $record['Venue']['sub_name'] .= ' (' . $data['city'] .')';
            
            $record['Venue']['slug'] . '-' . $data['city'];

            // set-up region, city id
            $record['Venue']['region_id'] = $data['region_id'];
            $record['Venue']['city_id'] = $data['city_id'];

         */
    }
}
?>

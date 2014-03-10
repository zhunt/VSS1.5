<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ApiController extends AppController {

    var $uses = array('Venue', 'Map');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }     
    
    /*
     * Returns:
     * 
     * {
        "Venue.name": "Second Cup",
        "Venue.sub_name": "(Bloor at Spadina)",
        "Venue.slug": "second-cup-bloor-spadina",
        "Venue.phone_1": "416.923.2767",
        "Venue.address": "324 Bloor St. W.",
        "Venue.geo_lat": "43.666756",
        "Venue.geo_lng": "-79.403358",
        "Venue.hours_sun": "7:30am - 11:00pm",
        "Venue.hours_mon": "7:30am - 11:00pm",
        "Venue.hours_tue": "7:30am - 11:00pm",
        "Venue.hours_wed": "7:30am - 11:00pm",
        "Venue.hours_thu": "7:30am - 11:00pm",
        "Venue.hours_fri": "7:30am - 11:00pm",
        "Venue.hours_sat": "7:30am - 11:00pm",
        "City.name": "Toronto",
        "Province.name": "Ontario"
        }
     * 
     */
    function get_venue_basic($id) {
        
        $id = intval($id);
        
        //debug($this->params);
        $result = $this->Venue->find('first', array(
            'conditions' => array('Venue.Id' => $id, 'Venue.publish_state_id' => VENUE_PUBLISHED ),
            'fields' => array( 'name', 'sub_name', 'slug', 'phone_1', 'address', 'geo_lat', 'geo_lng',
                'hours_sun', 
                'hours_mon', 
                'hours_tue', 
                'hours_wed', 
                'hours_thu', 
                'hours_fri', 
                'hours_sat', 
                ),
            'contain' => array('City.name', 'Province.name')
        ));
        $venue = $result;
        
        $venue = Hash::flatten($venue);
        //unset($venue['City.id']);
        //unset($venue['Province.id']);
        //debug($result);
        
        
        $this->set( compact('venue'));
    }
    
    
    function get_map_basic($id) {
        
        $id = intval($id);
        
        $result = $this->Map->find('first', array(
            'conditions' => array('Map.id' => $id ),
            'contain' => array('MapLocation' => array(
                'name', 'address', 'geo_lat', 'geo_lng', 'phone_1', 
                //'hours_sun', 'hours_mon', 'hours_tue', 'hours_wed', 'hours_thu', 'hours_fri', 'hours_sat',
                //'notes'
          
                )
                )
            ));
        
        //debug($result);
        
        $map = $result;
        
        $this->set(compact('map'));
        
    }
}

?>

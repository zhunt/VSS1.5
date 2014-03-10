<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class VenueFeaturesComponent extends Component {

    /*
     * group: STORE_TYPE|AMENITY|SERVICE|PRODUCT
     */
    function getVenueFeatures ( $venue, $group = 'STORE_TYPE') {
        
        $features = array();
        foreach( $venue['VenueFeature'] as $i => $row ) {
            if ( $row['group'] != $group ) continue;  
            $features[ $row['slug'] ] = $row['name'];
        }        
        
        return $features;
    }
}
?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SeoComponent extends Component {
    var $helpers = array('Text');
    
    /*
     * should return title, meta, keywords in array
     */
    function setVenueMeta( $venue) {

            $title = '';
            
            // check for SEO title set, if not just make title from name
            if ( !empty($venue['Venue']['seo_title'])) {
                $title = trim($venue['Venue']['seo_title']);
            } else {
                $title = trim( $venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name']);
            }
            
            $desc = '';
            // same for meta desc.
            if ( !empty($venue['Venue']['seo_desc'])) {
                $desc = trim($venue['Venue']['seo_desc']);
            } else {
                $desc = trim(substr( $venue['Venue']['description'], 150) );
            }
            
            $keywords = '';
            // mix of features
             if ( !empty($venue['VenueFeature'])) {
                 
                 $result = Hash::extract( $venue['VenueFeature'], '{n}.name');
                 
                 $result[] = $venue['City']['name'];
                 
                 if ( !empty( $venue['CityRegion']['name'] ))
                    $result[] = $venue['CityRegion']['name'];
                 
                 if ( !empty( $venue['CityNeighbourhood']['name'] ))
                    $result[] = $venue['CityNeighbourhood']['name'];                 
                 
                 $keywords = implode( ', ',  $result);
                 
             }
            
            
            
            return ( array('title' => $title, 'desc' => $desc, 'keywords' => $keywords ));
        
    }      
    
    function setVenueMapMeta( $venue) {

            $title = '';
            
            // check for SEO title set, if not just make title from name
            if ( !empty($venue['Venue']['seo_title'])) {
                $title = 'Map of ' . trim($venue['Venue']['seo_title']);
            } else {
                $title = 'Map of ' . trim( $venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name']);
            }
            
            $desc = '';
            // same for meta desc.
            if ( !empty($venue['Venue']['seo_desc'])) {
                $desc = 'Map for ' . trim($venue['Venue']['seo_desc']);
            } else {
                $desc = 'Map for ' . trim(substr( $venue['Venue']['description'], 150) );
            }
            
            $keywords = '';
            // mix of features
             if ( !empty($venue['VenueFeature'])) {
                 
                 $result = Hash::extract( $venue['VenueFeature'], '{n}.name');
                 
                 $result[] = 'map';
                 $result[] = 'location';
                 
                 $result[] = $venue['City']['name'];
                 
                 if ( !empty( $venue['CityRegion']['name'] ))
                    $result[] = $venue['CityRegion']['name'];
                 
                 if ( !empty( $venue['CityNeighbourhood']['name'] ))
                    $result[] = $venue['CityNeighbourhood']['name'];                 
                 
                 $keywords = implode( ', ',  $result);
                 
             }
            
            
            
            return ( array('title' => $title, 'desc' => $desc, 'keywords' => $keywords ));
        
    } 
    
    /*
     * Cities landing page
     */
    function setCityMeta($city, $params = null) {
        
        if ( $city['City']['name'] == $city['Province']['name'] ) { // for New York, New York
            $title = trim( $city['City']['name']);
        } else {
            $title = trim( $city['City']['name']. ', ' . $city['Province']['name'] );
        }
        
        if ( isset($params['titleText'])) {
            $title = $title . ' ' . $params['titleText'];
        }
        
        
        if ( isset($params['descText'])) {
            $desc = $params['descText'] . ' ' . $city['City']['name'] . ', ' . $city['Province']['name'];
        } else {
            $desc = 'description for ' . $city['City']['name'] . ', ' . $city['Province']['name'];
        }
        
        $keywords = '';
       
        
        $neighbourhoods = Hash::extract( $city['CityNeighbourhood'], '{n}.name');
        $regions = Hash::extract( $city['CityRegion'], '{n}.name');
        
        $result = array_merge( (array)$city['City']['name'], $regions, $neighbourhoods, (array)$city['Province']['name'] );
        
        $keywords = implode(', ', $result);
     
       // debug($result);
        return ( array('title' => $title, 'desc' => $desc, 'keywords' => $keywords ));
    }
    
    /*
     * generates title, desc. for seach results
     * keywords used for on-screen display
     */
    function setSearchMeta( $terms ,$location, $pageNumber = null, $default = null) {
        //debug($terms); debug($location); debug($pageNumber);
        
       
        $title = implode(', ', (array)$terms) . implode(',', (array)$location);
        
        if ( empty($terms) )
            $title = $default . ' ' . $title;
        
        $desc = 'Search results for ' . $title . ', page ' . $pageNumber;
        
        if (!empty($terms))
            $keywords = implode(', ', $terms);
        else
            $keywords = implode(', ', $location);
        
        $title = $title . ' | ' . $pageNumber;
        
        
        return ( array('title' => $title, 'desc' => $desc, 'keywords' => $keywords ));
    }
    
    /*
     * Just returns params for now
     */
    function setCityPageMeta( $params) {
        
        
        return ( array('title' => $params['titleText'], 'desc' => $params['descText'], 'keywords' => implode(',', $params['keywords'] ) ));
    }
    
    /*
     * Facebook / OpenGraph tags set-up
     * ---
     * params:
     * seo: array with title, desc, keywords
     * defaultImg: - image to use 
     * ogName: name of site
     * ogType: type of  
     */
    function setOpengraph( $params) {
        $defaults = array( 
            'defaultImage' => Configure::read('OpenGraph.default_image'), 
            'ogSiteName' => Configure::read('OpenGraph.site_name'),
            'ogType' => 'website',
              );
        
        $params = array_merge($defaults, $params);
        
        
        // check if street-view data passed in
        if ( isset($params['venue'])) {
            // get the map cords
            if ( $params['venue']['Venue']['geo_lat'] ) {
                $mapCentre = $params['venue']['Venue']['geo_lat'] . ',' . $params['venue']['Venue']['geo_lng'];
            }
            if ( isset($params['venue']['VenueDetail']['streetview_lat']) && !empty($params['venue']['VenueDetail']['streetview_lat']) ) {
                $streetviewCords = $params['venue']['VenueDetail']['streetview_lat'] . ',' . $params['venue']['VenueDetail']['streetview_lng'];
                // convert the code from zoom to FOV (JS uses map zoom, static uses FOV)
                $streetviewFov =  (float)180.0/pow(2, (float)$params['venue']['VenueDetail']['streetview_zoom'] );
                $streetviewHeading = $params['venue']['VenueDetail']['streetview_heading'];
                $streetviewPitch = $params['venue']['VenueDetail']['streetview_pitch'];
            }
        }
        

        
        
        // map
        if ( isset($mapCentre))
            $mapUrl = "http://maps.google.com/maps/api/staticmap?center={$mapCentre}&zoom=17&markers={$mapCentre}&size=400x400&sensor=false&scale=1";
        
        if ( isset($streetviewCords))
            $streetviewUrl = "http://maps.googleapis.com/maps/api/streetview?size=400x300&location={$streetviewCords}&fov={$streetviewFov}&heading={$streetviewHeading}&pitch={$streetviewPitch}&sensor=false";
            
       
        if ( isset($streetviewUrl)) {
            $ogImage = $streetviewUrl;
            $streetviewImg = $streetviewUrl;
        } else if ( isset($mapUrl)) {
            $ogImage = $mapUrl;
        } else {
            $ogImage = Configure::read('Website.url') . $params['defaultImage'];
        }
        unset( $params['venue']);
        
        /*
         * Handle setting-up meta for Posts
         */
        if ( isset($params['post'])) {
            $ogImage =
                Configure::read('Website.url') . '/uploads/post/image_1/thumb/medium/' . $params['post']['Post']['image_1'];   
            
            // canicol url
            $params['url'] = Configure::read('Website.url') . '/posts/' . $params['post']['Post']['slug'];
        }        
        
        //debug($params);
        
        $output = array(
            'ogTitle' => $params['seo']['title'],
            'ogDesc' => $params['seo']['desc'],
            'ogType' => $params['ogType'],
            'ogUrl' => $params['url'],
            'ogSiteName' => $params['ogSiteName'],
            'ogImage' => $ogImage
        );
        
        if ( isset($streetviewImg))
             $output['streetViewImage'] = $streetviewImg;
        
        return($output);
    }
    
    /*
     * Microformats
     * Builds up an array of formatted data for microformat elment
     */
    function setMicroformat($venue) {
    
        $output = array(
            'name' => trim($venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name']),
            'address' => $venue['Venue']['address'],
            'locality' => $venue['City']['name'] ,
            'region' => $venue['Province']['name'],
            'postal' => $venue['Venue']['postal_code'],
            'country' => Configure::read('Vcc.country'),
            'geo_lat' => $venue['Venue']['geo_lat'],
            'geo_lng' => $venue['Venue']['geo_lng'],
            'phone' => $venue['Venue']['phone_1'],
            'website' => $venue['Venue']['website_url']
        );
        
        return($output);
    }
    
    /*
     * sets-up meta-data for a post
     */
    function setPostMeta($post) {
        $title = !empty($post['Post']['seo_title']) ? $post['Post']['seo_title'] : $post['Post']['name'];
        $title = htmlentities($title);
        
        $desc  = !empty($post['Post']['seo_desc']) ? $post['Post']['seo_desc'] : $post['Post']['dek'];
        if (empty($desc))
            $desc = substr( trim(strip_tags($post['Post']['post'])), 0, 150);
        
        $desc = htmlentities($desc);
        
        $tags = Hash::extract( $post['PostTag'], '{n}.name');;
        
        $keywords = implode( ', ', (array)$tags );
        return ( array('title' => $title, 'desc' => $desc, 'keywords' => $keywords ));
    }
    
}
?>

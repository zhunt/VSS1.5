<?php
App::uses('CakeResponse', 'Network');
App::uses('CakeRoute', 'Routing/Route');

class SlugRoute extends CakeRoute {
    function parse($url) { 
        $params = parent::parse($url);
        if (empty($params)) {
            return false;
        }
        $slugs = Cache::read('venue_slugs');
        if (empty($slugs)) {
            App::import('Model', 'Venue');
            $Venue = new Venue();
            $venues = $Venue->find('all', array(
                'fields' => array('Venue.slug'),
                'recursive' => -1
            ));
            $slugs = array_flip(Set::extract('/Venue/slug', $venues));
            Cache::write('venue_slugs', $slugs);
        }
        if (isset($slugs[$params['slug']])) {
            return $params;
        } 
        return false;
    }
}
?>

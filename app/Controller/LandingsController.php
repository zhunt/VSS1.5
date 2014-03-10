<?php
class LandingsController extends AppController {

    public $helpers = array('Html', 'Cache', 'Session', 'Advert');
    var $uses = array('Venue', 'Post');
    var $components = array('Seo');
    
    public $cacheAction = array(
        'home' => 36000
    );     
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('home');
    }  
    
    function home() {
        
        // some kind of SEO set-up here?
        // 
        
        
        // load newest venues
        
        $result = $this->Venue->find('all', array(
                                    'conditions' => array('Venue.publish_state_id ' => VENUE_PUBLISHED ),
                                    'fields' => array('name','slug', 'sub_name', 'geo_lat', 'geo_lng', 'seo_desc'),    
                                    'contain' => array('City.name', 'Province.name', 'BusinessType1.name'),
                                    'order' => 'Venue.created DESC',
                                    'limit' => 4) 
                                );
        $newVenues = $result; // debug($newVenues); exit;
        
        // load list of provinces / cities
       
        
        // load list of cities
        $result = $this->Venue->Province->City->find('all', array(
                                    
                                            'fields' => array('name', 'slug', 'venue_count' ), 
                                            'conditions' => array('City.venue_count > ' => 0, 'City.flag_show' => true ),
                                            'order' => array('City.venue_count DESC', 'City.name ASC' ),
                                            'contain' => false,
                                            'limit' => 12
                                            
                                        )    
                                );        
        
        $cities = $result;
        
        // get recent articles
        
        $reviewCategories = $this->Post->PostCategory->find('list', 
                array('fields' => array('id'), 'conditions' => array('PostCategory.parent_id' => 3) ) );
        //debug($reviewCategories);
        $result = $this->Post->find('all', array(
            'conditions' => array('Post.publish_state_id ' => VENUE_PUBLISHED,
                'Post.post_category_id' => $reviewCategories),
            'contain' => false,
            'order' => 'Post.created desc',
            'limit' => 5,
            'fields' => array('name', 'sub_name', 'slug', 'dek', 'image_1', 'created')
            )
            );
        
        $newReviews = $result;
        
        $result = $this->Post->find('all', array(
            'conditions' => array('Post.publish_state_id ' => VENUE_PUBLISHED,
                'Post.post_category_id' => 5),
            'contain' => false,
            'order' => 'Post.created desc',
            'limit' => 5,
            'fields' => array('name', 'sub_name', 'slug', 'dek', 'image_1', 'created')
            )
            );        
        
        $newsItems = $result;
        
        // SEO set-up
        $this->set('title_for_layout', 'BooksVancouver.ca: Vancouver and GVA bookstores, used books, comic books and more.');
        $metaDescription = 'BooksVancouver.ca is your guide to bookstores in Vancouver and the GVA in British Columbia, Canada.';
        $metaKeywords = 'Vancouver';
        
        $seo = array('title' => 'BookstoresCanada', 'desc' => $metaDescription );
        $openGraph = $this->Seo->setOpengraph( array(
                    'seo' => $seo, 
                    'url' => Configure::read('Website.url') . $this->request->here
                ) );
            
                
        $this->set( compact('newVenues', 'cities', 'seo', 'openGraph', 'metaDescription', 'metaKeywords', 'newReviews', 'newsItems') );
    }
    
    
}
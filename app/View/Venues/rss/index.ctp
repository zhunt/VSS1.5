<?php

// You should import Sanitize
App::uses('Sanitize', 'Utility');

$this->set('channelData', array(
    'title' => __("Most Recent Venues"),
    'link' => $this->Html->url('/', true),
    'description' => __("Most recent venues."),
    'language' => 'en-us'
));

foreach ($venues as $venue) {
    $venueTime = strtotime($venue['Venue']['modified']);

    $venueLink = array(
        'controller' => 'company',
        'action' => '/',
        //'year' => date('Y', $venueTime),
        //'month' => date('m', $venueTime),
        //'day' => date('d', $venueTime),
        $venue['Venue']['slug']
        
         
    );
    $venueLink = Configure::read('Website.url') . '/company/' . $venue['Venue']['slug'];
    

    // This is the part where we clean the body text for output as the description
    // of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $venue['Venue']['seo_desc']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 150, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));

    echo  $this->Rss->item(array(), array(
        'title' => trim($venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name']) ,
        'link' => $venueLink,
        'guid' => array('url' => $venueLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'pubDate' => $venue['Venue']['created']
    ));
}
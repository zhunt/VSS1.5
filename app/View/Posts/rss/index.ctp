<?php

// You should import Sanitize
App::uses('Sanitize', 'Utility');

$this->set('channelData', array(
    'title' => __("Most Recent Posts"),
    'link' => $this->Html->url('/', true),
    'description' => __("Most recent posts."),
    'language' => 'en-us'
));

foreach ($posts as $post) {
    $postTime = strtotime($post['Post']['created']);

    $postLink = array(
        'controller' => 'company',
        'action' => '/',
        //'year' => date('Y', $postTime),
        //'month' => date('m', $postTime),
        //'day' => date('d', $postTime),
        $post['Post']['slug']
        
         
    );
    $postLink = Configure::read('Website.url') . '/posts/' . $post['Post']['slug'];
    

    // This is the part where we clean the body text for output as the description
    // of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $post['Post']['dek']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    /*$bodyText = $this->Text->truncate($bodyText, 150, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));
*/
    echo  $this->Rss->item(array(), array(
        'title' => trim($post['Post']['name'] . ' ' . $post['Post']['sub_name']) ,
        'link' => $postLink,
        'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'pubDate' => $post['Post']['created']
    ));
}
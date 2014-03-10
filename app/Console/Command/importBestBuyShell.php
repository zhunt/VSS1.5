<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');
App::uses('Hash', 'Utility');
App::uses('File', 'Utility');
App::uses('Sanitize', 'Utility');


App::import('Vendor', 'phpQuery/phpQuery');

class ImportBestBuyShell extends Shell {
  
    function main() {
        
        $urls = array(
            'http://stores.bestbuy.com/1900/',
            'http://stores.bestbuy.com/1901/',
            'http://stores.bestbuy.com/1902/',
            'http://stores.bestbuy.com/1903/',
            'http://stores.bestbuy.com/1904/',
            'http://stores.bestbuy.com/1905/',
            'http://stores.bestbuy.com/1906/',
            'http://stores.bestbuy.com/1908/',
            'http://stores.bestbuy.com/1910/',
            'http://stores.bestbuy.com/1912/',
            'http://stores.bestbuy.com/1913/',
            'http://stores.bestbuy.com/1914/'
        );
        
        foreach($urls as $url)
            $this->scrapePageInfo($url);
        
        exit;
        
        
        $this->out( array('Welcome. This will find pages with venue on them', 'enter the start end numbers' ) );
        $startAt =  intval( $this->in( 'Start at number:',null,10 ) );
        $endAt =    intval($this->in( 'Finish at number:',null,15 ) );
        
        $url = 'http://stores.bestbuy.com/';
        
        $storeFinderUrl = $this->in('Store finder URL:', null, $url);
        
        $outputFile = $this->in('Output file:', null, 'stores_found.txt');
        
        $this->out('counting from ' . $startAt . ' to ' .  $endAt, 1 );
        
        $urls = $this->getCandidatePageUrls( $startAt, $endAt, $outputFile, $storeFinderUrl );
        //debug($choice);
        
    }
    
    function getCandidatePageUrls( $startAt, $endAt, $outputFile, $storeFinderUrl ) {
        $goodUrls = array();
       
        for( $i= $startAt; $i <= $endAt; $i++ ) {
            
            $storePageUrl = $storeFinderUrl . $i . '/';
            
            //$storePageUrl = 'http://stores.bestbuy.com/54/';
            
            $this->out('processing: ' . $storePageUrl, 1);
            
            $doc = phpQuery::newDocumentHTML($storePageUrl);
            
            if (!$doc) {
                $this->out('ERROR loading ' . $storePageUrl );
            } else {
                phpQuery::newDocumentFileHTML($storePageUrl);

                $titleElement = pq('title')->html(); // in jQuery, this would return a jQuery object.  I'm guessing something similar is happening here with pq.
                
                if ($titleElement) {
                    $this->out($titleElement, 1);
                    $goodUrls[] = $storePageUrl;
                }
            }
            
        }
        
        $file = new File( WWW_ROOT . DS . $outputFile );
        
        $data = '';
        foreach( $goodUrls as $url) {
            $data .= $url . "\n";
        }
        
        $file->write($data);
        $file->close();
    }
    
    /*
     * 
     */
    function scrapePageInfo( $url = 'http://stores.bestbuy.com/6/') {
        $this->out('processing: ' . $url, 1);
        phpQuery::newDocumentFileHTML($url);   
        
        $titleElement = pq('title')->html();
        //debug($titleElement);
        $name = pq('h1#site_title a')->html();
        
        // make sure venue isn't closed
        if (strpos( strtolower($name), 'closed'))
            return;        
        
        $subname = explode('-', $name);
        $name = trim($subname[0]);
        $subname = trim($subname[1]);
        
        $this->out($name . ' + ' . $subname,1);
            
        $address = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div p.geo strong')->text();
               
        $address = str_replace("\n", ', ', trim($address));

        //debug($address);
        
        // Phone
        $phone = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div p.geo span span')->text();
        
        $phone = explode("\n", $phone);
        
        if (is_array($phone))
            $phone = $phone[0];
        
        //debug($phone);
        
        // Geo - pull out the line starting with 'GEO:'
        $geoBlock = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div span')->text();
        
        preg_match('/GEO: (.*)/', $geoBlock, $matchs);
        
        $geoBlock = explode(',', $matchs[1]);
        $geoLat = trim($geoBlock[0]); $geoLng = trim($geoBlock[1]);
        
        $this->out($address,1);
        $this->out($phone,1);
        $this->out( $geoLat . ' - ' . $geoLng,1);
        
        // Hours
        
        for ($i=0; $i < 7; $i++) {
            $hoursBlock0 = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div.hours ul li.day' . $i )->text();
            $hoursBlock0 = Sanitize::paranoid( $hoursBlock0, array(' ', ':') );

            $hoursBlock0 = str_ireplace( array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') , '', $hoursBlock0);

            $hoursBlock0 = trim( str_ireplace( array('a', 'p') , array('am - ', 'pm') , $hoursBlock0) );
            $hours[$i] = $hoursBlock0;
            
        }
        $this->out( print_r($hours));
        
        // services 
        $services = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div.store_services ul')->html();
        
        $services = strip_tags($services, 'li');
        
        $services = explode("\n", trim($services) );
        
        //$this->out( print_r($services));
        
    }
}
?>
<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');
App::uses('Hash', 'Utility');
App::uses('File', 'Utility');
App::uses('Sanitize', 'Utility');




App::import('Vendor', 'phpQuery/phpQuery');

class ImportFutureshopShell extends Shell {
    
    var $listOfUrlsToImport = array();
  
    function main() {
       
  

            
        //$this->getListOfGoodUrls();    
        
        $url = 'http://www.futureshop.ca/api/v2/json/locations/682?lang=en-CA&proximity=30&callback=mwasinglestore&_=1344226440431';
        $this->scrapeFutureshopPageJson($url);

        exit;
        
        $zipCodes = array_slice($zipCodes, 1, 1);
       
        $bigVenueList = array();
        foreach ( $zipCodes as $zip) {
            $venues = $this->scrapeGamestopSearchResults($zip);
            $bigVenueList = array_merge( $bigVenueList, $venues);
        }
        
        debug($bigVenueList);
        
        exit;
        
       
        
        exit;
        //
        
        $this->out( array('Welcome. This will find pages with venue on them', 'enter the start end numbers' ) );
        $startAt =  intval( $this->in( 'Start at number:',null,10 ) );
        $endAt =    intval($this->in( 'Finish at number:',null,15 ) );
        
        $url = 'http://stores.bestbuy.com/';
        
        $storeFinderUrl = $this->in('Store finder URL:', null, $url);
        
        $outputFile = $this->in('Output file:', null, 'stores_found.txt');
        
        $this->out('counting from ' . $startAt . ' to ' .  $endAt, 1 );
        
        $urls = $this->getCandidatePageUrls( $startAt, $endAt, $outputFile, $storeFinderUrl );   
    }
 
    
    function getListOfGoodUrls() {
        
        $start = 1;
        $end = 1200;
        
        $searchUrl = 'http://www.futureshop.ca/api/v2/json/locations/20?lang=en-CA&proximity=30&callback=mwasinglestore&=1344226440431';
        
        $http = new HttpSocket();
        $request = array( 
            'header' => array(
                'User-Agent' => 'WebKit'
            )
        );
        
        $file = new File( WWW_ROOT . DS . 'bestbuy_ca_urls.txt' );
                
        for ($i = $start; $i <= $end; $i++) {
            $searchUrl = 'http://www.futureshop.ca/api/v2/json/locations/' . $i . '?lang=en-CA&proximity=30&callback=mwasinglestore&=1344226440431';
            
            $searchUrl = 'http://www.bestbuy.ca/api/v2/json/locations/' . $i . '?lang=en-CA&proximity=100&callback=mwasinglestore&_=1344226994218';
           
            $response = $http->get($searchUrl, null, $request);
            $code = $response->code;
            
            $this->out('$i = ' . $i . ', code: ' . $code, 1);
           
            
            if ( $code == 200) {
                $file->append($searchUrl . "\n");
            }
            //$this->out( substr($response, 0, 40),1);    
            
            /*
             * if good write out to file
             * 
             */
        }
        $file->close();
       
    }

    
    /*
     * used to crawl seach result pages for urls
     */
    function scrapeFutureshopPageJson($url ) {
        $url = 'http://www.futureshop.ca/api/v2/json/locations/682?lang=en-CA&proximity=100';
        $url = 'http://www.bestbuy.ca/api/v2/json/locations/948?lang=en-CA&proximity=100'; // BEst BUy
        $http = new HttpSocket();
        $this->out($url, 1);
        $response = $http->get($url);
      
        // Get the status code for the response.
        $code = $response->code;
        $this->out($code,1);
        //debug($response); 
        $results = json_decode($response->body, true);
        
        debug($results); 
      

        $venues = array();
        
        $row = $results['locations'][0];
        //debug($row); exit;
       
            $subName = trim( str_replace( array('Gamestop','Game Stop', '-'), '', $row['DisplayName'] ) );
            
            $venue = array(
                'name' => 'Best Buy',
                'sub_name' => $row['name'],
                'address' => "{$row['address1']}, {$row['city']}, {$row['region']}, {$row['postalCode']}, {$row['country']}",
                'lng' => $row['lat'],
                'lat' => $row['lng'],
                'phone' => str_replace( array( '(',') ', '-' ), array('', '.', '.') , $row['phone1']) ,
                'hours' => $this->processGamestopHours($row['hours']),
                'notes' => $row['landmark'],  
                'notes_services' => $this->processFutureshopServices($row['services']),
            );
       
        debug($venue); 
        exit;
        return $venue;
        
    }
    
    /*
     * get services
     */
    function processFutureshopServices($rows) {
        $result = '';
        if (is_array($rows)) {
            foreach ($rows as $i => $row) {
                $result[] = $row['serviceName'];
            }
            $result = implode(', ', $result);
        }
        return $result;
    }
    
    /*
     * used to re-format hours to ACD format
     */
    function processGamestopHours( $hours) {
        debug($str);
        
        $newHours = array(
            0 => $hours[6],
            1 => $hours[1], // over-ride short hours on monday holiday
            2 => $hours[1],
            3 => $hours[2],
            4 => $hours[3],
            5 => $hours[4],
            6 => $hours[5],
        );
        
        foreach ($newHours as $i => $hour) {
            $hours = trim(strtolower( str_replace( 
                    array( 'August 6' ,'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ) 
                    , '', $hour) ) );
            $hours = $string = preg_replace('/\s+/', '', $hours);

          
            $hours = trim(str_replace( array('am', 'pm'), array( ':00am', ':00pm'), $hours));
            $hours = str_replace( array(':30:00'), array(':30'), $hours);
            
            $hours = str_replace( array('-'), array(' - '), $hours);
            
            $newHours[$i] = $hours;
        }
        return $newHours;
        
       
      
        
    }
   
    
    /*
     * 
     */
    function scrapePageInfo( $url) {
        
        //debug($url);
        
        $http = new HttpSocket();
        $response = $http->get($url);
      
        // Get the status code for the response.
        $code = $response->code;
        $this->out($code,1);
        
        if ( $code != 200)
            $this->out('problem loading page for zipcode ' . $zipCode,1);

        phpQuery::newDocumentHTML($response->body);
    
        // store name
        $name = pq('div#store_name')->html();
        $this->out('Name: ' . $name,1);
        
        // phone
        $phone = trim(pq('div#wrapper div#store_details.content_box div.detail a.phone')->html());
       // $this->out("Phone: '{$phone}'" ,2);
        
        
        $address = pq('div#wrapper div#store_details.content_box div.detail')->html();
        
        $address = strip_tags($address, '<li><br>' );
        $address = explode("\n", $address);
        //$this->out( 'Address: ' . print_r($address),1);
        
        // now get
        $addressBlock = '';
        $hours = '';
        foreach ( $address as $i => $row) {
            $row = trim(strtolower($row));
            if ($row == 'address<br>') {
                $addressBlock = trim($address[ $i + 1 ]) . ' , ' . trim($address[ $i + 2 ]);
                // remove phone number from address block
                $addressBlock = preg_replace('/[0-9]{3}\-[0-9]{3}\-[0-9]{4}/', '', $addressBlock);
                //debug($addressBlock);
                $addressBlock = trim(str_replace('<br>', '', $addressBlock));
            }
            if ($row == 'store hours<br>') {
                $hours = trim($address[ $i + 1 ]);
                $hours = explode('<br>', $hours);
                //debug($hours);
                foreach( $hours as $key => $val) {
                    $temp = explode(':', $val, 2);
                    if ( sizeof($temp) == 2) {
                        $hours[ strtolower($temp[0]) ] = $temp[1];
                        unset( $hours[$key]);
                    } else {
                        unset( $hours[$key]);
                    }
                }
                
            }
        }
        
        //$hours = pq('html body div#wrapper div#store_details.content_box div.detail')->html();
        //debug($hours);
        // html body div#wrapper div#store_details.content_box div.detail
     
        
        $this->out('Address: ' . $addressBlock, 1);
        
        // process hours
        
        $newHours = array();
        foreach ($hours as $day => $val) {
            if ($day == 'mon-fri') {
                $newHours[1] = $val;
                $newHours[2] = $val;
                $newHours[3] = $val;
                $newHours[4] = $val;
                $newHours[5] = $val;
            }
            if ($day == 'sun') {
                $newHours[0] = $val;
            }
            if ($day == 'sat') {
                $newHours[6] = $val;
            }            
        }
        
       // $this->out( 'Hours: ' . print_r($hours, true) .  print_r($newHours, true),1 );
        
        
    }
}
?>
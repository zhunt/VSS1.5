<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');
App::uses('Hash', 'Utility');
App::uses('File', 'Utility');
App::uses('Sanitize', 'Utility');


//App::import('Vendor', 'QueryPath', array( 'file' => 'querypath' . DS . 'querypath' . DS . 'src' . DS . 'qp.php') );
 // \Vendor\querypath\querypath\src
//require 'QueryPath/src/QueryPath/qp.php';

// App::import('Vendor', 'WellNamed', array('file' => 'services' . DS . 'well.named.php'));


App::import('Vendor', 'phpQuery/phpQuery');

//App::uses('HtmlHelper', 'View/Helper');
App::uses('String', 'Utility');

class ImportBarnsShell extends Shell {

    // master list of venues and featues
    public $venuesData; 
    public $venueFeatures;

    public $featuresTable = array( 'Complimentary Wi-Fi' => 
                                        array('slug' => 'free_wifi', 'text' => 'Complimentary Wi-Fi'), 
                                    'Toys & Games' => 
                                        array('slug' => 'kids_toys', 'text' => 'toys and games' ), 
                                    'B&N@School' => 
                                        array('slug' => 'educational_resources', 'text' => 'B&N@School' ), 
                                    'Caf' => 
                                        array('slug' => 'cafe', 'text' => 'Starbucks Cafe' ) );    
  
    function main() {
        
        // urls to scrape for raw data
        $urls = array(
/*
          
            // washington
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=WA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=WA&zip=&sat=10',

            // texas
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TX&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TX&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TX&zip=&sat=20',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TX&zip=&sat=30',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TX&zip=&sat=40',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TX&zip=&sat=50',

            // arazona
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=AZ&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=AZ&zip=&sat=10',

            //New Mexico
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NM&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NM&zip=&sat=10',

            //Origan
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=OR&zip=&sat=0',



            // Nevada
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NV&zip=&sat=0',

            // south
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=LA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=AL&zip=&sat=0',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=GA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=GA&zip=&sat=10',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=MS&zip=&sat=0',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=SC&zip=&sat=0',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=SC&zip=&sat=0',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NC&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NC&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NC&zip=&sat=20',

            // north

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=IL&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=IL&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=IL&zip=&sat=20',
            
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=VA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=VA&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=VA&zip=&sat=20',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=MD&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=MD&zip=&sat=10',
         

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=KY&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=TN&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=OK&zip=&sat=0',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=MA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=MA&zip=&sat=10',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=Chula%20Vista&state=CA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=Chula%20Vista&state=CA&zip=&sat=10',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=Irvine&state=CA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=Irvine&state=CA&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=Irvine&state=CA&zip=&sat=20',

            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=Bakersfield&state=CA&zip=&sat=0',

*/


            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=PA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=PA&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=PA&zip=&sat=20',




   /*        
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=los+angles&state=CA&zip=&sat=0',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=los+angles&state=CA&zip=&sat=10',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=los+angles&state=CA&zip=&sat=20',
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=los+angles&state=CA&zip=&sat=30',

            // FL
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=FL&zip=&sat=0',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=FL&zip=&sat=10',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=FL&zip=&sat=20',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=FL&zip=&sat=30',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=FL&zip=&sat=40',
           

           // San Jose, area
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=san+jose&state=CA&zip=&sat=0',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=san+jose&state=CA&zip=&sat=10',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=san+jose&state=CA&zip=&sat=20',

           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=San+Francisco&state=CA&zip=&sat=0',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=San+Francisco&state=CA&zip=&sat=10',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=San+Francisco&state=CA&zip=&sat=20',

           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=sacraMENTO&state=CA&zip=&sat=0'
        

           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NY&zip=&sat=0',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NY&zip=&sat=10',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NY&zip=&sat=20',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NY&zip=&sat=30',
           'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=&state=NY&zip=&sat=40'

  */   


        );
        
        foreach($urls as $url) {
            $this->scrapPageBlocks($url); 

            $json = array(
                'venues' => $this->venuesData,
                'fetures' => $this->venueFeatures
            );

            file_put_contents('output.json', json_encode($json, JSON_PRETTY_PRINT) );
            debug('done');
            //$this->scrapePageInfo($url);
        
        }
        exit;
        // this part extracts valid urls
        
        $this->out( array('Welcome. This will find pages with venue on them', 'enter the start end numbers' ) );
        $startAt =  intval( $this->in( 'Start at number:',null,10 ) );
        $endAt =    intval($this->in( 'Finish at number:',null,15 ) );
        
        $url = 'http://www.chapters.indigo.ca/home/storeLocator/storeDetails/';
        
        $storeFinderUrl = $this->in('Store finder URL:', null, $url);
        
        $outputFile = $this->in('Output file:', null, 'stores_found.txt');
        
        $this->out('counting from ' . $startAt . ' to ' .  $endAt, 1 );
        
        $urls = $this->getCandidatePageUrls( $startAt, $endAt, $outputFile, $storeFinderUrl );
        
        
    }
    /*
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
                

                $titleElement = pq('div#__mdl_Store div.main h1')->html(); // in jQuery, this would return a jQuery object.  I'm guessing something similar is happening here with pq.
                
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
    */

    // get the main blocks with content (used when more than one venue on a page)
    function scrapPageBlocks($url) {
        $venueData = array();
       /* $urls = array( 
            'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=miami&state=FL&zip=#content',
            //'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=New+York&state=NY&sat=10',
            //'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=New+York&state=NY&sat=40',
            //'http://store-locator.barnesandnoble.com/storelocator/stores.aspx?pagetype=storeList&city=New+York&state=NY&sat=50'
        );

        $url = $urls[ rand(0,  sizeof($urls)-1 ) ] ; // pick one url
*/

        $this->out('processing page: ' . $url, 1);

        phpQuery::newDocumentFileHTML($url); 

         $titleElement = pq('title')->text();
        debug($titleElement);     



        // $block1 = pq('tr#2739')->text();
       // debug($block1);   

        foreach(pq('.storeDetails') as $i => $storeDetail) {

            $venueData = array(); // store data for this venue here 
            
            //debug($text);
            
            $venueData['name'] = 'Barnes & Noble';
            $venueData['sub_name'] = pq($storeDetail)->find('.storeNickname')->text();

            $data = $this->getStoreLattLong( pq($storeDetail)->find('#Index_MQAPointInfo')->text(), $venueData );
            $venueData = Hash::merge(  $venueData, $data);

            $venueData['website'] = pq($storeDetail)->find('.storeNickname a')->attr('href');

            

            $data = $this->getStoreAddressPhone( pq($storeDetail)->find('div.storeAddress')->contents()->text() , $venueData );
            $venueData = Hash::merge(  $venueData, $data);

            $venueData['venue_features_text'] = null; // reset each loop
            $data = $this->getStoreFeatures(  pq($storeDetail)->find('.storeAttributeslist')->text(), $venueData );
            $data['features'][] = 'online_store';// add online store and gift cards 
            $data['features'][] = 'gift_cards';
            $venueData = Hash::merge(  $venueData, $data);


            $data = $this->getStoreHours(  pq($storeDetail)->find('.storeHours')->text(),$venueData );
            $venueData = Hash::merge(  $venueData, $data);
            

            // clean-up
            $venueData['features'] = array_unique($venueData['features']);

            // add text list of features
            if ( !empty($venueData['venue_features_text']) ) { 
                $venueData['venue_features_text'] = array_unique($venueData['venue_features_text']);
                $venueData['features_text'] = 'Features available at this ' . $venueData['name'] . ' include: ' . String::toList( $venueData['venue_features_text']) . '.';
            }
            unset($venueData['venue_features_text']);

            // merge-in any new features into master list
            $this->venueFeatures = array_unique( array_merge( (array)$this->venueFeatures, $venueData['features'] ) );
            
           

            $temp = '';
            foreach( $venueData['notes'] as $field => $data ) {
                $temp .= ucfirst($field) . ": $data \n";    
            }
            $venueData['notes'] = $temp;
            $venueData['tracking_num'] =  trim(str_replace('.', '', $venueData['phone'] ) );

            //debug( $venueData) ;
            // if good, transfer to global $venuesData

            $this->venuesData[] = $venueData;


        } 


    }

    // extract from string like: 'StoreLat|26.265008|StoreLon|-80.250148|StoreNumber|2793'
    function getStoreLattLong( $text, $venueData ){
        // split str on "|"
        $array = explode('|', $text);
        if ( sizeof($array) < 5 ) return false;

        $pos = array_search('StoreLat', $array); // latt = pos of StoreLat + 1
        if ( $pos !== false ) $venueData['geo_latt'] = $array[$pos+1];
       
        $pos = array_search('StoreLon', $array); // long = post of StoreLon + 1
        if ( $pos !== false ) $venueData['geo_long'] = $array[$pos+1];        
        
        $pos = array_search('StoreNumber', $array); // notes = StoreNumber + 1
        if ( $pos !== false ) $venueData['notes']['location'] = $array[$pos+1];  

        return($venueData);
    }

    // extract from '2790 University DriveCoral Springs, FL 33065954-344-6291'
    function getStoreAddressPhone( $text, $venueData ){
       
        preg_match_all('/(.*)\n/i',$text,$matches); // split on newline char

        $addressArray = $matches[1];

        $venueData['phone'] = $addressArray[ sizeof($addressArray) -1 ]; // get the last one
        $venueData['phone'] = str_replace('-', '.', $venueData['phone']);
        unset( $addressArray[ sizeof($addressArray) -1 ] );

        $venueData['address'] = implode( ', ', $addressArray);
        $venueData['notes']['address'] = $text;

        return($venueData);
    }

    function getStoreFeatures( $text, $venueData ){
        $featuresTable = $this->featuresTable; // copy from global


        $features = array();
        foreach($featuresTable as $key => $data ) {
            if ( stripos( $text, $key) !== false ) {
                $features[] = $data['slug'];
                $venueData['venue_features_text'][]  = $data['text'];
            }
        }
        $venueData['notes']['features'] = $text;

        $venueData['features'] = $features;

        return($venueData);
    }

    // text: 'Store HoursSun-Thu 9:00AM-10:00PM | Fri-Sat 9:00AM-11:00PM'
    function getStoreHours( $text, $venueData ){
    
        $text = str_replace('Store Hours', '', $text); // remove 'Store Hours'
        $venueData['notes']['hours'] = $text;
        $array = explode('|', $text);

        $days = array();
        
    /* itintialize days array as 'closed' 
        look for pattern:
        Mon-Thu,
        Mon-Fri,
        Mon-Sat,
        Fri-Sat,
        Sun-Thu,
        Sun-Sat 
        Fri, 
        Sat,
        Sun,
        Mon,
        Tue,
        Wed,
        Thu

        On match, put hours in day(s) array
        Sunday = 0; Monday = 1
         */
        foreach( $array as $day) {
            if ( stripos($day, 'Mon-Thu') !== false) {
                $day = str_replace('Mon-Thu', '', $day); 
                $days['mon'] = $day; $days['tue'] = $day; $days['wed'] = $day; $days['thu'] = $day;
            }
            elseif ( stripos($day, 'Mon-Fri') !== false) {
                $day = str_replace('Mon-Fri', '', $day); 
                $days['mon'] = $day; $days['tue'] = $day; $days['wed'] = $day; $days['thu'] = $day; $days['fri'] = $day;
            }
            elseif ( stripos($day, 'Mon-Sat') !== false) {
                $day = str_replace('Mon-Sat', '', $day); 
                $days['mon'] = $day; $days['tue'] = $day; $days['wed'] = $day; $days['thu'] = $day; $days['fri'] = $day; $days['sat'] = $day;
            }
            elseif ( stripos($day, 'Fri-Sat') !== false) {
                $day = str_replace('Fri-Sat', '', $day); 
                $days['fri'] = $day; $days['sat'] = $day;
            }
            elseif ( stripos($day, 'Sun-Thu') !== false) {
                $day = str_replace('Sun-Thu', '', $day); 
                $days['sun'] = $day; $days['mon'] = $day; $days['tue'] = $day; $days['wed'] = $day; $days['thu'] = $day;
            }  
            elseif ( stripos($day, 'Sun-Sat') !== false) {
                $day = str_replace('Sun-Sat', '', $day); 
                $days['sun'] = $day; $days['mon'] = $day; $days['tue'] = $day; $days['wed'] = $day; $days['thu'] = $day; $days['fri'] = $day; $days['sat'] = $day;
            } 
            elseif ( stripos($day, 'Fri') !== false) {
                $day = str_replace('Fri', '', $day);
                $days['fri'] = $day;
            }             
            elseif ( stripos($day, 'Sat') !== false) {
                $day = str_replace('Sat', '', $day); 
                $days['sat'] = $day;
            } 
            elseif ( stripos($day, 'Sun') !== false) {
                $day = str_replace('Sun', '', $day);
                $days['sun'] = $day;
            }
            elseif ( stripos($day, 'Mon') !== false) {
                $day = str_replace('Mon', '', $day); 
                $days['mon'] = $day;
            }
            elseif ( stripos($day, 'Tue') !== false) {
                $day = str_replace('Tue', '', $day); 
                $days['tue'] = $day;
            }
            elseif ( stripos($day, 'Wed') !== false) {
                $day = str_replace('Wed', '', $day); 
                $days['wed'] = $day;
            }
            elseif ( stripos($day, 'Thu') !== false) {
                $day = str_replace('Thu', '', $day); 
                $days['thu'] = $day;
            }            

        }

        foreach ($days as $i => $value) {
            $days[$i] = trim(strtolower( str_replace('-', ' - ', $value) ) );
        }

        $venueData['hours'] = $days;
        return($venueData);
    }    


    /*
     * 
     */
    function scrapePageInfo( $url = 'http://stores.bestbuy.com/6/') {
        $this->out('processing: ' . $url, 1);
        phpQuery::newDocumentFileHTML($url);   
        
        //$titleElement = pq('div#__mdl_Store div.main h1')->html();
        //debug($titleElement);
        $locationName = pq('div#__mdl_Store div.main h1')->html();
        
        // find the Javascript blocks
        $scripts = pq('script')->html();
        
        //debug($scripts);
        
       
        // ... and extract the mapInfo from the script 
        $result = preg_match_all('/var mapInfo=\[(.*)\];/s', $scripts, $arr, PREG_PATTERN_ORDER);
        //debug($result);
        $result = $arr[0][0];
        
        // ... chop off the extra bits
        $result = str_replace( array('var mapInfo=[', '}];', '"'), '', $result);
        //debug($result );
        
        // ... extract the location, etc. key and value from the script 
        $results2 = preg_match_all('/([a-zA-Z]{1,10}):([^,]{1,200}),/s', $result, $arr, PREG_PATTERN_ORDER);;
        // ... and re-build as php array
        $locationData = array_combine($arr[1], $arr[2]);
         
        // debug($locationData);
        
        // Now start building the firlds that will be saved
        $subname = trim( $locationData['name'] );
        $name = trim( $locationData['storeType'] );
        
        
        $this->out($name . ' + ' . $subname,1);
            
        //$address = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div p.geo strong')->text();
               
        //$address = str_replace("\n", ', ', trim($address));
        $address = $locationData['address'] . ',' . $locationData['city'] . ',' . $locationData['province'] . ',' . $locationData['postalCode'];
       
        $locationUrl = $locationData['address'];
        
        // Phone
        $phone = $locationData['url'];
        
        $geoLat = $locationData['latitude']; $geoLng = $locationData['longitude'];
       
        
        $this->out($address,1);
        $this->out($phone,1);
        $this->out( $geoLat . ' , ' . $geoLng,1);
        
        // Hours
        $hoursBlock = pq('div.containerStoreAddress div.Hours' )->text();
        
        $hoursBlock = str_ireplace( array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ), ',', $hoursBlock );
        
        $hoursBlock = str_replace( array('to', 'friday', 'saturday' ), '-', $hoursBlock );
        
        $hoursBlock = explode( ',', $hoursBlock );
        
        // sunday, mon-fri, saturday
        $hours[0] = $hoursBlock[1];
        $hours[1] = $hoursBlock[2];
        $hours[2] = $hoursBlock[3];
        $hours[3] = $hoursBlock[4];
        $hours[4] = $hoursBlock[5];
        $hours[5] = $hoursBlock[6];
        $hours[6] = $hoursBlock[7];
        
        
        $this->out( print_r($hours));
        
        $services = pq('.StoreFeatureText')->text();
        
        $services = explode( "\n", $services);
        
        debug( $services );
        exit;
        // services 
        $services = pq('div#container.promoghp div#header div#lsp-container div#lsp-wrap div.vcard div#store_header div#store_information div.column div.store_services ul')->html();
        
        $services = strip_tags($services, 'li');
        
        $services = explode("\n", trim($services) );
        
        //$this->out( print_r($services));
        
    }
}
?>
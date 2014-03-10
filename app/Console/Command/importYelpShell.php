<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');
App::uses('Hash', 'Utility');
App::uses('File', 'Utility');
App::uses('Sanitize', 'Utility');


App::import('Vendor', 'phpQuery/phpQuery');

App::uses('String', 'Utility');

class ImportYelpShell extends Shell {

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
           
'http://www.yelp.ca/biz/leighs-favorite-books-sunnyvale',
'http://www.yelp.ca/biz/recycle-bookstore-west-campbell',
'http://www.yelp.ca/biz/spartan-bookstore-san-jose',
'http://www.yelp.ca/biz/kinokuniya-book-store-san-jose',
'http://www.yelp.ca/biz/village-house-of-books-los-gatos',
'http://www.yelp.ca/biz/recycle-book-store-san-jose',
'http://www.yelp.ca/biz/east-west-bookstore-mountain-view-2',
'http://www.yelp.ca/biz/keplers-books-menlo-park'


        );
        
       //$urls = array( 'http://www.yelp.ca/biz/sorensen-books-victoria' );

        
       
        // uncomment this part to scan those Urls
      
        foreach($urls as $url) {
            $this->scrapPageBlocks($url); 



            $json = array(
                'venues' => $this->venuesData,
                'features' => $this->venueFeatures,
              //  'chain_id' => 0,
              //  'business_type' => array(4,1), // used books, bookstore
            );

            file_put_contents('output.json', json_encode($json, JSON_PRETTY_PRINT) );
           
            //$this->scrapePageInfo($url);
        
        }
        //debug('done');
   
        exit;
       
        // this part extracts valid urls
        // *** Not built yet - going to manually add urls to start ***
        
        $this->out( array('Welcome. This will find pages with venue on them', 'enter the start end numbers' ) );
        $startAt =  intval( $this->in( 'Start at number:',null,10 ) );
        $endAt =    intval($this->in( 'Finish at number:',null,15 ) );
        
        $url = 'http://www.hpb.com/';
        
        $storeFinderUrl = $this->in('Store finder URL:', null, $url);
        
        $outputFile = $this->in('Output file:', null, 'stores_found.txt');
        
        $this->out('counting from ' . $startAt . ' to ' .  $endAt, 1 );
        
        $urls = $this->getCandidatePageUrls( $startAt, $endAt, $outputFile, $storeFinderUrl );
        
        
    }
   
   /*
   ** This function checks if page has title and is candidate for scanning
   */
    function getCandidatePageUrls( $startAt, $endAt, $outputFile, $storeFinderUrl ) {
        $goodUrls = array();
       
        for( $i= $startAt; $i <= $endAt; $i++ ) {

            $i = sprintf("%03d", $i ); // convert to padded number (3 zeros) format
            $storePageUrl = $storeFinderUrl . $i . '.html';
            $this->out('processing: ' . $storePageUrl, 1);
            $doc = phpQuery::newDocumentHTML($storePageUrl);
            
            if (!$doc) {
                $this->out('ERROR loading ' . $storePageUrl );
            } else {
                phpQuery::newDocumentFileHTML($storePageUrl);
                $titleElement = pq('div#mainContent h1 strong')->html(); // in jQuery, this would return a jQuery object.  I'm guessing something similar is happening here with pq.
                
                if ($titleElement) {
                    $this->out($titleElement, 1);
                    $goodUrls[] = $storePageUrl;
                }
            }

            // also try 2nd format: "http://www.hpb.com/106/"
            $storePageUrl = $storeFinderUrl . $i . '/';
            $this->out('processing: ' . $storePageUrl, 1);
            $doc = phpQuery::newDocumentHTML($storePageUrl);
            
            if (!$doc) {
                $this->out('ERROR loading ' . $storePageUrl );
            } else {
                phpQuery::newDocumentFileHTML($storePageUrl);
                $titleElement = pq('div#mainContent h1 strong')->html(); // in jQuery, this would return a jQuery object.  I'm guessing something similar is happening here with pq.
                
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
   

    // get the main blocks with content (used when more than one venue on a page)
    function scrapPageBlocks($url) {
        $venueData = array();
        $venueNotes = array();
        
        $venueFeatures = array(); 
        //$venueFeatures[] = "gift_cards"; // pre-fill any common store features here 

        $this->out('processing page: ' . $url, 1);




        phpQuery::newDocumentFileHTML($url); 

        $venueNotes[] = array('sourceUrl' => $url );
// -- temp to skip bunch of stuff
        //$titleElement = pq('title')->text();
       // $titleElement = pq('')->html(); // in jQuery, this would return a jQuery object.  I'm guessing something similar is happening here with pq.

        //<meta property="og:title" content="Myopic Books">
        $titleElement = trim(pq('meta[property="og:title"]')->attr('content'));

        $venueData = array(); // store data for this venue here 

        $venueData['chain_id'] = 0; // none
        $venueData['business_type'] = array(4,1); // used books, bookstore
                   
        $venueData['name'] = $titleElement;
        $venueData['sub_name'] = '';
       
        //  <meta property="place:location:longitude" content="-123.120665">
        //  <meta property="place:location:latitude" content="49.2817516">
        $venueData['geo_latt'] = trim(pq('meta[property="place:location:latitude"]')->attr('content'));
        $venueData['geo_long'] = trim(pq('meta[property="place:location:longitude"]')->attr('content'));
        
             
        // address
        // <span itemprop="streetAddress">
        $address = pq('span[itemprop="streetAddress"]')->text();
        $city = pq('span[itemprop="addressLocality"]')->text(); // use these next 2 fields to isolate full name in <title>? 
        $province = pq('span[itemprop="addressRegion"]')->text(); 
        $postalCode = pq('span[itemprop="postalCode"]')->text(); 
        $venueData['address'] = "{$address}, {$city}, {$province}, {$postalCode} "; // country?
        

        // <span class="biz-phone" itemprop="telephone">
        // <span id="bizPhone" itemprop="telephone">(773) 862-4882</span>
       // $phone = pq('span.biz-phone [itemprop="telephone"]')->text();
       // if (empty($phone) )
        $phone = trim(pq('span[itemprop="telephone"]')->text());

        $phone = trim( str_replace( array( '(', ')' ), '', $phone ) );
        $phone = trim( str_replace( array('-', ' ') , '.', $phone ) );

        $venueData['phone'] = $phone; // trim(str_replace( array('(', '-', ')', ' ' ), array('.', '.', '.', '' ) , $phone ) ); 

        $venueData['tracking_num'] =  trim(str_replace('.', '', $venueData['phone'] ) );       


        // venue history / description
        $aboutHistory = pq("div.section > h4:contains('History') + div.inner p")->text();
        if (!empty($aboutHistory)) $aboutHistory = '<p>' . $aboutHistory . '</p>' . "\n";

        $about = pq("div.section > h4:contains('Specialties') + div.inner p")->text();
        if (!empty($about)) $about = '<p>' . $about . '</p>' . "\n";

        $venueData['description'] = trim("{$about} {$aboutHistory}");

        // put in title bit
        $venueData['description'] = "<p><strong>{$venueData['name']}</strong> is located at {$address}., {$city}, {$province}</p>\n\n" . $venueData['description'];

        $venueData['features_text'] = $venueData['description'];


        // website
        $websiteTemp = pq('div.biz-website > a')->attr('href');
        $websiteTemp = rawurldecode($websiteTemp);
        preg_match_all('/^\/biz_redir\?url=([^?&]{4,50}).*$/i', $websiteTemp ,$matches);

        if ( isset($matches[1][0]) && !empty($matches[1][0]))
            $website = $matches[1][0];
        else
            $website = '';

        $venueData['website'] = $website;

// --- End of temp skip */

        // hours? <table hours-table
        $hoursTable = pq('table.hours-table')->text();
        if (!empty($hoursTable)) {
            //debug( $hoursTable); exit;

            $venueData['notes']['hours'] = 'Hours:' . preg_replace( '/\s+/', ' ', $hoursTable ); // regex removes extra spaces
            $venueData['notes']['yelp_url'] = "Yelp url: {$url}";

            $days = pq('table.hours-table th')->text();
           // debug($days);
            $hours = pq("table.hours-table td:not('.extra')")->text();
            //debug($hours);



            // hours
            $hoursArray = explode("\n", $hours);
            foreach ($hoursArray as $i => $text) {
                $text = trim($text);
                if ( empty($text) ) unset($hoursArray[$i]);
                else $hoursArray[$i] = $text;    
            }
            $hoursArray = array_values($hoursArray);
        //   debug($hoursArray); 

            // days
            $daysArray = explode("\n", $days);
            foreach ($daysArray as $i => $text) {
                $text = trim($text);
                if ( empty($text) ) unset($daysArray[$i]);
                else $daysArray[$i] = $text;    
            }
            $daysArray = array_values($daysArray);
        //   debug($daysArray);         

            $hours = array_combine($daysArray, $hoursArray);

            $venueHours = $this->processStoreHours($hours);

            $venueData['hours'] = $venueHours;
        } else { // check other location


        }

      //  debug($hours);  

/*
Alt hours format:

<dd class="attr-BusinessHours"><p class="hours">Mon-Thu 10:30 am - 10 pm</p>
            <p class="hours">Fri 10:30 am - 11 pm</p>
            <p class="hours">Sat 10 am - 11 pm</p>
            <p class="hours">Sun 12 pm - 7 pm</p></dd>

*/


        //debug($venueData); exit;
/*
        $block1 = pq('div#storeAddress')->text();
        $addressPlacement = 1;

        if ( empty($block1) ) {
            $block1 = pq('div#storeInfo')->text(); 
            $addressPlacement = 2;
        }

        //debug($block1); //exit;

*/

        //debug($awardsText); exit;


       // debug($block1);
/*
        $addressBlock = explode("\n", $block1);

        foreach ($addressBlock as $i => $line) {
            $addressBlock[$i] = trim($line);
            if ( empty($addressBlock[$i])) unset( $addressBlock[$i] );
        }

        $cleanAddress = array_values($addressBlock);

       //debug($cleanAddress); //exit;

        $subName = $cleanAddress[0];

        $address = $cleanAddress[1] . ', ' . $cleanAddress[2];

        if ( $addressPlacement == 2) {
            $address = $cleanAddress[0] . ', ' . $cleanAddress[1];
        }

        $directions = '';
        if ( isset($cleanAddress[3]) ) {
            $directions = array_slice ( $cleanAddress , 3);
            $directions = $cleanAddress[3];
            
        }


*/
        


/*
         debug($subName);
        debug($address);
        debug( $directions);
*/

        // hours and phone
       /*  $block1 = pq('div#storeHours')->html();
         $hoursBlock = preg_split("/(<br>)|(\n)/i", $block1);


        foreach ($hoursBlock as $i => $line) {
            $hoursBlock[$i] = trim($line);
            if ( empty($hoursBlock[$i])) unset( $hoursBlock[$i] );
        }
        $cleanHours = array_values($hoursBlock);

//debug($cleanHours); exit;


        $phone = $cleanHours[ sizeof($cleanHours) - 1 ];

        if ( $addressPlacement == 2) {
            $phone = $cleanAddress[2];
        }

        $matches=preg_split('/[<^]{1,100}/i',$phone);
        if ( isset($matches[0]) ) 
            $phone = $matches[0]; 
        else 
            $phone = '000.000.0000';

        unset( $cleanHours[ sizeof($cleanHours) - 1 ] );
        unset( $cleanHours[ sizeof($cleanHours) - 1 ] );
        unset( $cleanHours[0] );
    //   debug($cleanHours);

        // pull out hours
        $hoursTemp = array();
       // debug($cleanHours);
        foreach( $cleanHours as $i => $row) { //debug($row);
            preg_match_all('/<span[^>]{1,100}>([^<]{1,100})<\/span>([^<]{1,100})/i',$row,$matches);
            if (sizeof($matches) == 3 ) {
                if ( empty( $matches[1][0]) )
                    continue;

                $hoursTemp[ trim(strtolower($matches[1][0])) ] = $this->formatStoreHours( trim( strtolower($matches[2][0] ) ) );                
            }
        }

         if ( $addressPlacement == 2) {
            $hoursBlock = array();


            $hoursTemp[ strtolower(  $cleanAddress[5] ) ] = $this->formatStoreHours( trim( strtolower($cleanAddress[6])));   
            $hoursTemp[ strtolower( $cleanAddress[7] ) ] = $this->formatStoreHours( trim( strtolower($cleanAddress[8]))); 

            // check for Sunday
            if (isset($cleanAddress[9])) { 
                $hoursTemp[ strtolower( $cleanAddress[9] ) ] = $this->formatStoreHours( trim( strtolower($cleanAddress[10])));     
            }  
         }

       debug($hoursTemp);



        // debug($hoursTemp); -> store these in notes?

        //$venueNotes[] = array('hours' => $hoursTemp );
        */
       // $venueData['notes'][] = array('Hours:' => str_replace( array('{', '}', '"'), ' ', json_encode( $hoursTemp) ) );
/*

        $venueHours = $this->processStoreHours($hoursTemp);
     //debug($venueHours);exit;
     */

/*
        // awards 
        $awardsText = trim(pq('div#awardsInfo')->text() );
        $awardsText = preg_replace( '/\s+/', ' ', $awardsText );
        if (!empty($awardsText)) $venueFeatures[] = 'award_winning';

        if ( !empty($awardsText) ) {
            $venueData['notes'][] = array( 'awards' => $awardsText);
        }      

        // events
        $eventsText = trim(pq('div#storeEvents')->text() );
        $eventsText = preg_replace( '/\s+/', ' ', $eventsText );

        if ( stripos($eventsText, 'storytime')) {
            $venueFeatures[] = 'childrens_events';    
        }

        if ( stripos($eventsText, 'book club')) { 
            $venueFeatures[] = 'book_club';
        }

        if ( stripos($eventsText, 'Book Signing')) { 
            $venueFeatures[] = 'author_events';
        }

        if ( stripos($eventsText, 'Half Pint')) { 
            $venueFeatures[] = 'kids_section';
        }        

       
*/
        
        
/*

      $venueData['website'] = $url;

      $venueData['phone'] = trim(str_replace( array('(', '-', ')' ), '.', $phone ) ); 

     // $venueData['notes'] = $venueNotes; //$this->implode_r("\n", $venueNotes );
      $venueData['tracking_num'] =  trim(str_replace('.', '', $venueData['phone'] ) );  

      $venueData['hours'] = $venueHours;
      $venueData['address'] = $address;

      $venueData['features_text'] = $directions;

      $venueData['features'] = $venueFeatures;

      $venueData['chain_id'] = 10; // Half-priced books

      $venueData['business_type'] = array(4,1); // used books, bookstore

      //debug( json_encode($venueData,  JSON_PRETTY_PRINT) );  
*/

    // merge-in any new features into master list
    if ( isset($venueData['features'])) { 
        $this->venueFeatures = array_unique( array_merge( (array)$this->venueFeatures, $venueData['features'] ) );          
    }
    $temp = '';
    
    if ( isset($venueData['notes']) && is_array($venueData['notes'])){
       /* foreach( $venueData['notes'] as $field => $data ) {
            $temp .= ucfirst($field) . ": $data \n";    
        }*/

        $venueData['notes'] = $this->implode_r( "\n", $venueData['notes']);
    }

    //$venueData['notes'] = ' none';
    

    $venueData['tracking_num'] =  trim(str_replace('.', '', $venueData['phone'] ) );

   // debug( $venueData) ; exit;
    // if good, transfer to global $venuesData

    $this->venuesData[] = $venueData;

   // debug( json_encode($venueData,  JSON_PRETTY_PRINT) );

        /*

        foreach(pq('.storeDetails') as $i => $storeDetail) {

            $venueData = array(); // store data for this venue here 
            
            //debug($text);
            
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


        }  */


    }

    /*
    * e.g. turn "9 am - 12:30pm" -> "9:00am - 12:30pm"
    */
    function formatStoreHours($timeStr) {
        // first explode on '-'

        // first check if has word "closed", if so, just return that 
        if ( strpos($timeStr, 'closed'))
            return( ucwords($timeStr));

        $timeRange = explode('-', $timeStr );

        if ( sizeof($timeRange) == 2 ) {

            $timeStamp = strtotime($timeRange[0]);
            $newFormat = date('g:ia', $timeStamp);

            $newFormat .= ' - ';

            $timeStamp = strtotime($timeRange[1]);
            $newFormat .= date('g:ia', $timeStamp);

        } else {
            $timeStamp = strtotime($timeStr);
            $newFormat = date('g:ia', $timeStamp);
        }
       // debug($newFormat);
        return($newFormat);
    }

    function processStoreHours( $hours) {
        $weekArray = array();
        foreach( $hours as $dayRange => $hours) {

            $hours = $this->formatStoreHours( trim( strtolower($hours) ) ); // put into 10:00am - 9:30pm

            // should remove spaces, non-letter chars. from $dayRange?
            $dayRange = strtolower($dayRange);
            switch ( $dayRange) {
                case 'sunday':
                    $weekArray['sun'] = $hours;
                    break;
                case 'monday-thursday':
                case 'monday - thursday':
                    $weekArray['mon'] = $hours;
                    $weekArray['tue'] = $hours;
                    $weekArray['wed'] = $hours;
                    $weekArray['thu'] = $hours;
                    break;
                case 'friday-saturday':
                case 'friday - saturday':
                    $weekArray['fri'] = $hours;
                    $weekArray['sat'] = $hours; 
                    break; 
                case 'monday-saturday':
                case 'monday - saturday':
                    $weekArray['mon'] = $hours;
                    $weekArray['tue'] = $hours;
                    $weekArray['wed'] = $hours;
                    $weekArray['thu'] = $hours;
                    $weekArray['fri'] = $hours;
                    $weekArray['sat'] = $hours;
                    break;
                case 'every day': 
                    $weekArray['mon'] = $hours;
                    $weekArray['tue'] = $hours;
                    $weekArray['wed'] = $hours;
                    $weekArray['thu'] = $hours;
                    $weekArray['fri'] = $hours;
                    $weekArray['sat'] = $hours;  
                    $weekArray['sun'] = $hours;              
                break;   

                case 'sunday-thursday': 
                    $weekArray['sun'] = $hours;
                    $weekArray['mon'] = $hours;
                    $weekArray['tue'] = $hours;
                    $weekArray['wed'] = $hours;
                    $weekArray['thu'] = $hours;                    
                break;  

                case 'mon':
                    $weekArray['mon'] = $hours;
                break;
                
                case 'tue':
                    $weekArray['tue'] = $hours;
                break;
                case 'wed':
                    $weekArray['wed'] = $hours;
                break;
                case 'thu':
                    $weekArray['thu'] = $hours;
                break;                
                case 'fri':
                    $weekArray['fri'] = $hours;
                break;
                case 'sat':
                    $weekArray['sat'] = $hours;
                break;
                case 'sun':
                    $weekArray['sun'] = $hours;
                break;                
            }

        }

        return($weekArray);
    }

    function implode_r($glue,$arr){
       $ret_str = "";
       $separator = "";
       foreach($arr as $a){
          $ret_str .= (is_array($a)) ? $this->implode_r($glue,$a) : $separator . strval($a);
          $separator = $glue ;
        }
      return $ret_str;
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
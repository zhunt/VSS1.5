<?php

/*
 * returns Google Adsense code
 *  updated to asynic adsense 25-jul-2013
 */

//App::uses('HtmlHelper', 'View/AdvertHelper');

class AdvertHelper extends Helper {
    public $helpers = array('Html');
    
    var $imageDir = '/images/ad-sizes';
    
    /*var $imageCodes = array(
            'mobile_landscape' => '185668_mobileleaderboard_text1_en.png',
            'landscape' => 'adsense_185665_adformat-text_728x90_en.png',
            'skyscraper' => 'adsense_185665_adformat-text_160x600_en.png',
            'box300' => 'adsense_185665_adformat-text_300x250_en.png' 
        );
    */
    
    var $imageCodes = array(
        'landscape' => '
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728x90, profile page top -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5569648086666006"
     data-ad-slot="3971646394"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        ',
        
        'landscape_mobile' => '
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ACD - banner - mobile -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-5569648086666006"
     data-ad-slot="9533641733"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>          
            ',

        'box300' => '
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 300x250, created 6/12/11 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-5569648086666006"
     data-ad-slot="1597207417"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        ',
        
        'box250' => '
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 250x250, created 8/31/09 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:250px;height:250px"
     data-ad-client="ca-pub-5569648086666006"
     data-ad-slot="2601764800"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>',

        'box336' => '
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ACD - large box -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-5569648086666006"
     data-ad-slot="8639722092"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        ',        
        
        'skyscraper' => '
       
            <script type="text/javascript"><!--
            google_ad_client = "pub-5569648086666006";
            /* 160x600, created 12/17/10 */
            google_ad_slot = "1613757235";
            google_ad_width = 160;
            google_ad_height = 600;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>            
       
            ',
        );
    
    function displayAd( $adType, $params = null ) {
        
        if ( isset( $this->imageCodes[$adType]) ) {
            
            if ($adType == 'landscape' && $this->request->is('Mobile') )
                $adType = 'landscape_mobile';
 
            if ($adType == 'box336' && $this->request->is('Mobile') )
                $adType = 'landscape_mobile';
            
            $output = $this->imageCodes[$adType];
			
			if ( !$this->request->is('Mobile') ) {
				$output = '<div class="right_adbox" style="text-align: center; color: #d0d0d0; border-bottom: 1px solid #dedede">' . $output . ' AdSense</div>';
			}
			
			$output = ''; // no ads for now
            return $this->output($output);
        }
        else {
            return $this->output( 'No ad code found for "' . $adType . '" ' );
        }
    }
    
}
?>

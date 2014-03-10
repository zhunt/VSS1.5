<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php echo $this->element('header'); ?>
<div class="container"> 
    <div class="row" >
        <div class="span8">
            <?php echo $this->element('city_breadcrumb') ?>
            
            
            <h1 style="margin-bottom: .25em">Newest <?php echo $cities['City']['name']?> Bookstores
            </h1>

            <ul class="thumbnails">
                
            <?php foreach($newVenues as $i => $row): ?>    
            <li class="span2">
                <h4>
                <?php echo $this->Html->link(
                        $this->Text->truncate( $row['Venue']['name'], 18),
                        array('controller' => false, 'action' => 'company', $row['Venue']['slug'] ),
                        array('title' => $row['Venue']['name'] . ' ' . $row['Venue']['sub_name'] )
                        ); ?>
                    <span style="font-size: smaller; display: block;"><?php echo $row['BusinessType1']['name'] ?></span>
                    
                </h4>
                <div class="thumbnail">
                    <img alt="" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $row['Venue']['geo_lat'] ?>,<?php echo $row['Venue']['geo_lng'] ?>&zoom=14&markers=label:A|<?php echo $row['Venue']['geo_lat'] ?>,<?php echo $row['Venue']['geo_lng'] ?>&size=260x180&sensor=false">
                <div class="caption">
                <h5><?php echo $row['City']['name'] ?>, <?php echo $row['Province']['name'] ?></h5>
                <p><?php echo $this->Text->truncate( $row['Venue']['seo_desc']) ?></p>
                
            </div>
            </div>
            </li>
            <?php endforeach; ?>
            </ul>
            <p style="margin-top: -20px"><a href="/search/city:<?php echo $cities['City']['slug']?>">See All</a></p>
            
        
            <?php if (!$this->request->is('Mobile') ) :?>  
                <div style="margin:20px 0 10px -5px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php else: ?>
                <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php endif; ?>
                
                
            <h2 class="frame" style="text-align: right; margin-bottom: .5em"><?php echo $cities['City']['name']?></h2>

            <?php if ( !empty($cityBusinessTypes)): ?>
            <h3>Business Types</h3>
            <div class="row">
                <?php foreach( $cityBusinessTypes as $slug => $name ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $name, 
                        '/search/business_category:' . $slug . '/city:' . $regions[0]['City']['slug'],
                        array('title' =>  $name . ' stores in ' . $regions[0]['City']['name'] )
                        ) 
                ?>
                </div>
                <?php endforeach; ?>                    
            </div>            
            <?php endif; ?>            
            
            <?php if ( !empty($cityChains)): ?>
            <h3>Stores Chains</h3>
            <div class="row">
                <?php foreach( $cityChains as $slug => $name ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $name, 
                        '/search/chain:' . $slug . '/city:' . $regions[0]['City']['slug'],
                        array('title' => $name . ' stores in ' . $regions[0]['City']['name'] )
                        ) 
                ?>
                </div>
                <?php endforeach; ?>                    
            </div>            
            <?php endif; ?>

            
            <h3 class="frame" style="text-align: right; margin-bottom: .5em">City Areas</h3>
            
            <?php if ( !empty($regions[0]['CityRegion'])): ?>
            <h3>Regions</h3>
            <div class="row">
                <?php foreach( $regions[0]['CityRegion'] as $i => $row ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $row['name'], 
                        '/search/city_region:' . $row['slug'],
                        array('title' => 'Bookstores stores in ' . $row['name'] . ', ' . $regions[0]['City']['name'] )
                        ) 
                ?>
                </div>
                <?php endforeach; ?>                    
            </div>            
            <?php endif; ?>
            
            <?php if ( !empty($regions[0]['CityNeighbourhood'])): ?>
            <h3>Neighbourhoods</h3>
            <div class="row">
                <?php foreach( $regions[0]['CityNeighbourhood'] as $i => $row ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $row['name'], 
                        '/search/city_neighbourhood:' . $row['slug'], 
                        array('title' => 'Bookstores in ' . $row['name'] . ', ' . $regions[0]['City']['name'] )
                        ) 
                ?>
                </div>
                <?php endforeach; ?>                    
            </div>  
            <?php endif; ?>
            
           
            
            <h3 class="frame" style="text-align: right; margin-bottom: .5em">Bookstore Services </h3>
            <h3>Classes</h3>
            <div class="row">
                <?php foreach( $products as $i => $row ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $row['name'], 
                        '/search/product:' . $row['slug'] . '/city:' . $regions[0]['City']['slug'] ,  
                        array('title' => 'Stores with ' . $row['name'] . ' in ' . $regions[0]['City']['name'] )
                        ); 
                        
                      echo ' (' . $row['count'] . ')';  
                ?> 
                </div>
                <?php endforeach; ?>                    
            </div> 
            
            <h3>Services</h3>
            <div class="row">
                <?php foreach( $services as $i => $row ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $row['name'], 
                        '/search/service:' . $row['slug'] . '/city:' . $regions[0]['City']['slug'] ,  
                        array('title' => 'Stores offering ' . $row['name'] . ' in ' . $regions[0]['City']['name'] )
                        ); 
                        
                      echo ' <small>(' . $row['count'] . ')</small> ';  
                ?> 
                </div>
                <?php endforeach; ?>                    
            </div>             
            
            <hr>
            
            
            
        </div>
        
        <div class="span4" id="right_col"> <!-- Right column --->
            <div class="row">
                <div class="span4 border_frame">
                <?php if (!$this->request->is('Mobile') ) :?>    
                    <div class="right_adbox"><?php echo $this->Advert->displayAd('box336'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>
            

           
                               
        </div>
    </div>
    
   
</div>

<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>
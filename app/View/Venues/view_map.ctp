<?php

/*
 * View a venue
 */

//debug($venue); exit; ?>

<!-- <?php echo $venue['Venue']['id'] ?> -->


<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <?php echo $this->element('venue_breadcrumb') ?>
            
            <h1><?php echo $venue['Venue']['name']; ?>
                <small> <?php echo $venue['Venue']['sub_name']; ?></small>
            </h1>    
            
            <?php echo $this->element('microformats'); ?>

            <div class="row">
                <div class="span5">
                    <h4 style="margin-bottom: .5em;"><?php echo trim( $venue['Venue']['address'] . ', ' . $venue['City']['name'] . ', ' .$venue['Venue']['postal_code']) ?></h4>
                </div>
                <div class="span3" style="text-align: right">
                    <a class="" href="http://maps.google.com/maps?q=<?php echo urlencode($venue['Venue']['address'] . ', ' . $venue['City']['name'] . ', ' . $venue['Province']['name'] . ',' . $venue['Venue']['postal_code'] ); ?>" target="_blank">View on Google Map</a>
                </div>
            </div>
            
            <div class="row">
                <div id="map_canvas" class="span8" style="height: 600px;"></div>
            </div>

            <div class="row">
                <div class="span8">
                <?php if (!$this->request->is('Mobile') ) :?>    
                    <div style="margin: 5px auto 18px; width: 728px; height: 90px; padding: 5px"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>
            

            
            <div class="row hidden-phone">
                <div class="span8 ">
                    
                    <h3 class="frame">Business Hours</h3>
                    <table class="table table-bordered">
                      
                        <thead>
                            <tr>
                            <th>Mon.</th>
                            <th>Tues.</th>
                            <th>Wed.</th>
                            <th>Thurs.</th>
                            <th>Fri.</th>
                            <th>Sat.</th>
                            <th>Sun.</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr id="business_hours">
                            <td><?php echo $venue['Venue']['hours_mon'] ?></td>
                            <td><?php echo $venue['Venue']['hours_tue'] ?></td>
                            <td><?php echo $venue['Venue']['hours_wed'] ?></td>
                            <td><?php echo $venue['Venue']['hours_thu'] ?></td>
                            <td><?php echo $venue['Venue']['hours_fri'] ?></td>
                            <td><?php echo $venue['Venue']['hours_sat'] ?></td>
                            <td><?php echo $venue['Venue']['hours_sun'] ?></td>
                            </tr>
                        </tbody>
                        <caption>Note: Hours may change during holidays.</caption>
                    </table>
                    
                </div>
            </div>
            
            <div class="row">
                <div class="span8">
                    <h3 class="frame">Comments</h3>
                    <div class="fb-comments" data-href="http://www.yyztech.ca/company/<?php echo $venue['Venue']['slug'] ?>" data-num-posts="4" data-width="767"></div>
                </div>
            </div>
              
            
        </div>
        
        <div class="span4" id="right_col"> <!-- Side Column -->
            <div class="row">
                <div class="span4 border_frame">
                <?php if (!$this->request->is('Mobile') ) :?>    
                    <div class="right_adbox"><?php echo $this->Advert->displayAd('box336'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>                    
                    
           
        
            <div class="row hidden-desktop hidden-tablet">
                <div class="span4 ">
                    <h3 class="frame invert">Contact</h3>
                    <div class="well" style="text-align: center">
                        <h3>Address</h3>
                            <small>
                            <?php echo trim( $venue['Venue']['address'] . ', ' . $venue['City']['name'] . ', ' .$venue['Venue']['postal_code']) ?>
                            </small>
                   <?php 
                   if (!empty($venue['Venue']['phone_1'])){
                       echo '<h3>Phone</h3>';
                       echo '<small>' . $venue['Venue']['phone_1'] . '</small>';
                       //echo '</h3>';
                   }
                   if (!empty($venue['Venue']['phone_2'])){
                       echo '<h3>' . $venue['Venue']['phone_2_desc'] . '</h3>';
                       echo '<small>' . $venue['Venue']['phone_2'] . '</small>';
                       //echo '</h3>';
                      
                   }
                   if (!empty($venue['Venue']['website_url'])){
                       if ( strpos($venue['Venue']['website_url'], 'http://') === false )
                            $venue['Venue']['website_url'] = 'http://' . $venue['Venue']['website_url'];
                       
                       echo '<h3>Website</h3>';
                       echo '<small>' . $this->Html->link( 
                               $this->Text->truncate($venue['Venue']['website_url']), 
                               $venue['Venue']['website_url'], array('target' => '_blank') ). '</small>';
                       //echo '</h3>';
                   }                   
                   ?>
                   </div>
                </div>
            </div>
            
            <!-- -->
            
            <div class="row hidden-phone">
                <div class="span4 ">
                    
                        <h3 class="frame invert">Contact</h3>
                        <div class="row">
                            
                           <div class="span2">
                           <h4>Address</h4>
                            <small>
                            <?php echo trim( $venue['Venue']['address'] . ', ' . $venue['City']['name']) ?>
                            </small> 
                            <?php if (!empty($venue['Venue']['website_url'])){
                                echo '<h4>Website</h4>';
                                echo '<small>' . $this->Html->link( 
                               $this->Text->truncate($venue['Venue']['website_url'], 25), 
                                        $venue['Venue']['website_url'], 
                                        array(  'target' => '_blank', 
                                                'title' => 'Link to ' . htmlentities($venue['Venue']['website_url']) ) 
                                        ) . '</small>';
                            }  
                            ?>
                            </div> <!-- end of col 1-->
                            
                            <div class="span2">
                            <?php 
                            if (!empty($venue['Venue']['phone_1'])){
                                echo '<h4>Phone</h4>';
                                echo '<small>' . $venue['Venue']['phone_1'] . '</small>';
                            }
                            if (!empty($venue['Venue']['phone_2'])){
                                echo '<h4>' . $venue['Venue']['phone_2_desc'] . '</h4>';
                                echo '<small>' . $venue['Venue']['phone_2'] . '</small>';
                            }
                            ?>                               
                            </div> <!-- end of col 2-->
                            
                        </div>
                   
                </div>
            </div>  
            
            <!-- Hours for phone -->
            <div class="row hidden-desktop hidden-tablet">
                <div class="span4">
                        <h3 class="frame invert">Business Hours</h3>
                       <table class="table table-striped table-bordered table-condensed">
                            <tr><td>Mon.</td><td><?php echo $venue['Venue']['hours_mon'] ?></td></tr>
                            <tr><td>Tue.</td><td><?php echo $venue['Venue']['hours_tue'] ?></td></tr>
                            <tr><td>Wed.</td><td><?php echo $venue['Venue']['hours_wed'] ?></td></tr>
                            <tr><td>Thu.</td><td><?php echo $venue['Venue']['hours_thu'] ?></td></tr>
                            <tr><td>Fri.</td><td><?php echo $venue['Venue']['hours_fri'] ?></td></tr>
                            <tr><td>Sat.</td><td><?php echo $venue['Venue']['hours_sat'] ?></td></tr>
                            <tr><td>Sun.</td><td><?php echo $venue['Venue']['hours_sun'] ?></td></tr>
                            <caption>Note: Hours may change during holidays.</caption>
                        </table>
                        
                </div>
            </div>
            
            <!-- Nearby venues -->
            <div class="row">
                <div class="span4">
                    <h3 class="frame invert">Nearby Stores</h3>
                    <table class="table table-condensed table-bordered">
                       
                       
                        <?php foreach ($venuesNearby as $row):?>
                        <tr>
                            <td><h4><?php echo $this->Html->link(
                                        $this->Text->truncate( $row['Venue']['name'], 18),
                                        array('controller' => false, 'action' => 'company', $row['Venue']['slug'] ),
                                        array('title' => $row['Venue']['name'] . ' ' . $row['Venue']['sub_name'] )
                                        );?>
                                </h4> 
                                
                            <?php echo $row['Venue']['address'] ?>
                                
                            <br><em><?php echo $row['BusinessType1']['name'] ?></em> 
                            </td><td><?php echo $row['Venue']['distance'] ?></td>
                        </tr>
                        <?php endforeach; ?>                       
                    </table>
                </div>
                   
            </div>
            
            
        <!-- -->
        </div>
    </div>
    
    <?php if ($this->request->is('Mobile') ): ?>    
    <div class="row">
        <div class="span8">
            <h3 class="frame">Comments</h3>
            <div class="fb-comments" data-href="http://www.bookstorescanada.com/company/<?php echo $venue['Venue']['slug'] ?>" data-num-posts="4" data-width="480"></div>
        </div>
    </div>
    <?php endif; ?> 

</div>


<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>


<?php $this->Html->scriptBlockStart( array('inline' => false)); ?>
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script>
      function initialize() {
        var mapOptions = {
          scaleControl: true,
          center: new google.maps.LatLng(<?php echo $venue['Venue']['geo_lat'] . ',' .  $venue['Venue']['geo_lng'] ?>),
          zoom: 13,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById('map_canvas'),
            mapOptions);

        var marker = new google.maps.Marker({
          map: map,
          position: map.getCenter()
        });
        var infowindow = new google.maps.InfoWindow();
        infowindow.setContent("<?php echo $venue['Venue']['name'] ?>");
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

<?php $this->Html->scriptBlockEnd(); ?>
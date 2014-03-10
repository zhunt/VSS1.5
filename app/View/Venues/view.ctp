<?php

/*
 * View a venue
 */

//debug($venue); exit; ?>

<!-- <?php echo $venue['Venue']['id'] ?> -->

<style type="text/css">
    #map { 
        background: transparent url('http://maps.google.com/maps/api/staticmap?center=<?php echo $geoCords ?>&zoom=15&markers=<?php echo $geoCords ?>&size=770x250&sensor=false&scale=2' ) 50% no-repeat;
        height: 250px;
        /* width: 100%; */
        margin: 0;
        padding: 0;
       }
       
     a.pad { padding-right: .5em;}
     
     .bottom_border { border: 1px solid #aaa }
     
     #business_hours td { width: 14%; }
     
     a.round-box {
     background-color: #EFF5FF;
margin-right: .5em;
border-radius: 5px;
padding: .125em .5em;
     }
</style>


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
                    
                    <a class="hidden-desktop hidden-tablet" href="http://maps.google.com/maps?q=<?php echo urlencode($venue['Venue']['address'] . ', ' . $venue['City']['name'] . ', ' . $venue['Province']['name'] . ',' . $venue['Venue']['postal_code'] ); ?>" target="_blank">View on Google Map</a>
                    
                    <a class="hidden-phone" href="/company/view_map/<?php echo urlencode($venue['Venue']['slug']) ?>">Large Map</a>
                    
                </div>
            </div>

           <?php echo $this->element('venue_image'); ?>
           
            <div class="row">
                <div class="span8">
                <?php if (!$this->request->is('Mobile') ) :?>    
                    <div style="margin: 5px auto 18px; width: 728px; height: 90px; padding: 5px"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>
            
            <div class="row">
                <div class="span4">
                    <h3>About <?php echo $venue['Venue']['name']; ?></h3>
                    
                        <?php if (!empty($storetypes)) :?>    
                        <h4>Store Type</h4>
                        <?php foreach( $storetypes as $slug => $name ) {
                            echo $this->Html->link( 
                                $name, 
                                '/search/store_type:' . $slug . '/city:' . $venue['City']['slug'] ,  
                                array('title' => $name . ' in ' . $venue['City']['name'], 'class' => 'pad' )
                                ); 
                        }
                        endif;
                        ?>
                       <!-- show main categories too -->
                        <?php if (!empty($storeCategories)) :?>
                        <?php foreach ($storeCategories as $storeCategory ) {
                            echo '<strong>' . $this->Html->link( 
                                $storeCategory['name'], 
                                '/search/business_category:' . $storeCategory['slug'] . '/city:' . $venue['City']['slug'] ,  
                                array('title' => $storeCategory['name'] . ' in ' . $venue['City']['name'], 'class' => 'pad' )
                                ) . '</strong>'; 
                        }
                        endif;
                        ?>                    
                    
                    <?php echo $venue['Venue']['description']; ?>
                    
                    <?php if (empty($venue['Venue']['last_verified']))
                            $venue['Venue']['last_verified'] = $venue['Venue']['created'];
                    ?>
                    
                    <p><em>Listing last verified: <?php echo date( 'd-M-Y', strtotime( $venue['Venue']['last_verified'] ) ); ?></em></p>
                    
                    <?php if ( !empty($venue['Venue']['chain_id'])) {
                        echo '<p>';
                        echo $this->Html->link( 
                            'See more ' . $venue['Chain']['name'] . ' locations in ' . $venue['City']['name'] , 
                            '/search/chain:' . $venue['Chain']['slug'] . '/city:' . $venue['City']['slug'],  
                            array('title' => 'More ' . $venue['Chain']['name'] . ' locations in ' . $venue['City']['name'], 'class' => '' )
                            );  
                        echo '</p>';
                    }
                    ?>  
                      
                       <p>
                           <b><a class="btn btn-info" href="http://yyztech.wufoo.com/forms/z7x3p9/def/Field103=<?php echo urlencode($venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name']) . ' (' . Configure::read('Website.url') . ')' ?>&Field105=<?php echo $venue['Venue']['slug'] ?>" onclick="window.open(this.href,  null, 'height=658, width=680, toolbar=0, location=0, status=1, scrollbars=1, resizable=1'); return false">Report an Error</a></b>
                       </p>
                       
                            
               
                                     
                </div>
                
                <div class="span4">
                    
                     
                    
                    <?php if (!empty($products)): ?>
                    <h4>Products</h4>
                    <?php foreach( $products as $slug => $name ) {
                        echo $this->Html->link( 
                            $name, 
                            '/search/product:' . $slug . '/city:' . $venue['City']['slug'],  
                            array('title' => 'Stores with ' . $name . ' in ' . $venue['City']['name'], 'class' => 'pad round-box' )
                            ); 
                    }
                    endif;
                    ?>
                    
                    <?php if (!empty($services)) :?>
                    <h4 style="margin-top: 1em;">Services</h4>
                    <?php foreach( $services as $slug => $name ) {
                        echo $this->Html->link( 
                            $name, 
                            '/search/service:' . $slug . '/city:' . $venue['City']['slug'],  
                            array('title' => 'Stores offering ' . $name . ' in ' . $venue['City']['name'], 'class' => 'pad round-box', )
                            );   
                    }
                    endif;
                    ?>

                    <?php if (!empty($amenities)) :?>
                    <h4 style="margin-top: 1em;">Amenities</h4>
                    <?php foreach( $amenities as $slug => $name ) {
                        echo $this->Html->link( 
                            $name, 
                            '/search/service:' . $slug . '/city:' . $venue['City']['slug'],  
                            array('title' => 'Stores offering ' . $name . ' in ' . $venue['City']['name'], 'class' => 'pad round-box' )
                            );   
                    }
                    endif;
                    ?>
                     

                    <hr>           
                     <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a>
                    <a class="addthis_button_pinterest_pinit"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <!-- AddThis Button END -->
					
					<!--
					<div class="row">
						<div class="span4" style="">
							<div style="margin-right: 0px; display: inline-block; margin-left: -35px">
								CONTENT
							</div>
							<div style="display: inline-block;">
								CONTENT
							</div>
						</div>
					</div>
                    -->

                    
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
                    <div class="fb-comments" data-href="<?php echo Configure::read('Website.url') ?>/company/<?php echo $venue['Venue']['slug'] ?>" data-num-posts="4" data-width="767"></div>
                </div>
            </div>
              
            
        </div>
        
        <div class="span4" id="right_col"> <!-- Side Column -->
            
            
                   
                    
           
        
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
                <div class="span4" style="margin-bottom: 20px" >
                    
                        <h3 class="frame invert" style="margin-top: 0">Contact</h3>
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
            
            
            <div class="row">
                <div class="span4 border_frame">
                <?php if (!$this->request->is('Mobile') ) :?>    
                    <div class="right_adbox"><?php echo $this->Advert->displayAd('box336'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
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
            <div class="fb-comments" data-href="<?php echo Configure::read('Website.url') ?>/company/<?php echo $venue['Venue']['slug'] ?>" data-num-posts="4" data-width="480"></div>
        </div>
    </div>
    <?php endif; ?> 

</div>


<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>
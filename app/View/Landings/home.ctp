<?php
/*
 * Main home page
 */
?>

<style type="text/css">
    .date-block { float: right; display: block; font-size: smaller;}
    
</style>

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h2 style="margin-bottom: .25em">Newest Bookstores</h2>

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
        
            <?php if (!$this->request->is('Mobile') ) :?>
                <div style="margin:10px 0 10px -5px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php else: ?>
                <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php endif; ?>
            

            <hr/>
            <h2 class="frame" style="text-align: right; margin-bottom: .5em">Top Cities</h2>
            <div class="row" style="margin-bottom: 2em">
                <?php foreach( $cities as $i => $row ) :?>
                <div class="span2">
                <?php echo $this->Html->link( 
                        $row['City']['name'], 
                        '/city/' . $row['City']['slug'], // 'controller' => 'cities', 'action' => 'index', $row['City']['slug'] ),
                        array('title' => 'Computer stores in ' . $row['City']['name'] )
                        ) 
                ?>
                </div>
                <?php endforeach; ?>                    
            </div>            
            
        </div>
 
        <div class="span4" id="right_col"> <!-- Right column --->

            <!--
			<div class="row">
				<div class="span4 border_frame">
					<div style="margin:5px auto 0; width: 300px; height: 250px; padding: 0">
					 CONTENT BLOCK
					</div>
				</div>
			</div>
            -->
		
            <div class="row">
                <div class="span4 border_frame">
                <?php if (!$this->request->is('Mobile') ) :?>    
					<div class="right_adbox"><?php echo $this->Advert->displayAd('box336'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>


            <div class="row">
                <div class="span4">
                    <!--
                    <a class="twitter-timeline" width="360" height="500" data-dnt="true" href="https://twitter.com/GymratCanada"  data-widget-id="361587831912677376">Tweets by @GymratCanada</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    -->
                </div>
            </div>	
			
        </div>    

		

                               
        </div>
    </div>
   
</div>

<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>


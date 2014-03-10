<?php
/*
 * Province index page
 */
    
?>

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h1 class="frame" style="margin-bottom: .5em">Province of <?php echo $province['Province']['name'] ?></h1>

            <?php if (!$this->request->is('Mobile') ) :?>
                <div style="margin:10px 0 10px -5px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php else: ?>
                <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php endif; ?>
                
            <!-- -->
             <div class="row">
             <?php foreach ($cities as $i => $city): //debug($city);?>
           
                <div class="span2">
                   
                    <ul class="unstyled">
                       
                        <li>
                           <?php echo $this->Html->link( $city['City']['name'],
                                   '/city/' . $city['City']['slug'],
                                   array('title' => 'Stores in ' . $city['City']['name'] )) . ' (' . $city['City']['venue_count'] .')'; ?> 
                        </li>
                       
                    </ul>
                      
                </div>

            <?php endforeach; ?>
             </div>
            <!-- -->


                

         
            
            <!-- -->
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
   
</div>

<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>
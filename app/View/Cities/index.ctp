<?php
/*
 * City index page
 */
    
?>

<?php echo $this->element('header'); ?>

<?php

// break up city list into 4 columns

$count = sizeof($provinces);
//debug($count);

$counter = 0;
foreach ($provinces as $province) {
    if (!empty($province['City']))
        $counter++;
}

//debug($counter);

$count = $counter;

$perColumn = ceil( (float)$count/4.0 );
//debug($perColumn);

$column = array_chunk($provinces, $perColumn , true);

?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h1 class="frame" style="margin-bottom: .5em">Cities</h1>

            <?php if (!$this->request->is('Mobile') ) :?>
                <div style="margin:10px 0 10px -5px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php else: ?>
                <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php endif; ?>
                
            <!-- -->
             <div class="row">
                 
             <?php foreach ($column as $provinces): //feed in a column into province, then loop as normal ?>    
             
             <div class="span2">    
             <?php foreach ($provinces as $province): ?>
                 
                <?php if (!empty($province['City'])) :?> 
                
                    <h3><?php echo $province['Province']['name'] ?></h3>
                    <ul class="unstyled">
                        <?php foreach($province['City'] as $row):?>
                        <li>
                           <?php echo $this->Html->link( $row['name'],
                                   '/city/' . $row['slug'],
                                   array('title' => 'Stores in ' . $row['name'] )) . ' (' . $row['venue_count'] .')'; ?> 
                        </li>
                        <?php endforeach ?>
                    </ul>
               
                <?php endif; ?>

            <?php endforeach; ?>
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
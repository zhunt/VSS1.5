<?php
/*
 * City index page
 */
    
?>

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h1 class="frame" style="margin-bottom: .5em"><?php echo $displayType ?> By City and Province</h1>

            <!-- -->
             <div class="row">
             <?php foreach ($provinces as $province): ?>
           
                <div class="span3">
                    <h2><?php echo $province['Province']['name'] ?></h2>
                    <ul class="unstyled">
                        <?php foreach($province['City'] as $row):?>
                        <li>
                            <h4><?php echo $this->Html->link( $row['name'],
                                   '/city/' . $row['slug'],
                                   array('title' => 'Stores in ' . $row['name'] )); ?>
                            </h4>
                            
                            <ul>
                                <?php foreach( $row['features'] as $slug => $feature ): ?>
                                <li>
                                    <?php echo $this->Html->link( $feature[0],
                                   "/search/{$displayTypeSlug}:{$slug}/city:{$row['slug']}",
                                   array('title' => 'Stores with ' . $feature[0] . ' in ' . $row['name'] )) . " ({$feature[1]})"; ?>
                                </li>    
                                <?php endforeach; ?>
                                
                            </ul>
                        </li>
                        <?php endforeach ?>
                    </ul>
                      
                </div>

            <?php endforeach; ?>
             </div>
            <!-- -->

            <?php if (!$this->request->is('Mobile') ) :?>
                <div style="margin:10px 0 10px -5px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php else: ?>
                <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php endif; ?>
                

         
            
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
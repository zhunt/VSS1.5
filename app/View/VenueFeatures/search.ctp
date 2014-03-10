<?php
/*
 * Products index page
 */

// $this->Paginator->options(array('url' =>  $this->request->query));
    
?>

<style>
.paging {
    height: 36px;
    margin: 18px 0;
}
.paging span{
    float: left;
    padding: 0 14px;
    line-height: 34px;
    border-right: 1px solid;
    border-right-color: #DDD;
    border-right-color: rgba(0, 0, 0, 0.15);
    text-decoration: none;
    border: 1px solid rgba(0, 0, 0, 0.15);
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.paging span:hover, .paging span a:hover, .paging span.current {
    background-color: #C7EEFE;
    text-decoration:none;
}    
    
</style>
<?php debug($searchTerm) ?>
<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h1 class="frame" style="margin-bottom: .5em">Results for "<?php echo $searchTerm ?>"</h1>

            <!-- -->
            <?php foreach ($venues as $venue): ?>
            <div class="row">
                <div class="span5">
                    <h3><?php echo $this->Html->link( $venue['Venue']['name'] . ' <small>' . $venue['Venue']['sub_name'] . '</small>' ,
                                                        array('controller' => false, 'action' => 'company', $venue['Venue']['slug']),
                                                        array('title' => $venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name'], 'escape' => false )
                                                        ); ?></h3>
                    <h4><?php echo $venue['Venue']['address']; ?>, <?php echo $venue['City']['name']; ?> (<?php echo $venue['Intersection']['name'] ?>)</h4>
                        <?php echo $venue['Venue']['seo_desc'] ?>
                    
                </div>
               
                <div class="span3">
                    <h4><?php echo $venue['BusinessType1']['name']; ?>   
                    </h4>
                </div >               
                  
                
            </div>
            <div class="row">
                <div class="span8">
                    <hr>
                </div>
                
            </div>
            <?php endforeach; ?>
            <!-- -->

            <?php if (!$this->request->is('Mobile') ) :?>
                <div style="margin:10px 0 10px -5px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php else: ?>
                <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
            <?php endif; ?>
                

            <div class="paging" style="float: right">
            <?php
                    echo $this->Paginator->prev('< ' . __('previous'), array('controller' => 'product'), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => ''));
                    echo $this->Paginator->next(__('next') . ' >', array('controller' => 'product'), null, array('class' => 'next disabled'));
            ?>
            </div>
            
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
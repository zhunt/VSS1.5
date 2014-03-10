<?php

$post['Post']['post'] = $this->Shortcode->process( $post['Post']['post'], $post['Post']);

?>

<style type="text/css">
    
     h1#title {
       text-transform: uppercase;
       font-weight: 800;
    }

     
     p.caption { font-style: italic;
    font-weight: bold;
    line-height: 1.5em; 
     }
     
     .dek {
     font-weight: 600;  
    font-size: 1.3em;
    
    margin-top: 0.5em;   
    line-height: 1.4em;
    color: #336895; /*   #079948  #2E659A; */
    }

    div#content { font-family: 'PT Serif', serif; }



</style>

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            
            <?php echo $this->element('feed_breadcrumb') ?>
            
            <h1 id="title" style="line-height: 30px"><?php echo $post['Post']['name'] . '<br/><small>' . $post['Post']['sub_name']; ?></small></h1>
            
            <p class="dek"><?php echo $post['Post']['dek'] ?></p>
            
            <p><em>By: <?php echo $post['PostAuthor']['name'] ?></em></p>
            
            <div style="flaot: right">
                                 <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style" style="margin-bottom: 20px">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ec4565f5321d6a9"></script>
                    <!-- AddThis Button END -->   
             </div>       
                    
            
            <div id="content">
            <?php echo $post['Post']['post']; ?>
            </div>
            <p><em>Date published: <?php echo date('d-M-Y', strtotime($post['Post']['created']) ); ?></em></p>
            
            <?php // echo $this->Html->link($post['PostCategory']['name'], array('controller' => 'post_categories', 'action' => 'view', $post['PostCategory']['id'])); ?>
            
            
            
            
            <div class="row">
                <div class="span8">
                <?php if (!$this->request->is('Mobile') ): ?>    
                    <div style="margin: 5px auto 18px; width: 728px; height: 90px; padding: 5px"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>
            
           
            <?php if (isset($mapData) ): ?>
                <div class="row">
                <?php echo $this->element('post_map_block'); ?>
                </div>
            <?php endif; ?>
               
            <div class="row">
                <div class="span8">
                    <h3 class="frame">Comments</h3>
                    <div class="fb-comments" data-href="http://www.yyztech.ca/posts/<?php echo $post['Post']['slug'] ?>" data-num-posts="4" data-width="767"></div>
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
        
        <?php if ( !empty($post['Post']['venue_id']) ) :?>
        <div class="row">
            <?php echo $this->element('post_venue_block'); ?>
        </div>
        <?php endif;?>
        
        <div class="row">
            <?php echo $this->element('post_related_block'); ?>
        </div>        
        
        
    </div>

    </div>
<div>
        
<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>
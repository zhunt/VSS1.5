<?php
/*
 * Posts index page
 */
    $this->Shortcode->init();
    
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

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h1 class="frame" style="margin-bottom: .5em">Posts</h1>

            <!-- -->
             
             <?php foreach ($posts as $post): ?>
            <div class="row" style="margin-bottom: .5em; padding-bottom: 1em">
               
                <div class="span8" style="border-bottom: 1px solid #ccc;">
                   
                    <h2><a href="/posts/<?php echo $post['Post']['slug'] ?>"><?php echo $post['Post']['name'] ?> 
                     <?php if (!empty($post['Post']['sub_name'])) :?>
                        <small style="margin-top: -0.5em; display: block">
                        <?php echo $post['Post']['sub_name'] ?></small>
                     <?php endif;?>
                    </a></h2>
                    <div class="row" style="margin-top: .5em; margin-bottom:  .5em;">
                        <div class="span8">
                        <?php if (!empty($post['Post']['image_1'])):?>
                            <img src="/uploads/post/image_1/thumb/medium/<?php echo $post['Post']['image_1'] ?>" style="float: left; margin-right: 10px ">
                        <?php endif; ?>
                            
                                <?php 
                                if (!empty($post['Post']['dek'])) {
                                    echo '<h4 style="color: #326696">' . $post['Post']['dek'] .'</h4>' ;
                                    echo '<p>' . trim($this->Text->truncate($this->Shortcode->strip_shortcodes( strip_tags($post['Post']['post'])), 200)) .
                                            ' <a href="/posts/' . $post['Post']['slug'] .'">Read More</a></p>';
                                } else {
                                    echo '<p>' . trim($this->Text->truncate( $this->Shortcode->strip_shortcodes(strip_tags($post['Post']['post']) ), 200)) .
                                            ' <a href="/posts/' . $post['Post']['slug'] .'">Read More</a></p>';
                                }
                                ?>
                                                       
                            <p><small><?php echo date( 'Y-M-d', strtotime($post['Post']['created']) ) ?></small></p>
                        </div>
                    </div>
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
            
            <div class="row hidden-phone">
                <div class="span4">
                    <h3 class="frame invert">Social</h3>
                    <div class="row">
                        <div class="span4">
                            <div class="fb-like-box right_adbox" data-href="https://www.facebook.com/pages/YYZtech/134577983260231" data-width="350" data-height="350" data-show-faces="true" data-border-color="fff" data-stream="true" data-header="true"></div>
                            
                        </div>
                    </div>
                </div>
            </div>
           
                               
        </div>        

                               
        </div>
    </div>
   
</div>

<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>



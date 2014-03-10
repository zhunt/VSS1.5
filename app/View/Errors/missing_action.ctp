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
            
		<h1>Page Not Found</h1>
            
        <h3>If you are looking for a store, you might see this if the store has closed.</h3>

		<h3>If you are looking for <a href="http://yyztech.ca/posts/finding-free-wifi-in-toronto">Free WiFi in Toronto</a> it has moved <a href="http://yyztech.ca/posts/finding-free-wifi-in-toronto">here</a>. </h3>
     
            
               

            
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

        
    </div>

    </div>
<div>
        
<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>
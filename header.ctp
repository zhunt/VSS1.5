<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="container">
    
    
        
<div class="row" >
    <div class="span12">
        <?php echo $this->Html->image('yyz-logo-bny.jpg', 
                                    array('alt' => 'BookstoresNewYork.com'
                                            )) ?>
    </div>
    
</div>
<div class="row" >
    <div class="span12" > 
        
    <div class="navbar" style="background: #333">
    <div class="navbar-inner">
    <div class="container" style="background: #333">
    
    <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    
    <!-- Be sure to leave the brand out there if you want it shown -->
    <a class="brand" href="<?php echo Configure::read('Website.url') ?>/"><?php echo Configure::read('OpenGraph.site_name') ?></a>
    
    <!-- Everything you want hidden at 940px or less, place within here -->
    <div class="nav-collapse">
    <!-- .nav, .navbar-search, .navbar-form, etc -->
    
        <ul class="nav">
           
            <li><a href="/cities/">Cities</a></li>
            <li><a href="/bookstore-features/">Features</a></li>
            <li><a href="/bookstore-services/">Services</a></li>
   
            <li class="dropdown">
            <a href="#"
            class="dropdown-toggle"
            data-toggle="dropdown">
            Cities
            <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              
                <li><a href="/city/new_york/">New York</a></li>
                
                <li class="divider"></li>
                <li><a href="/cities/">More...</a></li>
            </ul>
            </li>


 
        </ul>
        <a class="btn btn-danger" href="http://bookstorescanada.wufoo.com/forms/z7x3p9/" onclick="window.open(this.href,  null, 'height=1238, width=680, toolbar=0, location=0, status=1, scrollbars=1, resizable=1'); return false">Add Your Business</a>
       
    </div>
    
    </div>
    </div>
    </div>
            
    </div>
</div>
    
</div>


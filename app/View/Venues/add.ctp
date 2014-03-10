<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span12">
            

<!-- -->        

<!-- from: http://stackoverflow.com/questions/9495951/using-cakephp-formhelper-with-bootstrap-forms -->


<!-- end -->

<?php echo $this->Form->create('Venue', array('class' => 'form-horizontal',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'class' => 'span2' )));?>
    
    <h1>Add your business</h1>
    
    <h3>Step 1: Location</h3>
    
    <?php echo $this->Session->flash(); ?>
    
    <legend><?php echo __('Location'); ?></legend>
        
    <div class="row">
        <div class="span8">
           <!-- -->
           

    
    <fieldset> 
        
            <div class="control-group">
            <label class="control-label">Company Name:</label>
            <div class="controls">
                <?php echo $this->Form->input('name') ?>
                <span class="help-inline">
                <?php if ($this->Form->isFieldError('name')):?>
                    <?php  echo $this->Form->error('name' ,'<b>Business Name Required!!</b>', array('escape' => false)); ?>
                <?php else: ?>
                    Business name as you'd like it to appear
                <?php endif; ?>
                </span>
            </div>
            </div>
        
            <div class="control-group">
            <label class="control-label">URL:</label>
            <div class="controls">
                <?php echo $this->Form->input('slug') ?>
                <span class="help-inline">
                <?php if ($this->Form->isFieldError('name')):?>
                    <?php  echo $this->Form->error('slug' ,'<b>Business Name Required!!</b>', array('escape' => false)); ?>
                <?php else: ?>
                    link to your profile, e.g. /company/joes-computers-miami 
                <?php endif; ?>
                </span>
            </div>
            </div>   

            <div class="control-group">
            <label class="control-label">Full Address:</label>
            <div class="controls">
                <?php echo $this->Form->input('address', array( 'class' => 'span3')) ?>
                <a href="#" class=" btn btn-small" id="link-geocode">Check Map</a>
                <span class="help-inline">
                <?php if ($this->Form->isFieldError('address')):?>
                    <?php  echo $this->Form->error('address' ,'<b>Address required</b>', array('escape' => false)); ?>
                <?php else: ?>
                    e.g. 8350 S Orange Blossom Trl., Orlando, FL 32809 or Miami, Florida 
            <?php endif; ?>
                </span>
            </div>
            </div>
        
            <?php echo $this->Form->input('geo_lat', array('type' => 'hidden')); echo $this->Form->input('geo_lng', array('type' => 'hidden')) ?>

    </fieldset>        
           <!-- -->
        </div>
        <div class="span3">
            <img src="http://placehold.it/260x180" id="map-image" alt="">
        </div>
    </div>
        
<h3>Step 2: Business Information</h3>        
<!-- -->
<legend>Contact</legend>
 <fieldset> 
            <div class="control-group">
            <label class="control-label">Phone </label>
            <div class="controls">
                <?php echo $this->Form->input('phone_1', array('class' => 'inline', 'label' => false )) ?>          
            </div>         
            </div>

            <div class="control-group">
            <label class="control-label">Additional Phone </label>
            <div class="controls">
                <?php echo $this->Form->input('phone_2', array('class' => 'inline', 'label' => false )) ?>     
                <span class="help-inline">(Fax, Toll-Free number, etc.)</span>
            </div>   
            
            </div>
     
            <div class="control-group">
            <label class="control-label">Website </label>
            <div class="controls">
                <?php echo $this->Form->input('website_url', array('class' => 'inline', 'label' => false )) ?>          
            </div>         
            </div>  
     
            <div class="control-group">
            <label class="control-label">Twitter</label>
            <div class="controls">
                <?php echo $this->Form->input('social_1_url', array('class' => 'inline', 'label' => false )) ?>          
            </div>         
            </div>    
 </fieldset>



<legend>Business Category <small>(Pick up to 2)</small></legend>
 <fieldset> 
             <div class="control-group">
            <label class="control-label"> </label>
            <div class="controls">
                <?php echo $this->Form->input('business_type_1_id', array('type' => 'select', 'class' => 'inline', 'label' => false )) ?>
                <?php echo $this->Form->input('business_type_2_id', array('type' => 'select', 'class' => 'inline', 'label' => false, 'empty' => '(optional)', 'options' => $businessType1s )) ?>
                <span class="help-block">
                <?php if ($this->Form->isFieldError('name')):?>
                    <?php  echo $this->Form->error('slug' ,'<b>Business Name Required!!</b>', array('escape' => false)); ?>
                <?php else: ?>
                    Pick up to two categories to list under
                <?php endif; ?>
                </span>                
            </div>         
            </div>
 </fieldset>
 
 <legend>Products / Services <small>(Pick products and services your business offers)</small></legend>
 <fieldset> 
            <div class="control-group">
            <label class="control-label"></label>
            <div class="controls"> <h3>Products:</h3>
                <div class="row well">
                    
                <?php echo $this->Form->input('VenueProduct', array('type' => 'select', 'label' => false, 'options' => $venueProducts,  'multiple' => 'checkbox', 'class' => 'checkbox inline' ) ); ?>
                </div>    
                            
            </div>         
            </div>
             <div class="control-group">
            <label class="control-label"></label>
            <div class="controls"> <h3>Services:</h3>
                <div class="row well">
                    
                <?php echo $this->Form->input('VenueProduct', array('type' => 'select', 'label' => false, 'options' => $venueServices,  'multiple' => 'checkbox', 'class' => 'checkbox inline' ) ); ?>
                </div>    
                <span class="help-block">
                    Suggest a product / service
                    <?php echo $this->Form->input('suggest_product', array('type' => 'text', 'class' => 'span2')) ?>
                </span>                
            </div>         
            </div>    
 </fieldset>
 
<!-- -->

     <legend>Hours and Description</legend>
 <fieldset>
       
             <div class="control-group">
                 
            <label class="control-label"></label>
            <div class="controls">  <h3>Hours:</h3>
                <div class="row well">
                    
                <?php 
		echo $this->Form->input('hours_mon', array('label' => 'Mon.', 'class' => 'span2', 'div' => array('class' => 'span2') ) );
		echo $this->Form->input('hours_tue', array('label' => 'Tues.', 'class' => 'span2', 'div' => array('class' => 'span2') ) );
		echo $this->Form->input('hours_wed', array('label' => 'Wed.', 'class' => 'span2', 'div' => array('class' => 'span2') ) );
		echo $this->Form->input('hours_thu', array('label' => 'Thur.', 'class' => 'span2', 'div' => array('class' => 'span2') ) );
		echo $this->Form->input('hours_fri', array('label' => 'Fri.', 'class' => 'span2', 'div' => array('class' => 'span2') ) );
		echo $this->Form->input('hours_sat', array('label' => 'Sat.', 'class' => 'span2', 'div' => array('class' => 'span2') ) );
                echo $this->Form->input('hours_sun', array('label' => 'Sun.',  'class' => 'span2', 'div' => array('class' => 'span2') ) );
                
                ?>
                </div>    
                              
            </div>         
            </div> 
     
             <div class="control-group">
                 
            <label class="control-label"></label>
            <div class="controls">  <h3>Description: <small>(Less than 300 words)</small></h3>
                <div class="row well">
                    
                <?php 
		echo $this->Form->input('description', array('class' => 'span10'));
                ?>
                </div>    
                              
            </div>         
            </div>     
     
 </fieldset>
     
     
            <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
                <?php echo $this->Form->input('phone_2', array('class' => 'inline', 'label' => false )) ?>     
                <span class="help-inline">(Optional, if you'd like to be contacted when profile is published)</span>
                
                <?php echo $this->Form->end( array( 'label' => 'Submit', 'class' => 'btn btn-large', 'div' => false));?>
            </div>        

<!-- -->

        
     

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
	$('#VenueAddress').change( function() { $('#link-geocode').trigger('click') } )

	$('#link-geocode').click(function() { 
		address = $('#VenueAddress').val();
		
		if (address != '' ) {
			$.getJSON('/locations/geocode_address', { address: address }, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#VenueGeoLat').val(data.lat);
					$('#VenueGeoLng').val(data.lng);

					imgSrc = 'http://maps.googleapis.com/maps/api/staticmap?center=&zoom=15&markers=size:large|label:A|';
					imgSrc = imgSrc + data.lat + ',' + data.lng + '&size=450x300&sensor=false';
                                        
					$('#map-image').attr('src', imgSrc);				
				}
			});			
		} else {
                    alert('Enter an address first');	
		}
		return false;									  
	});
    });
", array('inline' => false) ); ?>
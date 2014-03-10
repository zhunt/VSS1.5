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

 <legend>Business Category</legend>
 <fieldset> 
             <div class="control-group">
            <label class="control-label">List as:</label>
            <div class="controls">
                <?php echo $this->Form->input('business_type_1_id', array('type' => 'select', 'multiple' => 'checkbox', 'class' => 'checkbox inline' )) ?>
                
                <span class="help-block">
                <?php if ($this->Form->isFieldError('name')):?>
                    <?php  echo $this->Form->error('slug' ,'<b>Business Name Required!!</b>', array('escape' => false)); ?>
                <?php else: ?>
                    pick up to two categories to list under
                <?php endif; ?>
                </span>                
            </div>         
            </div>
 </fieldset>
 
 <legend>Products</legend>
 <fieldset> 
             <div class="control-group">
            <label class="control-label">List as:</label>
            <div class="controls">
                <?php echo $this->Form->input('business_type_1_id', array('type' => 'select', 'multiple' => 'checkbox', 'class' => 'checkbox inline' )) ?>
                
                <span class="help-block">
                <?php if ($this->Form->isFieldError('name')):?>
                    <?php  echo $this->Form->error('slug' ,'<b>Business Name Required!!</b>', array('escape' => false)); ?>
                <?php else: ?>
                    pick up to two categories to list under
                <?php endif; ?>
                    
                    Suggest: <?php echo $this->Form->input('suggest_product', array('type' => 'text', 'class' => 'span2')) ?>
                </span>                
            </div>         
            </div>
 </fieldset>
 
<!-- -->

     <legend>Contact Info.</legend>
 <fieldset>      
 </fieldset>

<!-- -->
     <legend>Services and Hours</legend>
 <fieldset>      
 </fieldset>

       
    
    
    
  
    
        <?php /*        
		echo $this->Form->input('slug');
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('province_id');
		echo $this->Form->input('postal_code', array('label' => array( 'text' => 'Zip Code', 'class' => 'control-label' ) ) );
		echo $this->Form->input('phone_1', array('label' => array( 'text' => 'Phone', 'class' => 'control-label' ) ) );
		//echo $this->Form->input('phone_2');
		echo $this->Form->input('website_url');
		echo $this->Form->input('social_1_url');
		echo $this->Form->input('social_2_url');
		echo $this->Form->input('hours_sun');
		echo $this->Form->input('hours_mon');
		echo $this->Form->input('hours_tue');
		echo $this->Form->input('hours_wed');
		echo $this->Form->input('hours_thu');
		echo $this->Form->input('hours_fri');
		echo $this->Form->input('hours_sat');
		echo $this->Form->input('business_type_1_id');
		echo $this->Form->input('business_type_2_id');
		//echo $this->Form->input('seo_title');
		//echo $this->Form->input('seo_desc');
		echo $this->Form->input('description');
		//echo $this->Form->input('publish_state_id');
		//echo $this->Form->input('modifed');
	*/
        ?>
	
<?php echo $this->Form->end(__('Submit'));?>

<!-- -->
  
</div>
</div>
</div>
    


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
", array('inline' => false) ); 

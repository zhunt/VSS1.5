<?php // 
?>
<style type="text/css">
    body { font-size: 10px; }
    
    div.checkbox {
        display: inline-block;
        margin: 0 0 0 20px;
        padding: 5px 2px;
        width: 180px;
    }
    
    fieldset { border: 1px solid #ccc;}
    
    #hours_block div.input {
        display: inline-block;
        margin: 0;
        padding: 5px 2px;
        width: 250px;
    }
    
    form div { clear: none }

</style>
<link rel="stylesheet" href="/css/base/jquery.ui.all.css">
<link rel="stylesheet" href="/css/base/jquery.ui.theme.css">
<link rel="stylesheet" href="/css/jqueryui/jquery-ui-1.8.21.custom.css">
<style type="text/css">
	.ui-dialog { position: fixed;}
</style>


<div class="container">
<div class="venues form">

<a href="#" id="link_scratch_pad" style="padding-right: 2em">Show Scratch-Pad</a>

<a href="/company/<?php echo $this->data['Venue']['slug'] ?>" target="_blank">View</a>
    
<?php echo $this->Form->create('Venue', array('type' => 'file') );?>
	<fieldset>
		<legend><?php echo __('Admin Edit Venue'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('VenueDetail.id');
                
                echo '<fieldset id="hours_block">'; 
		echo $this->Form->input('name');
                echo $this->Form->input('sub_name');
		echo $this->Form->input('slug');
                echo '</fieldset>';
                 
                echo '<fieldset id="hours_block">';                
		echo $this->Form->input('address');
		echo $this->Form->input('city_id');
		echo $this->Form->input('province_id');
		echo $this->Form->input('postal_code');
                echo $this->Form->input('intersection_id', array('empty' => true, 'after' => '<p><a id="link_add_intersection" href="#">Add Intersection</a></p>' ));
                echo $this->Form->input('city_region_id', array('empty' => true));
                echo $this->Form->input('city_neighbourhood_id', array('empty' => true));
                echo $this->Form->input('geo_lat', array('after' => '<a href="#" id="link-geocode">Geocode address</a>'));
		echo $this->Form->input('geo_lng');
                echo $this->Form->input('map_zoom_level'); 
                echo '</fieldset>';
                

                echo '<div class="row">';
                echo '<div style="margin-right: 10px; float: left">
                        <div style="width: 350px; height: 250px; border: 1px solid black;" id="gmap"></div>
                        Venue map
                        <p><a href="#" id="link_reset_streetview">Reset Streetview</a></p>
                     </div>';
                echo '<div style="margin-right: 10px; float: left">
                        <div style="width: 350px; height: 250px; border: 1px solid black;" id="streetview"></div>
                        Streetview
                        
                     </div>';
                echo '<div style="margin-right: 10px; float: left">
                        <div style="width: 350px; height: 250px; border: 1px solid black;" id="streetview_gmap"></div>
                        Streetview map
                     </div>';
                echo '</div>';
                
                echo '<fieldset id="">';
                
                
                echo $this->Form->input('VenueDetail.streetview_lat'); 
                echo $this->Form->input('VenueDetail.streetview_lng');
                echo $this->Form->input('VenueDetail.streetview_heading'); 
                echo $this->Form->input('VenueDetail.streetview_pitch');
                echo $this->Form->input('VenueDetail.streetview_zoom');
                echo '<p><a href="#" id="link_clear_streetview">Clear Streetview</a></p>';
                echo '</fieldset>';               
                
                echo '<fieldset id="hours_block">';    
		echo $this->Form->input('phone_1');
		echo $this->Form->input('tracking_num');
		
		echo $this->Form->input('phone_2');
		

                echo $this->Form->input('phone_2_desc');
		echo $this->Form->input('website_url');
		echo $this->Form->input('social_1_url');
		echo $this->Form->input('social_2_url');
                echo '</fieldset>';
                
                echo '<fieldset id="hours_block">
                        <legend>Hours</legend>';
		echo $this->Form->input('hours_sun');
		echo $this->Form->input('hours_mon');
		echo $this->Form->input('hours_tue');
		echo $this->Form->input('hours_wed');
		echo $this->Form->input('hours_thu');
		echo $this->Form->input('hours_fri');
		echo $this->Form->input('hours_sat');
                echo '<p><a href="#" id="link_copy_hours">Copy Sunday to all</a></p>';
                echo '</fieldset>';
                
                echo '<fieldset id="hours_block">
                        <legend>Business Types</legend>';                
		echo $this->Form->input('business_type_1_id', array('options' => $businessType1s ));
		echo $this->Form->input('business_type_2_id', array('empty' => '(optional)', 'options' => $businessType1s ) );
                echo $this->Form->input('business_type_3_id', array('empty' => '(optional)', 'options' => $businessType1s ) );
                echo '</fieldset>';
                
		echo $this->Form->input('chain_id', array('empty' => '(optional)', 'options' => $chains, 
                    'after' => '<a href="#" id="link_add_venuechain">Add Chain</a>' ) );
                
                echo $this->Form->input('VenueProduct', array('type' => 'select', 'label' => 'Products', 'options' => $venueProducts,  'multiple' => 'checkbox', 'selected' => $selectedFeatures ) );
                echo $this->Form->input('VenueService', array('type' => 'select', 'label' => 'Features', 'options' => $venueServices, 'multiple' => 'checkbox', 'selected' => $selectedFeatures ) );
                echo $this->Form->input('VenueAmenity', array('type' => 'select', 'label' => 'Amenity', 'options' => $venueAmenities, 'multiple' => 'checkbox', 'selected' => $selectedFeatures ) );

		echo $this->Form->input('seo_title', array('class' => 'span4', 
                    'after' => '<p><a href="#" id="link_add_seo_title">Get Title</a></p><p id="char_counter_seo_title">Counter: xxx</p>'));
		echo $this->Form->input('seo_desc', array('class' => 'span8', 'type' => 'textarea', 'rows' => 1, 
                        'after' => '<p><a href="#" id="link_add_metakeywords">Meta Keywords</a></p> <p id="char_counter_seo_desc">Counter: xxx</p>'));
		echo $this->Form->input('notes', array('class' => 'span8'));
		echo $this->Form->input('description', array('class' => 'span8'));
		
		echo $this->Form->input('VenueDetail.profile_image', array('type' => 'file', 'label' => 'Image: ' . $this->data['VenueDetail']['profile_image']) );
		echo $this->Form->input('VenueDetail.profile_image.remove', array('type' => 'checkbox'));
                
		echo $this->Form->input('publish_state_id');
		echo $this->Form->input('last_verified', array('dateFormat' => 'DMY', 'empty' => true));
          
		//echo $this->Form->input('VenueFeature');
                
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Venue.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Venue.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Venues'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Cities'), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Provinces'), array('controller' => 'provinces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Province'), array('controller' => 'provinces', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Type1'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Chains'), array('controller' => 'chains', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Chain'), array('controller' => 'chains', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Publish States'), array('controller' => 'publish_states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Publish State'), array('controller' => 'publish_states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venue Features'), array('controller' => 'venue_features', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue Feature'), array('controller' => 'venue_features', 'action' => 'add')); ?> </li>
	</ul>
</div>
    
    
</div>



<!-- Dialogs, etc. -->
<div class="jqueryui">
    <div id="dialog-message" title="Scratch-Pad">
	<textarea cols="75" rows="10"><?php echo $this->data['Venue']['notes']?></textarea>
    </div>
</div>    
    


<?php echo $this->Html->script( array(
        'http://maps.google.com/maps/api/js?sensor=false', 
        '/js/tiny_mce/jquery.tinymce.js',
        '/js/jquery.maskedinput-1.3.min.js',
        '/js/admin_edit_venue2.js'), array('inline' => false)); ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
	//$('#VenueAddress').change( function() { $('#link-geocode').trigger('click') } )

	$('#link-geocode').click(function() { 
		address = $('#VenueAddress').val() + ', ' + $('#VenueCityId option:selected').text() + ', ' + $('#VenuePostalCode').val();								  
		if (address != '' ) {
			$.getJSON('/admin/locations/geocode_address', { address: address }, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#VenueGeoLat').val(data.lat);
					$('#VenueGeoLng').val(data.lng);

					// re-draw map
					latlng = new google.maps.LatLng(data.lat,data.lng);
					
					//console.log(latlng);

					map.setCenter(latlng);
					marker.setPosition(latlng);
				}
			});			
		} else {
			alert('Enter an address first');	
		}
		return false;									  
	});        
    });
", array('inline' => false) ); ?>


<style type="text/css">
    
    div.checkbox {
    display: inline-block;
    margin: 0;
    padding: 5px 2px;
    width: 250px;
    }
    
    fieldset { border: 1px solid #ccc;}
    
    #hours_block div.input {
    display: inline-block;
    margin: 0;
    padding: 5px 2px;
    width: 250px;
    }
    
</style>

<div class="venues form">
<?php echo $this->Form->create('Venue');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Venue'); ?></legend>
	<?php
		//echo $this->Form->input('id');
		echo $this->Form->input('name');
                echo $this->Form->input('sub_name');

		echo $this->Form->input('slug');
		echo $this->Form->input('address');
		echo $this->Form->input('city_text');
		echo $this->Form->input('city_id');
		echo $this->Form->input('province_id');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('geo_lat');
		echo $this->Form->input('geo_lng');
                echo '<a href="#" class=" btn btn-small" id="link-geocode">Geocode address</a>';
		echo $this->Form->input('phone_1');
		echo $this->Form->input('phone_2');
                echo $this->Form->input('phone_2_desc');
		echo $this->Form->input('website_url');
		echo $this->Form->input('social_1_url');
		echo $this->Form->input('social_2_url');
                
                echo '<fieldset id="hours_block">
                        <legend>Hours</legend>';
		echo $this->Form->input('hours_sun');
		echo $this->Form->input('hours_mon');
		echo $this->Form->input('hours_tue');
		echo $this->Form->input('hours_wed');
		echo $this->Form->input('hours_thu');
		echo $this->Form->input('hours_fri');
		echo $this->Form->input('hours_sat');
                echo '</fieldset>';
                
		echo $this->Form->input('business_type_1_id', array('options' => $businessType1s ));
		echo $this->Form->input('business_type_2_id', array('empty' => '(optional)', 'options' => $businessType1s ) );
                echo $this->Form->input('business_type_3_id', array('empty' => '(optional)', 'options' => $businessType1s ) );
		echo $this->Form->input('chain_id', array('empty' => '(optional)', 'options' => $chains ) );
                
                echo $this->Form->input('VenueProduct', array('type' => 'select', 'label' => 'Products', 'options' => $venueProducts,  'multiple' => 'checkbox' ) );
                echo $this->Form->input('VenueService', array('type' => 'select', 'label' => 'Features', 'options' => $venueServices, 'multiple' => 'checkbox' ) );
                echo $this->Form->input('VenueAmenity', array('type' => 'select', 'label' => 'Amenity', 'options' => $venueAmenities, 'multiple' => 'checkbox' ) );

		echo $this->Form->input('seo_title');
		echo $this->Form->input('seo_desc');
		echo $this->Form->input('notes');
		echo $this->Form->input('description');
		echo $this->Form->input('publish_state_id');
		echo $this->Form->input('modified');
          
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

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
	$('#VenueAddress').change( function() { $('#link-geocode').trigger('click') } )

	$('#link-geocode').click(function() { 
		address = $('#VenueAddress').val() + ', ' + $('#VenueCityText').val() + ', ' + $('#VenueProvinceId option:selected').text();
		
alert(address);
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

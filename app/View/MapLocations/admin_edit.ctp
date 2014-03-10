<div class="mapLocations form">
<?php echo $this->Form->create('MapLocation'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Map Location'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
                echo $this->Form->input('address', array('after' => '<a href="#" id="link-geocode">Geocode</a>') );
		echo $this->Form->input('geo_lat');
		echo $this->Form->input('geo_lng');
		echo $this->Form->input('venue_id', array('empty' => true, 'after' => '<a href="#" id="link_copy_venue_data">Copy from Venue</a>'));
		echo $this->Form->input('phone_1');
		echo $this->Form->input('map_location_type_id');
		echo $this->Form->input('hours_sun', array('after' => '<a href="#" id="link_copy_hours">Copy Sun. to all</a>'));
		echo $this->Form->input('hours_mon');
		echo $this->Form->input('hours_tue');
		echo $this->Form->input('hours_wed');
		echo $this->Form->input('hours_thu');
		echo $this->Form->input('hours_fri');
		echo $this->Form->input('hours_sat');
		echo $this->Form->input('notes');
                echo $this->Form->input('city_id', array('empty' => true) );
                echo $this->Form->input('province_id', array('empty' => true) );
		echo $this->Form->input('Map');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MapLocation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('MapLocation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('controller' => 'map_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('controller' => 'map_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php echo $this->Html->script( array(
        'http://maps.google.com/maps/api/js?sensor=false', 
      
        '/js/jquery.maskedinput-1.3.min.js',
        '/js/admin_edit_venue2.js'), array('inline' => false)); ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
    
        $('#MapLocationPhone1').mask('999.999.9999? x99999');
        
	$('#link_copy_hours').click( function() { 
		hours = $.trim($('#MapLocationHoursSun').val());
		
		$('#MapLocationHoursMon').val(hours);
		$('#MapLocationHoursTue').val(hours);
		$('#MapLocationHoursWed').val(hours);
		$('#MapLocationHoursThu').val(hours);
		$('#MapLocationHoursFri').val(hours);
		$('#MapLocationHoursSat').val(hours); 
		
		return false;
	} );

            
	//$('#VenueAddress').change( function() { $('#link-geocode').trigger('click') } )
        
        $('#link_copy_venue_data').click( function() {
            venueId = $('select#MapLocationVenueId').val();
            console.log(venueId);
            $.getJSON('/api/get_venue_basic/' + venueId + '.json', function(data){
                $('#MapLocationHoursSun').val(data['Venue.hours_sun']);
                $('#MapLocationHoursMon').val(data['Venue.hours_mon']);
                $('#MapLocationHoursTue').val(data['Venue.hours_tue']);
                $('#MapLocationHoursWed').val(data['Venue.hours_wed']);
                $('#MapLocationHoursThu').val(data['Venue.hours_thu']);
                $('#MapLocationHoursFri').val(data['Venue.hours_fri']);
                $('#MapLocationHoursSat').val(data['Venue.hours_sat']);
               
                $('#MapLocationPhone1').val(data['Venue.phone_1']);
                $('#MapLocationName').val( $.trim( data['Venue.name'] + ' ' + data['Venue.sub_name']) );
                
                $('#MapLocationAddress').val(data['Venue.address'] + ', ' + data['City.name'] );
                $('#MapLocationGeoLat').val(data['Venue.geo_lat']);
                $('#MapLocationGeoLng').val(data['Venue.geo_lng']);
                
                $('#MapLocationCityId').val( data['City.id'] );
                $('#MapLocationProvinceId').val( data['Province.id'] );
                

            } );
            return false;
        } );

	$('#link-geocode').click(function() { 
		address = $('#MapLocationAddress').val();								  
		if (address != '' ) { 
			$.getJSON('/admin/locations/geocode_address', { address: address }, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#MapLocationGeoLat').val(data.lat);
					$('#MapLocationGeoLng').val(data.lng);

					// re-draw map
					//latlng = new google.maps.LatLng(data.lat,data.lng);
					
					//console.log(latlng);

					//map.setCenter(latlng);
					//marker.setPosition(latlng);
				}
			});			
		} else {
			alert('Enter an address first');	
		}
		return false;									  
	});        
    });
", array('inline' => false) ); ?>


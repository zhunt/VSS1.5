// admin_edit_venue.js

var latlng;
var map;
var myOptions;
var marker;
var navMap;
var marker2;

var panorama;
var streetviewPano;
var streetviewOptions; 
var panoramaOptions;
var streetviewLatlng;

var swLat = 0;
var swLng = 0;
var swZoom = 0;
var swPitch = 0;
var swHeading = 0;


// -------------------------------------------------------


      function initialize() {

	if ( !document.getElementById('gmap') )
		return;
		
	$('body').unload('GUnload'); // for IE
	
        // ====================================================================
        // set-up main map
	latlng = new google.maps.LatLng( $('#VenueGeoLat').val(), $('#VenueGeoLng').val() );
	
	if ( $('#VenueMapZoomLevel').val() ) {
            mapZoom = parseInt($('#VenueMapZoomLevel').val());
	} else {
            mapZoom = 14;
            $('#VenueMapZoomLevel').val(mapZoom)
	}
        
	myOptions = {
		zoom: mapZoom,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map( document.getElementById('gmap') , myOptions);
        //console.log( 'set-up map' );
	
	// add marker at start position
	marker = new google.maps.Marker({
		position: latlng, 
		map: map,
		title:'Current position',
		draggable: true,
		clickable: true
	});	

	// set-up dragable event for maker start and end
	google.maps.event.addListener(marker, 'dragend', function(event) {
                $('#VenueGeoLat').val(  event.latLng.lat() );
                $('#VenueGeoLng').val(  event.latLng.lng() );  
	});
	google.maps.event.addListener(map, 'zoom_changed', function(event) {
                $('#VenueMapZoomLevel').val( map.getZoom() );
	});     
        //console.log( 'added marker' );
        
        // ====================================================================
        // set-up streetview
        // ====================================================================
        
      
        venueLocation = new google.maps.LatLng( swLat , swLng );
        
        panoramaOptions = {
            position: venueLocation,
            pov: {
                heading: swHeading,
                pitch: swPitch,
                zoom: swZoom
            },
            visible: true
            };
            //console.log( 'set-up street-view', panoramaOptions );
        
        panorama = new google.maps.StreetViewPanorama(document.getElementById('streetview'), panoramaOptions);  
        
        
        
        //console.log( '99: set-up street-view', panoramaOptions );
        
        // set-up streetview listeners
        google.maps.event.addListener(panorama, 'position_changed', function() {
            //console.log( 'pos', panorama );
            swLat = panorama.getPosition().lat();
            swLng = panorama.getPosition().lng();
            
            // re-draw map
            latlng = new google.maps.LatLng( swLat, swLng );
            navMap.setCenter(latlng);
            //marker2.setPosition(latlng);  
            updateSWForm();
        });

        google.maps.event.addListener(panorama, 'pov_changed', function() {
            //console.log( 'pov', panorama.getPov() );
            swHeading = panorama.getPov().heading;
            swPitch = panorama.getPov().pitch;
            swZoom = panorama.getPov().zoom;
            updateSWForm();
        });

        // ====================================================================
        // set-up streetview nav map, use same inital options as main map
        navMap = new google.maps.Map( document.getElementById('streetview_gmap') , myOptions);
        
        navMap.setStreetView(panorama);
        /*
	// add marker at start position
	marker2 = new google.maps.Marker({
		position: latlng, 
		map: navMap,
		title:'Current position',
		draggable: true,
		clickable: true
	});
	
	google.maps.event.addListener(marker2, 'dragend', function(event) {
            swLat = event.latLng.lat();
            swLng = event.latLng.lng();
            updateSWForm();
            updateStreetview();
	});
        */
      }

/*
 * Updates the streetview form from internal varibles
 */
function updateSWForm() {
    $('#VenueDetailStreetviewLat').val(swLat);
    $('#VenueDetailStreetviewLng').val(swLng);
    $('#VenueDetailStreetviewPitch').val(swPitch);
    $('#VenueDetailStreetviewHeading').val(swHeading);
    $('#VenueDetailStreetviewZoom').val(swZoom);
}  

function updateStreetview() {
    newLocation = new google.maps.LatLng( swLat , swLng );
   
    panorama.setPosition(newLocation);
}
      
$(document).ready(function() {
    //google.maps.event.addDomListener(window, 'load', initialize);
    
    if ($('#VenueDetailStreetviewLat').val() == '')
        $('#VenueDetailStreetviewLat').val(0);
    
    if ($('#VenueDetailStreetviewLng').val() == '')
        $('#VenueDetailStreetviewLng').val(0);
    
    if ($('#VenueDetailStreetviewHeading').val() == '')
        $('#VenueDetailStreetviewHeading').val(0); 
    
    if ($('#VenueDetailStreetviewPitch').val() == '')
        $('#VenueDetailStreetviewPitch').val(0); 
    
    if ($('#VenueDetailStreetviewZoom').val() == '')
        $('#VenueDetailStreetviewZoom').val(1);     
    
    
    swLat = parseFloat( $('#VenueDetailStreetviewLat').val() );
    swLng = parseFloat( $('#VenueDetailStreetviewLng').val() );
    swHeading = parseFloat( $('#VenueDetailStreetviewHeading').val() );
    swPitch = parseFloat( $('#VenueDetailStreetviewPitch').val() );
    swZoom = parseFloat( $('#VenueDetailStreetviewZoom').val() );
    
    initialize()
    
    updateSWForm();
});

// functions related to maps functionality
$(document).ready(function(){

        // used by map functions to reset Streetview to main map
        $('#link_reset_streetview').click( function() {
            swLat = $('#VenueGeoLat').val();
            swLng = $('#VenueGeoLng').val();
            swPitch = 0;
            swZoom = 1;
            swHeading = 0;
            
            
            // re-draw map
            latlng = new google.maps.LatLng(swLat, swLng );
            navMap.setCenter(latlng);
            updateSWForm();   
            
            return false;
        });
        
        $('#link_clear_streetview').click( function() {
            swLat = 0;
            swLng = 0;
            swPitch = 0;
            swZoom = 1;
            swHeading = 0;            
            updateSWForm();   
        });
});


// END OF MAP FUNCTIONS

// -------------------------------------------------------


$(document).ready(function(){
        
	

	// set default description
	$('#link_add_metakeywords').click(function() {
		text = $('#VenueName').val() + ' ' + $('#VenueSubName').val() + ' at ' + $('#VenueAddress').val() + ' near ' +
			$('#VenueIntersectionId option:selected').text() + ' in ' + $('#VenueCityRegionId option:selected').text() +
			' ' + $('#VenueCityNeighbourhoodId option:selected').text() + ' , ' + $('#VenueCityId option:selected').text();
		
		$('#VenueSeoDesc').val(text);
		$('#VenueSeoDesc').trigger('keyup');
		return false;									   
	});

	// show number of charcters in meta description field
	$('#VenueSeoDesc').keyup(function() {
		count = $('#VenueSeoDesc').val().length;

		if ( count >= 150)
			text = 'Count: <span style="color: red">' + count + '</span>';
		else
			text = 'Count: ' + count;
			
		$('#char_counter_seo_desc').html(text);
		return false;									   
	});
        
        // ... and for the SEO title field (50 chars)
	$('#VenueSeoTitle').keyup(function() {
		count = $('#VenueSeoTitle').val().length;

		if ( count >= 50)
			text = 'Count: <span style="color: red">' + count + '</span>';
		else
			text = 'Count: ' + count;
			
		$('#char_counter_seo_title').html(text);
		return false;									   
	});        
	
	
	
	$('#link_geocode_address').click(function() { 
		address = $('#VenueAddress').val() + ', ' + $('#VenueCityId option:selected').text() + ', ' + $('#VenuePostalCode').val();								  
		if (address != '' ) {
			$.getJSON('/admin/locations/geocode_address', {address: address}, function(data) {
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
		
	// postal code (turned off for zip codes
	//$('#VenuePostalCode').mask("a9a 9a9");
	//$('#VenuePostalCode').blur( function() { $(this).val( $(this).val().toUpperCase() )  } );	
	
	// phone / fax masks
	$('#VenuePhone1').mask("999.999.9999? x99999");
	$('#VenuePhone2').mask("999.999.9999? x99999");
	$('#VenueTrackingNum').mask("9999999999?9999");
	

	
	// dialog scratch-pad:
	$('#link_scratch_pad').click(function() {$('#dialog-message').dialog( "open" );return false} );
	
	$('#dialog-message').dialog({
			modal: false,
			autoOpen: false,
			width: 'auto',
			height: 'auto',
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				}
			}
		});
	
	// copy hours from Sunday to other days
	$('#link_copy_hours').click( function() { 
		hours = $.trim($('#VenueHoursSun').val());
		
		$('#VenueHoursMon').val(hours);
		$('#VenueHoursTue').val(hours);
		$('#VenueHoursWed').val(hours);
		$('#VenueHoursThu').val(hours);
		$('#VenueHoursFri').val(hours);
		$('#VenueHoursSat').val(hours);
		
		return false;
	} );
	
	// generate SEO title
	$('#link_add_seo_title').click( function() {
		title = $.trim( $('#VenueName').val() + ' ' + $('#VenueSubName').val() );
		title = title + ', ';
		title = title + $('#VenueAddress').val(); 
		title = title + ', ';
		title = title + $.trim( $('#VenueCityNeighbourhoodId option:selected').text() + ' ' + $('#VenueCityId option:selected').text() );
		
		$('#VenueSeoTitle').val(title);			
		return false;
	});

	
	// add intersection 
	$('#link_add_intersection').click(function() { 
		cityId = $('#VenueCityId option:selected').val();
		cityName =  $('#VenueCityId option:selected').text();
		var name=prompt("Enter Name for New Intersection in " + cityName, '');
		if ( name != '' && name != null ) {
			$.getJSON('/admin/intersections/ajax_add', {name: name, cityId: cityId}, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#VenueIntersectionId').html(data.html);
				}
			});
		}
		return false;
		} 
	);				

	// add venue chain 
	$('#link_add_venuechain').click(function() { 
		var name=prompt("Enter Name for New Chain", '');
		if ( name != '' && name != null ) {
                $.getJSON('/admin/chains/ajax_add', {name: name}, function(data) {
                    if ( data.status != 'ok' ) {
                            alert(data.msg)
                    } else {
                            $('#VenueChainId').html(data.html);
                    }
                });
		}
		return false;
		} 
	);	

	// add Venue Amenity
	$('#link_add_venueamenity').click(function() { 
		
		venueTypeName = '';
		$('#VenueTypeDiv :checkbox:checked').each(function(i){
		  venueTypeId = $(this).val();
		  venueTypeName = $(this).next().text();
		  return;
		});
		if ( venueTypeName == '' ) {
			alert("Pick one venue type first");
			return false;
		}
		
		var name = prompt("Enter Amenity for " + venueTypeName, '');
		if ( name != '' && name != null ) {
                    $.getJSON('/admin/venue_amenities/ajax_add', {venueTypeId: venueTypeId, name: name}, function(data) {
                        if ( data.status != 'ok' ) {
                            alert(data.msg)
                        } else {
                            $('#VenueAmenityDiv').append(data.html);
                        }
                    });
		}			
		
		return false;
		}
	)
			

	// add Venue Product
	$('#link_add_venueproduct').click(function() { 
		
		venueTypeName = '';
		$('#VenueTypeDiv :checkbox:checked').each(function(i){
		  venueTypeId = $(this).val();
		  venueTypeName = $(this).next().text();
		  return;
		});
		if ( venueTypeName == '' ) {
			alert("Pick one venue type first");
			return false;
		}
		
		var name = prompt("Enter Product for " + venueTypeName, '');
		if ( name != '' && name != null ) {
			$.getJSON('/admin/venue_products/ajax_add', {venueTypeId: venueTypeId, name: name}, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#VenueProductDiv').append(data.html);
				}
			});
		}			
		
		return false;
		}
	);
	
	// add Venue Service
	$('#link_add_venueservice').click(function() { 
		
		venueTypeName = '';
		$('#VenueTypeDiv :checkbox:checked').each(function(i){
		  venueTypeId = $(this).val();
		  venueTypeName = $(this).next().text();
		  return;
		});
		if ( venueTypeName == '' ) {
			alert("Pick one venue type first");
			return false;
		}
		
		var name = prompt("Enter Service for " + venueTypeName, '');
		if ( name != '' && name != null ) {
			$.getJSON('/admin/venue_services/ajax_add', {venueTypeId: venueTypeId, name: name}, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#VenueServiceDiv').append(data.html);
				}
			});
		}			
		
		return false;
		}
	);
			
	// add Venue Sub Type
	$('#link_add_venusubtype').click(function() { 
		
		venueTypeName = '';
		$('#VenueTypeDiv :checkbox:checked').each(function(i){
		  venueTypeId = $(this).val();
		  venueTypeName = $(this).next().text();
		  return;
		});
		if ( venueTypeName == '' ) {
			alert("Pick one venue type first");
			return false;
		}
		
		var name = prompt("Enter Name for Type of " + venueTypeName, '');
		if ( name != '' && name != null ) {
			$.getJSON('/admin/venue_subtypes/ajax_add', {venueTypeId: venueTypeId, name: name}, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					$('#VenueSubTypeDiv').append(data.html);
				}
			});
		}			
		

		return false;
		}
	);
	
	// ----
	// add Venue Service
	$('.link_clone_venue').click(function() { 
		
		var address = prompt("Enter address of new location", '');
		venueId = $(this).attr('name');
		//console.log( id ); 

		if ( address == '' ) {
			alert("Enter an address");
			return false;
		}
		
		if ( address != '' && address != null ) {
			$.getJSON('/admin/venues/ajax_clone_venue/', {venueId: venueId, address: address}, function(data) {
				if ( data.status != 'ok' ) {
					alert(data.msg)
				} else {
					alert(data.msg) //$('#VenueServiceDiv').append(data.html);
				}
			});
		}			

		return false;
		}
	);

	
	// get list of checked-off types, subtype(s), products and services
	$('#link_get_features').click(function() { 
		selectorsList = [ '#VenueTypeDiv', '#VenueSubTypeDiv', '#VenueProductDiv',  '#VenueAmenityDiv', '#VenueServiceDiv' ];
		
		
		for ( i = 0; i <= selectorsList.length; i++ ){ 
			j = 0;
			output = new Array();
			
			$( selectorsList[i] + ' input:checked').each(
				function(x) {		
					output[j] = $(this).next().text();
					j++;
				}
			);
			
			featuresList = output.join(', ' );
			
			orgText = $('#VenueDescription').val();
		
			$('#VenueDescription').val( orgText + "\n" + featuresList);			
		}
		
		return false;
	});
	
			
});	

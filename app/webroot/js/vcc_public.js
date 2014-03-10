// vcc_public.js

// ============================================================================
//                  for site auto-complete
// ============================================================================


$(document).ready(function(){
	
/*
 * jQuery UI Autocomplete Select First Extension
 *
 * Copyright 2010, Scott González (http://scottgonzalez.com)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * http://github.com/scottgonzalez/jquery-ui-extensions
 */
(function( $ ) {

$( ".ui-autocomplete-input" ).live( "autocompleteopen", function() {
	var autocomplete = $( this ).data( "autocomplete" ),
		menu = autocomplete.menu;

	if ( !autocomplete.options.selectFirst ) {
		return;
	}

	menu.activate( $.Event({ type: "mouseenter" }), menu.element.children().first() );
});

}( jQuery ));

	

		var acItemSelected = false;

		$("input#search_box").autocomplete({
			selectFirst: true,
			'source': function(request, response) {
				$.ajax({
					url: "/searches/autocomplete/",
					data: { term: request.term },
					dataType: "json",
					success: function(data) {
						response($.map(data, function(item) {
							//item.html = '<span class="type-' + item.type + '">' + item.label + '</span>';	
							return {
								//label: item.html,
								id: item.id,
								value: item.label,
								url: item.url
							}
						}))
					}
				})
			},
			'minLength': 2,
			'delay': 100,
			
			'open': function(event, ui) { 
				$('ul.ui-autocomplete li .type-venue').parent().parent().addClass('venue');
				$('ul.ui-autocomplete li .type-city').parent().parent().addClass('city');
				$('ul.ui-autocomplete li .type-product').parent().parent().addClass('product');
			},

			
			// called when item clicked on
			'select': function(event, data) {
				acItemSelected = true;
				window.location = data.item.url;
			}

		}) 
		

		
		$('input#search_box').bind('keypress', function(e) {
				if(e.keyCode==13 && acItemSelected == false){
					window.location = '/searches/text:' + $('#search_box').val();;
				}
			
		});
		
		$('.btn-go').click( function(e){ window.location = '/searches/text:' + $('#search_box').val(); } )

});

// ============================================================================
//                  for venues
// ============================================================================


var latlng;
var map;
var myOptions;
var marker;

// high-light the current day's hours
$(document).ready(function(){
	// high-light venue hours
	var d=new Date(); 
	var today = 'day_' + d.getDay() // Sunday = 0;
	$('#venue_hours tr#' + today ).addClass('today');
	
	
});

// ============================================================================
//                  for recommendation and error forms
// ============================================================================

// for recommendation forms
$(document).ready(function(){
    $('#link_recommend').click( function() {
        $("#comment-dialog").dialog("destroy");

        $('#comment-dialog').load('/comments/add/venue:' + $('#VenueVenueId').text(), function() {
            $("#comment-dialog").dialog( {width: '400px', modal: true } );

        })

    });
});

// for recommendation forms
$(document).ready(function(){
    $('#link_error').click( function() {
        $("#error-dialog").dialog("destroy");

        $('#error-dialog').load('/comments/add_error_report/venue:' + $('#VenueVenueId').text(), function() {
            $("#error-dialog").dialog( {width: '400px', modal: true } );
        })
		
    });
});

// used to make jQueryUI-style buttons with roll-over
$(document).ready(function(){
    //all hover and click logic for buttons
    $(".fg-button:not(.ui-state-disabled)")
    .hover(
        function(){
                $(this).addClass("ui-state-hover");
        },
        function(){
                $(this).removeClass("ui-state-hover");
        }
    )
    .mousedown(function(){
        $(this).parents('.fg-buttonset-single:first').find(".fg-button.ui-state-active").removeClass("ui-state-active");
        if( $(this).is('.ui-state-active.fg-button-toggleable, .fg-buttonset-multi .ui-state-active') ){ $(this).removeClass("ui-state-active"); }
        else { $(this).addClass("ui-state-active"); }
    })
    .mouseup(function(){
        if(! $(this).is('.fg-button-toggleable, .fg-buttonset-single .fg-button,  .fg-buttonset-multi .fg-button') ){
                $(this).removeClass("ui-state-active");
        }
    });
});


// ============================================================================
//                  set-up venue map
// ============================================================================

function venue_map_initialize() {
	
	$('body').unload('GUnload'); // for IE
	
	latlng = new google.maps.LatLng( $('#venueLat').attr('content'), $('#venueLng').attr('content') ); 
	
	// if zoom set, use this
	if ( $('#MapZoomLevel').val() )
		mapZoom = parseInt($('#MapZoomLevel').val());
	else
		mapZoom = 16;
		
	myOptions = {
		zoom: mapZoom,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map( document.getElementById("gmap") , myOptions);
	
	// add marker at start position
	marker = new google.maps.Marker({
		position: latlng, 
		map: map,
		title:"Current position",
		draggable: false,
		clickable: true
	});	
	
}


// ============================================================================
//                  for venue rating box on venue page
// ============================================================================

$(document).ready(function(){
        $("#rat").children().not("select, #rating_title").hide();

        // Create caption element
        var $caption = $('<div id="caption"/>');

        // Create stars
        $("#rat").stars({
                inputType: "select",
                oneVoteOnly: true,
                captionEl: $caption,
                callback: function(ui, type, value)
                {
                    // Display message to the user at the begining of request
                    $("#messages").text("Saving...").fadeIn(30);

                    // Send request to the server using POST method
                    /* NOTE:
                            The same PHP script is used for the FORM submission when Javascript is not available.
                            The only difference in script execution is the returned value.
                            For AJAX call we expect an JSON object to be returned.
                            The JSON object contains additional data we can use to update other elements on the page.
                            To distinguish the AJAX request in PHP script, check if the $_SERVER['HTTP_X_REQUESTED_WITH'] header variable is set.
                            (see: demo4.php)
                    */
                    //$.post("demo4.php", {rate: value}, function(json)
                    $.post("/venue_ratings/ajax_vote", {rate: value, venue: $('#VenueVenueId').text() }, function(json)
                    {
                        // Change widget's title
                        $("#rating_title").text("Average rating");

                        // Select stars from "Average rating" control to match the returned average rating value
                        ui.select(Math.round(json.avg));

                        // Update widget's caption
                        $caption.text( json.votes + " votes"); // " + json.avg + ")"

                        // Display confirmation message to the user
                        $("#messages").text("Rating saved (" + value + "). Thanks!").stop().css("opacity", 1).fadeIn(30);

                        // Hide confirmation message after 2 sec...
                        setTimeout(function(){
                            $("#messages").fadeOut(1000)
                        }, 2000);

                    }, "json");
            }
        });

        // Since the <option value="3"> was selected by default, we must remove this selection from Stars.
        //$("#rat").stars("selectID", -1);

        // Append caption element !after! the Stars
        $caption.appendTo("#rat");

        // Create element to use for confirmation messages
        $('<div id="messages"/>').appendTo("#rat");
});


// ============================================================================
//                  for search results map
// ============================================================================

// set-up map
function search_map_initialize() {
	
	$('body').unload('GUnload'); // for IE
	 
	latlng = new google.maps.LatLng( venueCords[0].geo_lat, venueCords[0].geo_lng );
	myOptions = {
		zoom: 14,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map( document.getElementById("gmap") , myOptions);
	
	mapSize = new google.maps.LatLngBounds(latlng, latlng);
	for (var i = 0; i < venueCords.length; i++) {
		var myMarkerLatLng = new google.maps.LatLng(venueCords[i].geo_lat, venueCords[i].geo_lng );

		marker = new google.maps.Marker({
			position: myMarkerLatLng,
			map: map
			
			});
		
		var toolTip = new InfoBox({latlng: marker.getPosition(), map: map, marker: marker, label: venueCords[i].name, url: venueCords[i].slug });
		
		mapSize.extend(myMarkerLatLng);
	}

	map.fitBounds(mapSize);
	//console.log(map.zoom)
	
}

// ====================================================================================================================
// == 3rd party functions ==
// heavly based on code at: http://gmaps-samples-v3.googlecode.com/svn/trunk/infowindow_custom/infowindow-custom.html
function InfoBox(opts) {
  google.maps.OverlayView.call(this);
  this.latlng_ = opts.latlng;
  this.map_ = opts.map;
  this.offsetVertical_ = -10; //-195;
  this.offsetHorizontal_ = 10;
  this.height_ = 165;
  this.width_ = 266;
  this.label = opts.label;
  this.marker = opts.marker;
  this.url_ = '/' + opts.url;

  var me = this;
/* this.boundsChangedListener_ =
    google.maps.event.addListener(this.map_, "bounds_changed", function() {
      return me.panMap.apply(me);
    });*/
	
	google.maps.event.addListener(this.marker, "mouseover", function() {
		  return me.div_.style.display = 'block';
		});	

	google.maps.event.addListener(this.marker, "mouseout", function() {
		  return me.div_.style.display = 'none';
		});			

	google.maps.event.addListener(this.marker, "click", function() {									 
		  window.location = me.url_
		});	
	
  // Once the properties of this OverlayView are initialized, set its map so
  // that we can display it.  This will trigger calls to panes_changed and
  // draw.
  this.setMap(this.map_);
}

/* InfoBox extends GOverlay class from the Google Maps API
 */
InfoBox.prototype = new google.maps.OverlayView();

/* Creates the DIV representing this InfoBox
 */
InfoBox.prototype.remove = function() {
  if (this.div_) {
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
  }
};

/* Redraw the Bar based on the current projection and zoom level
 */
InfoBox.prototype.draw = function() {
  // Creates the element if it doesn't exist already.
  this.createElement();
  if (!this.div_) return;

  // Calculate the DIV coordinates of two opposite corners of our bounds to
  // get the size and position of our Bar
  var pixPosition = this.getProjection().fromLatLngToDivPixel(this.latlng_);
  if (!pixPosition) return;

  // Now position our DIV based on the DIV coordinates of our bounds

  this.div_.style.left = (pixPosition.x + this.offsetHorizontal_) + "px";

  this.div_.style.top = (pixPosition.y + this.offsetVertical_) + "px";
  this.div_.style.display = 'none';
  
	google.maps.event.addListener(this.div_, "mouseover", function() {
		  return this.div_.style.display = 'block';
		});	

	google.maps.event.addListener(this.div_, "mouseout", function() {
		  return this.div_.style.display = 'none';
		});	  
};

/* Creates the DIV representing this InfoBox in the floatPane.  If the panes
 * object, retrieved by calling getPanes, is null, remove the element from the
 * DOM.  If the div exists, but its parent is not the floatPane, move the div
 * to the new pane.
 * Called from within draw.  Alternatively, this can be called specifically on
 * a panes_changed event.
 */
InfoBox.prototype.createElement = function() {
  var panes = this.getPanes();
  var div = this.div_;
  if (!div) {
    // This does not handle changing panes.  You can set the map to be null and
    // then reset the map to move the div.
    div = this.div_ = document.createElement("div");
  
    div.style.position = "absolute";
	// for IE:
	div.style.whiteSpace = 'nowrap';
	div.style.backgroundColor = '#fff';
	div.style.padding = '2px 5px';
	div.style.border = '1px solid #000';
	
	div.innerHTML =  this.label
	div.setAttribute('class', 'tooltip');
	

    function removeInfoBox(ib) {
      return function() {
        ib.setMap(null);
      };
    }

    div.style.display = 'none';
    panes.floatPane.appendChild(div);
    //this.panMap();
  } else if (div.parentNode != panes.floatPane) {
    // The panes have changed.  Move the div.
    div.parentNode.removeChild(div);
    panes.floatPane.appendChild(div);
  } else {
    // The panes have not changed, so no need to create or move the div.
  }
}

// jQuery Autocomplete add-ons



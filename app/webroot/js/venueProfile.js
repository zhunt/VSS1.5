$(function(){$("#rat").children().not("select, #rating_title").hide();var a=$('<div id="caption"/>');$("#rat").stars({inputType:"select",oneVoteOnly:true,captionEl:a,callback:function(d,b,c){$("#messages").text("Saving...").fadeIn(30);$.post("/venue_ratings/ajax_vote",{rate:c,venue:venueId},function(e){d.select(Math.round(e.avg));a.text("Votes: "+e.votes+", Score: "+e.avg);if(e.err_msg){$("#messages").text(e.err_msg).stop().css("opacity",1).fadeIn(30)}else{$("#messages").text("Rating saved ("+c+"). Thanks!").stop().css("opacity",1).fadeIn(30)}setTimeout(function(){$("#messages").fadeOut(1000)},2000)},"json")}});a.appendTo("#rat");$('<div id="messages"/>').appendTo("#rat")});$(document).ready(function(){$("#comment_dialog").dialog({autoOpen:false,width:355,height:520,modal:true});$("#error_dialog").dialog({autoOpen:false,width:355,height:450,modal:true});$("#VenueCommentAjaxAddForm").validate({submitHandler:function(c){$("form#VenueCommentAjaxAddForm :input[type=submit]").val("Saving...").attr("disabled","true").fadeOut("slow");$(c).ajaxSubmit({target:"#viewer_comments",success:function(){alert("Thanks for your recommendation! Recommendations will appear shortly.");$(c).resetForm();$("#comment_dialog").dialog("close");$("#viewer_comments").fadeIn("slow")}})}});$("#VenueErrorAjaxAddForm").validate({submitHandler:function(c){$("form#VenueErrorAjaxAddForm :input[type=submit]").val("Saving...").attr("disabled","true").fadeOut("slow");$(c).ajaxSubmit({success:function(){alert("Thanks for your error report");$(c).resetForm();$("#error_dialog").dialog("close");return false}})}});var b=new Date();var a="day_"+b.getDay();$("tr#"+a+" td strong").removeClass("grey3");$("tr#"+a+" td").css({"font-weight":"bold",color:"black"});$(".recommend_link").click(function(){$("#VenueCommentAddForm").resetForm();$("#comment_dialog").dialog("open");return(false)});$("#reportError_link").click(function(){$("#VenueCommentAddForm").resetForm();$("#error_dialog").dialog("open");return(false)});$("#nearbyVenues_dialog").dialog({autoOpen:false,width:530,height:560,modal:true,resizable:false});$(".nearbyVenues_link").click(function(){$("#nearbyVenues_dialog").dialog("open");showNearbyVenues();$(".ui-widget-overlay").click(function(){$("#nearbyVenues_dialog").dialog("close")});return(false)})});function showNearbyVenues(){if(GBrowserIsCompatible()){var g=new GMap2(document.getElementById("search_map"));g.setCenter(new GLatLng(venueLatt,venueLong),15);g.setUIToDefault();var d=Array();var e=new GLatLngBounds();var a=new GLatLng(venueLatt,venueLong);var b=new GMarker(a);var f=new Tooltip(b,venueName,5);b.tooltip=f;g.addOverlay(b);g.addOverlay(f);GEvent.addListener(b,"mouseover",function(){this.tooltip.show()});GEvent.addListener(b,"mouseout",function(){this.tooltip.hide()});for(var c=0;c<nearbyVenues.length;c++){var a=new GLatLng(nearbyVenues[c].lat,nearbyVenues[c].lng);d.push(a);e.extend(a);var b=new GMarker(a);var f=new Tooltip(b,nearbyVenues[c].label,5);b.tooltip=f;b.url=nearbyVenues[c].url;g.addOverlay(b);g.addOverlay(f);GEvent.addListener(b,"click",function(){this.tooltip.hide();location.href=this.url});GEvent.addListener(b,"mouseover",function(){this.tooltip.show()});GEvent.addListener(b,"mouseout",function(){this.tooltip.hide()})}bounds=new GBounds(d);zoomLevel=best_zoom(bounds,$("#search_map"));zoomLevel=16-zoomLevel+1;if(nearbyVenues.length==1){zoomLevel=16}mapCentre=e.getCenter();g.setCenter(mapCentre,zoomLevel)}}function best_zoom(a,g){var c=$("#search_map").attr("offsetWidth");var i=$("#search_map").attr("offsetHeight");var f=Math.abs(a.maxY-a.minY);var j=Math.abs(a.maxX-a.minX);if(f==0&&j==0){return 4}var h=Math.PI*(a.minY+a.maxY)/360;var b=0.0000107288;var e=Math.ceil(Math.log(f/(b*i))/Math.LN2);var d=Math.ceil(Math.log(j/(b*c*Math.cos(h)))/Math.LN2);return(d>e)?d:e}function createMarker(a,c,d){var b=new GMarker(a);return b}function Tooltip(a,c,b){this.marker_=a;this.text_=c;this.padding_=b}Tooltip.prototype=new GOverlay();Tooltip.prototype.initialize=function(a){var b=document.createElement("div");b.appendChild(document.createTextNode(this.text_));b.className="tooltip";b.style.position="absolute";b.style.visibility="hidden";a.getPane(G_MAP_FLOAT_PANE).appendChild(b);this.map_=a;this.div_=b};Tooltip.prototype.remove=function(){this.div_.parentNode.removeChild(this.div_)};Tooltip.prototype.copy=function(){return new Tooltip(this.marker_,this.text_,this.padding_)};Tooltip.prototype.redraw=function(d){if(!d){return}var b=this.map_.fromLatLngToDivPixel(this.marker_.getPoint());var a=this.marker_.getIcon().iconAnchor;var e=Math.round(b.x-this.div_.clientWidth/2);var c=b.y-a.y-this.div_.clientHeight-this.padding_;this.div_.style.top=c+"px";this.div_.style.left=e+"px"};Tooltip.prototype.show=function(){this.div_.style.visibility="visible"};Tooltip.prototype.hide=function(){this.div_.style.visibility="hidden"};
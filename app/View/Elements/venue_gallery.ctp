<?php 
     if (!empty($venue['VenueDetail']['streetview_lat'])) {
        $mapUrl = 'http://maps.googleapis.com/maps/api/streetview?size=740x580&scale=2&location=' . 
                $venue['VenueDetail']['streetview_lat'] . ',' . $venue['VenueDetail']['streetview_lng'] . 
                '&fov=' . 
                '&heading=' . $venue['VenueDetail']['streetview_heading'] . 
                '&pitch=' . $venue['VenueDetail']['streetview_pitch'] . 
                '&sensor=false';
     
        echo "#map { background: url('{$mapUrl}') 50% no-repeat; ";
     }
     
     ?> 
	 
<div id="MapCarousel" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="active item">…</div>
    <div class="item">…</div>
    <div class="item">…</div>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#MapCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#MapCarousel" data-slide="next">&rsaquo;</a>
</div>


$('#MapCarousel').carousel({
  interval: 2000
})
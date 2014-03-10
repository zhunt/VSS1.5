
<div class="span4" style="text-align: center; font-family: 'Open Sans', sans-serif; padding-bottom: 1em; border-bottom: 1px solid #ddd;">
<h2><?php echo $post['Venue']['name'] ?></h2>
<p> <?php echo $post['Venue']['address'] ?></p>

<p><?php echo $post['Venue']['phone_1'] ?></p>

<p><a href="/company/<?php echo $post['Venue']['slug'] ?>">Full Profile</a></p>

<?php
 $cords = $post['Venue']['geo_lat'] . ',' . $post['Venue']['geo_lng'];
 $url = 'http://maps.google.com/maps/api/staticmap?center=' . $cords . '&zoom=15&markers=label:A|' . $cords . '&size=360x160&sensor=false';
?>
<img alt="map of <?php echo $post['Venue']['name'] ?>" class="thumbnail"  src="<?php echo $url ?>">

</div>
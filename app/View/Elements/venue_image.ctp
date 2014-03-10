<?php if ( !empty($venue['VenueDetail']['profile_image'])) {
    $imageUrl = '/uploads/venue_detail/profile_image/thumb/medium/' . $venue['VenueDetail']['profile_image'];
    if (!file_exists( WWW_ROOT . $imageUrl)) 
        $imageUrl = '';
} else if ( isset( $openGraph['streetViewImage'])) {
    $imageUrl = $openGraph['streetViewImage'];
} else {
    $imageUrl = '';
};
?>

<?php if ($imageUrl): ?>
    <div class="row hidden-phone">
        <img id="profile_image" src="<?php echo $imageUrl ?>" class="span4 thumbnail" >
        <div style="float: right; height: 374px" class="span4 thumbnail" id="map"></div>    <!--height: 374px -->         
    </div>

    <div class="row hidden-tablet hidden-desktop">
        <div class="span4 thumbnail" id="map"></div>
    </div>

<style>
    #map { padding: 4px;  }
</style>

<?php else: // no picture (either image or streetview ?>
    <div class="row hidden-phone">
        <div style="float: right" class="span8 thumbnail" id="map"></div>             
    </div>

    <div class="row hidden-tablet hidden-desktop">
        <div class="span4 thumbnail" id="map"></div>
    </div>

<?php endif; ?>
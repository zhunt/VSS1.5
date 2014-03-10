<?php if (isset($microformat)):?>
<!-- microformat data  -->


   <span class="item vcard" style="display:none">
      <span class="fn org"><?php echo $microformat['name'] ?></span>
      <span class="adr">
         <span class="street-address"><?php echo $microformat['address'] ?></span>,
         <span class="locality"><?php echo $microformat['locality'] ?></span>,
         <span class="region"><?php echo $microformat['region'] ?></span>.
         <span class="postal-code"><?php echo $microformat['postal'] ?></span>
         <span class="country-name"><?php echo $microformat['country'] ?></span>
      </span>
     <span class="geo">
        <span class="latitude">
           <span class="value-title" title="<?php echo $microformat['geo_lat'] ?>"></span>
        </span>
        <span class="longitude">
           <span class="value-title" title="<?php echo $microformat['geo_lng'] ?>"></span>
        </span>
     </span>
   <span class="tel"><?php echo $microformat['phone'] ?></span>
      <a href="<?php echo $microformat['website'] ?>" class="url"><?php echo $microformat['website'] ?></a>
   </span>
    
<!-- RDF -->
<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Organization" style="display: none">
   <span property="v:name"><?php echo $microformat['name'] ?></span>
   <div rel="v:address">
      <div typeof="v:Address">
         <span property="v:street-address"><?php echo $microformat['address'] ?></span>,
         <span property="v:locality"><?php echo $microformat['locality'] ?></span>,
         <span property="v:region"><?php echo $microformat['region'] ?></span>
         <span property="v:postal"><?php echo $microformat['postal'] ?></span>
         <span property="v:country-name"><?php echo $microformat['country'] ?></span>
      </div>
   </div>
   <div rel="v:geo">
      <span typeof="v:Geo">
         <span property="v:latitude" id="venueLat" content="<?php echo $microformat['geo_lat'] ?>"></span>
         <span property="v:longitude" id="venueLng" content="<?php echo $microformat['geo_lng'] ?>"></span>
      </span>
   </div>
   <span property="v:tel"><?php echo $microformat['phone'] ?></span>
   <a href="<?php echo $microformat['website'] ?>" rel="v:url"><?php echo $microformat['website'] ?></a>
</div>

<?php endif; ?>
<ul class="breadcrumb">
    <li><a href="/">Home</a> 
    </li> <span class="divider">/</span>
    <li>
    <?php if (isset( $venue['Province']['name'])): ?>
    <a href="/province/<?php echo $venue['Province']['slug']; ?>"><?php echo $venue['Province']['name']; ?></a></li> <span class="divider">/</span>    
    <?php endif; ?>        
    <a href="/city/<?php echo $venue['City']['slug']; ?>"><?php echo $venue['City']['name']; ?></a></li> <span class="divider">/</span>
    <?php if (isset( $venue['CityRegion']['name'])): ?>
    <li><a href="/search/city_region:<?php echo $venue['CityRegion']['slug']; ?>"><?php echo $venue['CityRegion']['name']; ?></a></li>
    <span class="divider">/</span>
    <?php endif; ?>
    <?php if (isset( $venue['CityNeighbourhood']['name'])): ?>
    <li><a href="/search/city_neighbourhood:<?php echo $venue['CityNeighbourhood']['slug']; ?>"><?php echo $venue['CityNeighbourhood']['name']; ?></a></li>
    <span class="divider">/</span>
    <?php endif; ?>   
    
    <?php if (isset($venue['Venue']['name'])): ?>
    <li><a href="/company/<?php echo $venue['Venue']['slug']; ?>"><?php echo $venue['Venue']['name']; ?></a></li>
    <?php endif; ?>   
    
</ul>

<div class="row">
    <div class="span8">
    <?php if (!$this->request->is('Mobile') ): ?>    
        <div style="margin: -5px auto 0; width: 728px; height: 90px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
    <?php endif; ?>                
    </div>
</div>
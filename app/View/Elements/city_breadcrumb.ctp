<ul class="breadcrumb">
    <li><a href="/">Home</a> 
    </li> <span class="divider">/</span>
    <li>
    <?php if (isset( $cities['Province']['name'])): ?>
    <a href="/province/<?php echo $cities['Province']['slug']; ?>"><?php echo $cities['Province']['name']; ?></a></li> <span class="divider">/</span>    
    <?php endif; ?>
    <a href="/city/<?php echo $cities['City']['slug']; ?>"><?php echo $cities['City']['name']; ?></a></li> <span class="divider">/</span>
    <?php if (isset( $cities['CityRegion']['name'])): ?>
    <li><a href="/search/city_region:<?php echo $cities['CityRegion']['slug']; ?>"><?php echo $cities['CityRegion']['name']; ?></a></li>
    <span class="divider">/</span>
    <?php endif; ?>
    <?php if (isset( $cities['CityNeighbourhood']['name'])): ?>
    <li><a href="/search/city_neighbourhood:<?php echo $cities['CityNeighbourhood']['slug']; ?>"><?php echo $cities['CityNeighbourhood']['name']; ?></a></li>
    <span class="divider">/</span>
    <?php endif; ?>                
</ul>
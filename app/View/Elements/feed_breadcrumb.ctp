<?php // debug($post ) ?>

<?php 
switch ( $post['PostCategory']['slug'] ) {
    case 'venue_review':
        $categoryLink = '<a href="/posts/search/category:reviews/">Reviews</a>';
        $sectionLink = '<a href="/posts/search/category:venue_review/">Food &amp Fuel</a>';
        break;
    case 'book_review':
        $categoryLink = '<a href="/posts/search/category:reviews/">Reviews</a>';
        $sectionLink = '<a href="/posts/search/category:book_review/">Books</a>';
        break;     
    case 'store_review':
        $categoryLink = '<a href="/posts/search/category:reviews/">Reviews</a>';
        $sectionLink = '<a href="/posts/search/category:business_review/">Business</a>';
        break;          
    default:        
}

if ( isset($post['City']['slug']) && !empty($post['City']['slug'])) {
    $cityLink = '<a href="/posts/search/city:' . $post['City']['slug'] . '">' . $post['City']['name'] . '</a>';
}

?>

<ul class="breadcrumb">
    <li><a href="/">Home</a> 
    </li> <span class="divider">/</span>
    
        
    <li><a href="/posts/">The Feed</a> 
    </li> <span class="divider">/</span>
          
    <?php if (isset($categoryLink)): ?> 
    <li><?php echo $categoryLink; ?> 
    </li> <span class="divider">/</span>
    <?php endif; ?>

    <?php if (isset($sectionLink)): ?> 
    <li><?php echo $sectionLink; ?> 
    </li> <span class="divider">/</span>
    <?php endif; ?>
              

    <?php if (isset($cityLink)): ?> 
    <li><?php echo $cityLink; ?> 
    </li> <span class="divider">/</span>
    <?php endif; ?>
   
</ul>

            <div class="row">
                <div class="span8">
                <?php if (!$this->request->is('Mobile') ): ?>    
                    <div style="margin: 5px auto 18px; width: 728px; height: 90px; padding: 5px"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
<?php foreach ($links as $row): ?>  
        <url>
        <loc><?php echo $row['loc'] ?></loc>
        <lastmod><?php echo trim($this->Time->toAtom( $row['lastmod'])); ?></lastmod>
        <changefreq><?php echo $row['changefreq'] ?></changefreq>
        <priority><?php echo $row['priority'] ?></priority>
        </url>
<?php endforeach; ?>    
</urlset>
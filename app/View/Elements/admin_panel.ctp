<?php if ( isset($showAdminPanel) && ( $showAdminPanel == true ) ): ?>
<div class="container">
    <div class="span12">
        <?php if (isset($venue['Venue']['id']) ): ?>
        <a href="/admin/venues/edit/<?php echo $venue['Venue']['id'] ?>" target="blank"> Edit <?php echo $venue['Venue']['name'] ?></a>
        <?php endif; ?>
        <?php if (isset($post['Post']['id']) ): ?>
        <a href="/admin/posts/edit/<?php echo $post['Post']['id'] ?>" target="blank"> Edit <?php echo $post['Post']['name'] ?></a>
        <?php endif; ?>        
    </div>
</div>
<?php endif; ?>

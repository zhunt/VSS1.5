<div class="span4">

    <h3 class="frame invert" style="margin-bottom: 1em;">Related</h3>
<?php foreach( $relatedPosts as $id => $post): ?>
<div class="row">
    <div class="span4">
        <img src="/uploads/post/image_1/thumb/small/<?php echo $post['Post']['image_1']?>" class="" style="float: left; margin-right: 5px; margin-bottom: 1em;">

        <?php echo $this->Html->link( $post['Post']['name'],
            '/posts/' . $post['Post']['slug'], array('escape' => false) ) ?>
        <p><?php echo $post['Post']['dek'] ?></p>

    </div>
</div>
<?php endforeach; ?>

</div>
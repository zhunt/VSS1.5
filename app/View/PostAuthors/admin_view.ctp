<div class="postAuthors view">
<h2><?php  echo __('Post Author'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($postAuthor['PostAuthor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($postAuthor['PostAuthor']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Post Author'), array('action' => 'edit', $postAuthor['PostAuthor']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Post Author'), array('action' => 'delete', $postAuthor['PostAuthor']['id']), null, __('Are you sure you want to delete # %s?', $postAuthor['PostAuthor']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Authors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Author'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Posts'); ?></h3>
	<?php if (!empty($postAuthor['Post'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Feature Title'); ?></th>
		<th><?php echo __('Slug'); ?></th>
		<th><?php echo __('Dek'); ?></th>
		<th><?php echo __('Excerpt'); ?></th>
		<th><?php echo __('Tease Quote'); ?></th>
		<th><?php echo __('Seo Title'); ?></th>
		<th><?php echo __('Seo Desc'); ?></th>
		<th><?php echo __('Post'); ?></th>
		<th><?php echo __('Info Links'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Related Business Type Id'); ?></th>
		<th><?php echo __('Province Id'); ?></th>
		<th><?php echo __('Post Category Id'); ?></th>
		<th><?php echo __('Post Author Id'); ?></th>
		<th><?php echo __('Venue Id'); ?></th>
		<th><?php echo __('Publish State Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($postAuthor['Post'] as $post): ?>
		<tr>
			<td><?php echo $post['id']; ?></td>
			<td><?php echo $post['name']; ?></td>
			<td><?php echo $post['feature_title']; ?></td>
			<td><?php echo $post['slug']; ?></td>
			<td><?php echo $post['dek']; ?></td>
			<td><?php echo $post['excerpt']; ?></td>
			<td><?php echo $post['tease_quote']; ?></td>
			<td><?php echo $post['seo_title']; ?></td>
			<td><?php echo $post['seo_desc']; ?></td>
			<td><?php echo $post['post']; ?></td>
			<td><?php echo $post['info_links']; ?></td>
			<td><?php echo $post['category_id']; ?></td>
			<td><?php echo $post['related_business_type_id']; ?></td>
			<td><?php echo $post['province_id']; ?></td>
			<td><?php echo $post['post_category_id']; ?></td>
			<td><?php echo $post['post_author_id']; ?></td>
			<td><?php echo $post['venue_id']; ?></td>
			<td><?php echo $post['publish_state_id']; ?></td>
			<td><?php echo $post['created']; ?></td>
			<td><?php echo $post['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), null, __('Are you sure you want to delete # %s?', $post['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="postCategories view">
<h2><?php  echo __('Post Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($postCategory['PostCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($postCategory['PostCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($postCategory['PostCategory']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Post Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($postCategory['ParentPostCategory']['name'], array('controller' => 'post_categories', 'action' => 'view', $postCategory['ParentPostCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Count'); ?></dt>
		<dd>
			<?php echo h($postCategory['PostCategory']['post_count']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Post Category'), array('action' => 'edit', $postCategory['PostCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Post Category'), array('action' => 'delete', $postCategory['PostCategory']['id']), null, __('Are you sure you want to delete # %s?', $postCategory['PostCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Categories'), array('controller' => 'post_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Post Category'), array('controller' => 'post_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Post Categories'); ?></h3>
	<?php if (!empty($postCategory['ChildPostCategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Slug'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Post Count'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($postCategory['ChildPostCategory'] as $childPostCategory): ?>
		<tr>
			<td><?php echo $childPostCategory['id']; ?></td>
			<td><?php echo $childPostCategory['name']; ?></td>
			<td><?php echo $childPostCategory['slug']; ?></td>
			<td><?php echo $childPostCategory['parent_id']; ?></td>
			<td><?php echo $childPostCategory['post_count']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'post_categories', 'action' => 'view', $childPostCategory['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'post_categories', 'action' => 'edit', $childPostCategory['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'post_categories', 'action' => 'delete', $childPostCategory['id']), null, __('Are you sure you want to delete # %s?', $childPostCategory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Post Category'), array('controller' => 'post_categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Posts'); ?></h3>
	<?php if (!empty($postCategory['Post'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Sub Name'); ?></th>
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
		<th><?php echo __('City Id'); ?></th>
		<th><?php echo __('Image 1'); ?></th>
		<th><?php echo __('Image 2'); ?></th>
		<th><?php echo __('Image 3'); ?></th>
		<th><?php echo __('Image 4'); ?></th>
		<th><?php echo __('Image 5'); ?></th>
		<th><?php echo __('Image 6'); ?></th>
		<th><?php echo __('Image 1 Dir'); ?></th>
		<th><?php echo __('Image 1 Mimetype'); ?></th>
		<th><?php echo __('Image 1 Filesize'); ?></th>
		<th><?php echo __('Publish State Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($postCategory['Post'] as $post): ?>
		<tr>
			<td><?php echo $post['id']; ?></td>
			<td><?php echo $post['name']; ?></td>
			<td><?php echo $post['sub_name']; ?></td>
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
			<td><?php echo $post['city_id']; ?></td>
			<td><?php echo $post['image_1']; ?></td>
			<td><?php echo $post['image_2']; ?></td>
			<td><?php echo $post['image_3']; ?></td>
			<td><?php echo $post['image_4']; ?></td>
			<td><?php echo $post['image_5']; ?></td>
			<td><?php echo $post['image_6']; ?></td>
			<td><?php echo $post['image_1_dir']; ?></td>
			<td><?php echo $post['image_1_mimetype']; ?></td>
			<td><?php echo $post['image_1_filesize']; ?></td>
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

<div class="posts view">
<h2><?php  echo __('Post'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($post['Post']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Feature Title'); ?></dt>
		<dd>
			<?php echo h($post['Post']['feature_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($post['Post']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dek'); ?></dt>
		<dd>
			<?php echo h($post['Post']['dek']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Excerpt'); ?></dt>
		<dd>
			<?php echo h($post['Post']['excerpt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tease Quote'); ?></dt>
		<dd>
			<?php echo h($post['Post']['tease_quote']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Seo Title'); ?></dt>
		<dd>
			<?php echo h($post['Post']['seo_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Seo Desc'); ?></dt>
		<dd>
			<?php echo h($post['Post']['seo_desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post'); ?></dt>
		<dd>
			<?php echo h($post['Post']['post']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Info Links'); ?></dt>
		<dd>
			<?php echo h($post['Post']['info_links']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['category_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Related Business Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['RelatedBusinessType']['name'], array('controller' => 'business_types', 'action' => 'view', $post['RelatedBusinessType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Province'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['Province']['name'], array('controller' => 'provinces', 'action' => 'view', $post['Province']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['PostCategory']['name'], array('controller' => 'post_categories', 'action' => 'view', $post['PostCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Author'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['PostAuthor']['name'], array('controller' => 'post_authors', 'action' => 'view', $post['PostAuthor']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Venue'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['Venue']['name'], array('controller' => 'venues', 'action' => 'view', $post['Venue']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['City']['name'], array('controller' => 'cities', 'action' => 'view', $post['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image 1'); ?></dt>
		<dd>
			<?php echo h($post['Post']['image_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image 2'); ?></dt>
		<dd>
			<?php echo h($post['Post']['image_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image 3'); ?></dt>
		<dd>
			<?php echo h($post['Post']['image_3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image 4'); ?></dt>
		<dd>
			<?php echo h($post['Post']['image_4']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image 5'); ?></dt>
		<dd>
			<?php echo h($post['Post']['image_5']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image 6'); ?></dt>
		<dd>
			<?php echo h($post['Post']['image_6']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publish State'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['PublishState']['name'], array('controller' => 'publish_states', 'action' => 'view', $post['PublishState']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($post['Post']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($post['Post']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Post'), array('action' => 'edit', $post['Post']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Post'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Related Business Type'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Provinces'), array('controller' => 'provinces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Province'), array('controller' => 'provinces', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Categories'), array('controller' => 'post_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Category'), array('controller' => 'post_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Authors'), array('controller' => 'post_authors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Author'), array('controller' => 'post_authors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cities'), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Publish States'), array('controller' => 'publish_states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Publish State'), array('controller' => 'publish_states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Meta'), array('controller' => 'post_meta', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Metum'), array('controller' => 'post_meta', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Tags'), array('controller' => 'post_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Tag'), array('controller' => 'post_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Images'); ?></h3>
	<?php if (!empty($post['Image'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('File'); ?></th>
		<th><?php echo __('Dirname'); ?></th>
		<th><?php echo __('Basename'); ?></th>
		<th><?php echo __('Checksum'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Post Id'); ?></th>
		<th><?php echo __('Venue Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($post['Image'] as $image): ?>
		<tr>
			<td><?php echo $image['id']; ?></td>
			<td><?php echo $image['file']; ?></td>
			<td><?php echo $image['dirname']; ?></td>
			<td><?php echo $image['basename']; ?></td>
			<td><?php echo $image['checksum']; ?></td>
			<td><?php echo $image['created']; ?></td>
			<td><?php echo $image['modified']; ?></td>
			<td><?php echo $image['post_id']; ?></td>
			<td><?php echo $image['venue_id']; ?></td>
			<td><?php echo $image['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'images', 'action' => 'view', $image['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'images', 'action' => 'edit', $image['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'images', 'action' => 'delete', $image['id']), null, __('Are you sure you want to delete # %s?', $image['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Post Meta'); ?></h3>
	<?php if (!empty($post['PostMetum'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Key'); ?></th>
		<th><?php echo __('Post Id'); ?></th>
		<th><?php echo __('Venue Id'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($post['PostMetum'] as $postMetum): ?>
		<tr>
			<td><?php echo $postMetum['id']; ?></td>
			<td><?php echo $postMetum['key']; ?></td>
			<td><?php echo $postMetum['post_id']; ?></td>
			<td><?php echo $postMetum['venue_id']; ?></td>
			<td><?php echo $postMetum['value']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'post_meta', 'action' => 'view', $postMetum['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'post_meta', 'action' => 'edit', $postMetum['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'post_meta', 'action' => 'delete', $postMetum['id']), null, __('Are you sure you want to delete # %s?', $postMetum['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Post Metum'), array('controller' => 'post_meta', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Post Tags'); ?></h3>
	<?php if (!empty($post['PostTag'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Slug'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($post['PostTag'] as $postTag): ?>
		<tr>
			<td><?php echo $postTag['id']; ?></td>
			<td><?php echo $postTag['name']; ?></td>
			<td><?php echo $postTag['slug']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'post_tags', 'action' => 'view', $postTag['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'post_tags', 'action' => 'edit', $postTag['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'post_tags', 'action' => 'delete', $postTag['id']), null, __('Are you sure you want to delete # %s?', $postTag['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Post Tag'), array('controller' => 'post_tags', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

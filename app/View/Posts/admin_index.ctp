<div class="posts index">
	<h2><?php echo __('Posts'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			
			
			<th><?php echo $this->Paginator->sort('related_business_type_id'); ?></th>
			
			<th><?php echo $this->Paginator->sort('post_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('post_author_id'); ?></th>
			<th><?php echo $this->Paginator->sort('venue_id'); ?></th>
			<th><?php echo $this->Paginator->sort('city_id'); ?></th>

			<th><?php echo $this->Paginator->sort('publish_state_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($posts as $post): ?>
	<tr>
		<td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link( $post['Post']['name'] , array('action' => 'edit', $post['Post']['id'])); ?></td>
		
		<td>
			<?php echo $this->Html->link($post['RelatedBusinessType']['name'], array('controller' => 'business_types', 'action' => 'view', $post['RelatedBusinessType']['id'])); ?>
		</td>
		
		<td>
			<?php echo $this->Html->link($post['PostCategory']['name'], array('controller' => 'post_categories', 'action' => 'view', $post['PostCategory']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($post['PostAuthor']['name'], array('controller' => 'post_authors', 'action' => 'view', $post['PostAuthor']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($post['Venue']['name'], array('controller' => 'venues', 'action' => 'view', $post['Venue']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($post['City']['name'], array('controller' => 'cities', 'action' => 'view', $post['City']['id'])); ?>
		</td>

		<td>
			<?php echo $this->Html->link($post['PublishState']['name'], array('controller' => 'publish_states', 'action' => 'view', $post['PublishState']['id'])); ?>
		</td>
		<td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
			
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?></li>
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

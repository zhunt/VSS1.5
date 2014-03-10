<div class="maps index">
	<h2><?php echo __('Maps'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('seo_title'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($maps as $map): ?>
	<tr>
		<td><?php echo h($map['Map']['id']); ?>&nbsp;</td>
		<td><?php echo h($map['Map']['name']); ?>&nbsp;</td>
		<td><?php echo h($map['Map']['seo_title']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $map['Map']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $map['Map']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $map['Map']['id']), null, __('Are you sure you want to delete # %s?', $map['Map']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Map'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('controller' => 'map_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('controller' => 'map_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('controller' => 'map_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location'), array('controller' => 'map_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>

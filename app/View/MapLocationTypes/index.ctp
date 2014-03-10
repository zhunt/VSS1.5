<div class="mapLocationTypes index">
	<h2><?php echo __('Map Location Types'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('map_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($mapLocationTypes as $mapLocationType): ?>
	<tr>
		<td><?php echo h($mapLocationType['MapLocationType']['id']); ?>&nbsp;</td>
		<td><?php echo h($mapLocationType['MapLocationType']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mapLocationType['Map']['name'], array('controller' => 'maps', 'action' => 'view', $mapLocationType['Map']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $mapLocationType['MapLocationType']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $mapLocationType['MapLocationType']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $mapLocationType['MapLocationType']['id']), null, __('Are you sure you want to delete # %s?', $mapLocationType['MapLocationType']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('controller' => 'map_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location'), array('controller' => 'map_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>

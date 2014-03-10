<div class="mapLocations index">
	<h2><?php echo __('Map Locations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('geo_lat'); ?></th>
			<th><?php echo $this->Paginator->sort('geo_lng'); ?></th>
			<th><?php echo $this->Paginator->sort('venue_id'); ?></th>
			<th><?php echo $this->Paginator->sort('phone_1'); ?></th>
			<th><?php echo $this->Paginator->sort('map_location_type_id'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_sun'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_mon'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_tue'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_wed'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_thu'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_fri'); ?></th>
			<th><?php echo $this->Paginator->sort('hours_sat'); ?></th>
			<th><?php echo $this->Paginator->sort('notes'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($mapLocations as $mapLocation): ?>
	<tr>
		<td><?php echo h($mapLocation['MapLocation']['id']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['name']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['geo_lat']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['geo_lng']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mapLocation['Venue']['name'], array('controller' => 'venues', 'action' => 'view', $mapLocation['Venue']['id'])); ?>
		</td>
		<td><?php echo h($mapLocation['MapLocation']['phone_1']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mapLocation['MapLocationType']['name'], array('controller' => 'map_location_types', 'action' => 'view', $mapLocation['MapLocationType']['id'])); ?>
		</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_sun']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_mon']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_tue']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_wed']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_thu']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_fri']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['hours_sat']); ?>&nbsp;</td>
		<td><?php echo h($mapLocation['MapLocation']['notes']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $mapLocation['MapLocation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $mapLocation['MapLocation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $mapLocation['MapLocation']['id']), null, __('Are you sure you want to delete # %s?', $mapLocation['MapLocation']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Map Location'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('controller' => 'map_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('controller' => 'map_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
	</ul>
</div>

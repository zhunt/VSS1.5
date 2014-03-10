<div class="mapLocationTypes view">
<h2><?php  echo __('Map Location Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mapLocationType['MapLocationType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mapLocationType['MapLocationType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Map'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mapLocationType['Map']['name'], array('controller' => 'maps', 'action' => 'view', $mapLocationType['Map']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Map Location Type'), array('action' => 'edit', $mapLocationType['MapLocationType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Map Location Type'), array('action' => 'delete', $mapLocationType['MapLocationType']['id']), null, __('Are you sure you want to delete # %s?', $mapLocationType['MapLocationType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('controller' => 'map_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location'), array('controller' => 'map_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Map Locations'); ?></h3>
	<?php if (!empty($mapLocationType['MapLocation'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Geo Lat'); ?></th>
		<th><?php echo __('Geo Lng'); ?></th>
		<th><?php echo __('Venue Id'); ?></th>
		<th><?php echo __('Phone 1'); ?></th>
		<th><?php echo __('Map Location Type Id'); ?></th>
		<th><?php echo __('Hours Sun'); ?></th>
		<th><?php echo __('Hours Mon'); ?></th>
		<th><?php echo __('Hours Tue'); ?></th>
		<th><?php echo __('Hours Wed'); ?></th>
		<th><?php echo __('Hours Thu'); ?></th>
		<th><?php echo __('Hours Fri'); ?></th>
		<th><?php echo __('Hours Sat'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mapLocationType['MapLocation'] as $mapLocation): ?>
		<tr>
			<td><?php echo $mapLocation['id']; ?></td>
			<td><?php echo $mapLocation['name']; ?></td>
			<td><?php echo $mapLocation['geo_lat']; ?></td>
			<td><?php echo $mapLocation['geo_lng']; ?></td>
			<td><?php echo $mapLocation['venue_id']; ?></td>
			<td><?php echo $mapLocation['phone_1']; ?></td>
			<td><?php echo $mapLocation['map_location_type_id']; ?></td>
			<td><?php echo $mapLocation['hours_sun']; ?></td>
			<td><?php echo $mapLocation['hours_mon']; ?></td>
			<td><?php echo $mapLocation['hours_tue']; ?></td>
			<td><?php echo $mapLocation['hours_wed']; ?></td>
			<td><?php echo $mapLocation['hours_thu']; ?></td>
			<td><?php echo $mapLocation['hours_fri']; ?></td>
			<td><?php echo $mapLocation['hours_sat']; ?></td>
			<td><?php echo $mapLocation['notes']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'map_locations', 'action' => 'view', $mapLocation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'map_locations', 'action' => 'edit', $mapLocation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'map_locations', 'action' => 'delete', $mapLocation['id']), null, __('Are you sure you want to delete # %s?', $mapLocation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Map Location'), array('controller' => 'map_locations', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

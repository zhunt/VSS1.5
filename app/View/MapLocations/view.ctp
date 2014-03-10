<div class="mapLocations view">
<h2><?php  echo __('Map Location'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Geo Lat'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['geo_lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Geo Lng'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['geo_lng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Venue'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mapLocation['Venue']['name'], array('controller' => 'venues', 'action' => 'view', $mapLocation['Venue']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone 1'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['phone_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Map Location Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mapLocation['MapLocationType']['name'], array('controller' => 'map_location_types', 'action' => 'view', $mapLocation['MapLocationType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Sun'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_sun']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Mon'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_mon']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Tue'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_tue']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Wed'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_wed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Thu'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_thu']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Fri'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_fri']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Sat'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['hours_sat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($mapLocation['MapLocation']['notes']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Map Location'), array('action' => 'edit', $mapLocation['MapLocation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Map Location'), array('action' => 'delete', $mapLocation['MapLocation']['id']), null, __('Are you sure you want to delete # %s?', $mapLocation['MapLocation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('controller' => 'map_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('controller' => 'map_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Maps'); ?></h3>
	<?php if (!empty($mapLocation['Map'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Seo Title'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mapLocation['Map'] as $map): ?>
		<tr>
			<td><?php echo $map['id']; ?></td>
			<td><?php echo $map['name']; ?></td>
			<td><?php echo $map['seo_title']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'maps', 'action' => 'view', $map['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'maps', 'action' => 'edit', $map['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'maps', 'action' => 'delete', $map['id']), null, __('Are you sure you want to delete # %s?', $map['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

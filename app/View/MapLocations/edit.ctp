<div class="mapLocations form">
<?php echo $this->Form->create('MapLocation'); ?>
	<fieldset>
		<legend><?php echo __('Edit Map Location'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('geo_lat');
		echo $this->Form->input('geo_lng');
		echo $this->Form->input('venue_id');
		echo $this->Form->input('phone_1');
		echo $this->Form->input('map_location_type_id');
		echo $this->Form->input('hours_sun');
		echo $this->Form->input('hours_mon');
		echo $this->Form->input('hours_tue');
		echo $this->Form->input('hours_wed');
		echo $this->Form->input('hours_thu');
		echo $this->Form->input('hours_fri');
		echo $this->Form->input('hours_sat');
		echo $this->Form->input('notes');
		echo $this->Form->input('Map');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MapLocation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('MapLocation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('controller' => 'map_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('controller' => 'map_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
	</ul>
</div>

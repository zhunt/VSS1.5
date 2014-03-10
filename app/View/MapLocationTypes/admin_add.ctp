<div class="mapLocationTypes form">
<?php echo $this->Form->create('MapLocationType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Map Location Type'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('map_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Map Location Types'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Maps'), array('controller' => 'maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map'), array('controller' => 'maps', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('controller' => 'map_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location'), array('controller' => 'map_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>

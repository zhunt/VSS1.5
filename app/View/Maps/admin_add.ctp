<div class="maps form">
<?php echo $this->Form->create('Map'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Map'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('seo_title');
		echo $this->Form->input('MapLocation');
                
                echo $this->Form->input('city_id', array('empty' => true) );
                echo $this->Form->input('province_id', array('empty' => true) );                  
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Maps'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Map Location Types'), array('controller' => 'map_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location Type'), array('controller' => 'map_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Map Locations'), array('controller' => 'map_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Map Location'), array('controller' => 'map_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>

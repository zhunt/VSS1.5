<div class="venueFeatures form">
<?php echo $this->Form->create('VenueFeature');?>
	<fieldset>
		<legend><?php echo __('Admin Add Venue Feature'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('business_type_id');
		echo $this->Form->input('group');
		echo $this->Form->input('Venue');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Venue Features'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Type'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
	</ul>
</div>

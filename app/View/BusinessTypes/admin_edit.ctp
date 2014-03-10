<div class="businessTypes form">
<?php echo $this->Form->create('BusinessType');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Business Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('slug');
		echo $this->Form->input('flag_show');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BusinessType.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('BusinessType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Venue Features'), array('controller' => 'venue_features', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue Feature'), array('controller' => 'venue_features', 'action' => 'add')); ?> </li>
	</ul>
</div>

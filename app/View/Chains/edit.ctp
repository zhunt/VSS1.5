<div class="chains form">
<?php echo $this->Form->create('Chain');?>
	<fieldset>
		<legend><?php echo __('Edit Chain'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Chain.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Chain.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Chains'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
	</ul>
</div>

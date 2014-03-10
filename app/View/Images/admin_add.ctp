<div class="images form">
<?php echo $this->Form->create('Image', array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Image'); ?></legend>
	<?php
		echo $this->Form->input('file', array('type'=>'file'));
		echo $this->Form->input('dirname');
		echo $this->Form->input('basename');
		echo $this->Form->input('checksum');
		echo $this->Form->input('post_id', array('empty' => true ));
		echo $this->Form->input('venue_id', array('empty' => true ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
	</ul>
</div>

<!--
echo $this->Form->create('User', array('type'=>'file'));
echo $this->Form->input('file', array('type'=>'file'));
echo $this->Form->input('dirname', array('type'=>'hidden'));
echo $this->Form->input('basename', array('type'=>'hidden'));
echo $this->Form->input('checksum', array('type'=>'hidden'));
echo $this->Form->end(__('Submit'));
-->
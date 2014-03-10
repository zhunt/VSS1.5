<div class="postAuthors form">
<?php echo $this->Form->create('PostAuthor'); ?>
	<fieldset>
		<legend><?php echo __('Edit Post Author'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PostAuthor.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('PostAuthor.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Post Authors'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
	</ul>
</div>

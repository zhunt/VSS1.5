<div class="postCategories form">
<?php echo $this->Form->create('PostCategory'); ?>
	<fieldset>
		<legend><?php echo __('Add Post Category'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('slug');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('post_count');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Post Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Post Categories'), array('controller' => 'post_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Post Category'), array('controller' => 'post_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
	</ul>
</div>

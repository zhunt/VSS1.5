<div class="venueFeatures index">
	<h2><?php echo __('Venue Features');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('business_type_id');?></th>
			<th><?php echo $this->Paginator->sort('group');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($venueFeatures as $venueFeature): ?>
	<tr>
		<td><?php echo h($venueFeature['VenueFeature']['id']); ?>&nbsp;</td>
		<td><?php echo h($venueFeature['VenueFeature']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($venueFeature['BusinessType']['name'], array('controller' => 'business_types', 'action' => 'view', $venueFeature['BusinessType']['id'])); ?>
		</td>
		<td><?php echo h($venueFeature['VenueFeature']['group']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $venueFeature['VenueFeature']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $venueFeature['VenueFeature']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $venueFeature['VenueFeature']['id']), null, __('Are you sure you want to delete # %s?', $venueFeature['VenueFeature']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Venue Feature'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Type'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
	</ul>
</div>

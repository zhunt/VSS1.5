<div class="businessTypes view">
<h2><?php  echo __('Business Type');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($businessType['BusinessType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($businessType['BusinessType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($businessType['BusinessType']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Flag Show'); ?></dt>
		<dd>
			<?php echo h($businessType['BusinessType']['flag_show']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Business Type'), array('action' => 'edit', $businessType['BusinessType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Business Type'), array('action' => 'delete', $businessType['BusinessType']['id']), null, __('Are you sure you want to delete # %s?', $businessType['BusinessType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venue Features'), array('controller' => 'venue_features', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue Feature'), array('controller' => 'venue_features', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Venue Features');?></h3>
	<?php if (!empty($businessType['VenueFeature'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Business Type Id'); ?></th>
		<th><?php echo __('Group'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($businessType['VenueFeature'] as $venueFeature): ?>
		<tr>
			<td><?php echo $venueFeature['id'];?></td>
			<td><?php echo $venueFeature['name'];?></td>
			<td><?php echo $venueFeature['business_type_id'];?></td>
			<td><?php echo $venueFeature['group'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'venue_features', 'action' => 'view', $venueFeature['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'venue_features', 'action' => 'edit', $venueFeature['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'venue_features', 'action' => 'delete', $venueFeature['id']), null, __('Are you sure you want to delete # %s?', $venueFeature['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Venue Feature'), array('controller' => 'venue_features', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

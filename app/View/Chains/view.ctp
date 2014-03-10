<div class="chains view">
<h2><?php  echo __('Chain');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($chain['Chain']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($chain['Chain']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Chain'), array('action' => 'edit', $chain['Chain']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Chain'), array('action' => 'delete', $chain['Chain']['id']), null, __('Are you sure you want to delete # %s?', $chain['Chain']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Chains'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Chain'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Venues');?></h3>
	<?php if (!empty($chain['Venue'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Slug'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('City Id'); ?></th>
		<th><?php echo __('Province Id'); ?></th>
		<th><?php echo __('Postal Code'); ?></th>
		<th><?php echo __('Geo Lat'); ?></th>
		<th><?php echo __('Geo Lng'); ?></th>
		<th><?php echo __('Phone 1'); ?></th>
		<th><?php echo __('Phone 2'); ?></th>
		<th><?php echo __('Website Url'); ?></th>
		<th><?php echo __('Social 1 Url'); ?></th>
		<th><?php echo __('Social 2 Url'); ?></th>
		<th><?php echo __('Hours Sun'); ?></th>
		<th><?php echo __('Hours Mon'); ?></th>
		<th><?php echo __('Hours Tue'); ?></th>
		<th><?php echo __('Hours Wed'); ?></th>
		<th><?php echo __('Hours Thu'); ?></th>
		<th><?php echo __('Hours Fri'); ?></th>
		<th><?php echo __('Hours Sat'); ?></th>
		<th><?php echo __('Business Type 1 Id'); ?></th>
		<th><?php echo __('Business Type 2 Id'); ?></th>
		<th><?php echo __('Chain Id'); ?></th>
		<th><?php echo __('Seo Title'); ?></th>
		<th><?php echo __('Seo Desc'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Publish State Id'); ?></th>
		<th><?php echo __('Modifed'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($chain['Venue'] as $venue): ?>
		<tr>
			<td><?php echo $venue['id'];?></td>
			<td><?php echo $venue['name'];?></td>
			<td><?php echo $venue['slug'];?></td>
			<td><?php echo $venue['address'];?></td>
			<td><?php echo $venue['city'];?></td>
			<td><?php echo $venue['city_id'];?></td>
			<td><?php echo $venue['province_id'];?></td>
			<td><?php echo $venue['postal_code'];?></td>
			<td><?php echo $venue['geo_lat'];?></td>
			<td><?php echo $venue['geo_lng'];?></td>
			<td><?php echo $venue['phone_1'];?></td>
			<td><?php echo $venue['phone_2'];?></td>
			<td><?php echo $venue['website_url'];?></td>
			<td><?php echo $venue['social_1_url'];?></td>
			<td><?php echo $venue['social_2_url'];?></td>
			<td><?php echo $venue['hours_sun'];?></td>
			<td><?php echo $venue['hours_mon'];?></td>
			<td><?php echo $venue['hours_tue'];?></td>
			<td><?php echo $venue['hours_wed'];?></td>
			<td><?php echo $venue['hours_thu'];?></td>
			<td><?php echo $venue['hours_fri'];?></td>
			<td><?php echo $venue['hours_sat'];?></td>
			<td><?php echo $venue['business_type_1_id'];?></td>
			<td><?php echo $venue['business_type_2_id'];?></td>
			<td><?php echo $venue['chain_id'];?></td>
			<td><?php echo $venue['seo_title'];?></td>
			<td><?php echo $venue['seo_desc'];?></td>
			<td><?php echo $venue['notes'];?></td>
			<td><?php echo $venue['description'];?></td>
			<td><?php echo $venue['publish_state_id'];?></td>
			<td><?php echo $venue['modifed'];?></td>
			<td><?php echo $venue['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'venues', 'action' => 'view', $venue['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'venues', 'action' => 'edit', $venue['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'venues', 'action' => 'delete', $venue['id']), null, __('Are you sure you want to delete # %s?', $venue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

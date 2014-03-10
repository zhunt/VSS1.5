<div class="venues index">
	<h2><?php echo __('Venues');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('slug');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('city_id');?></th>
			<th><?php echo $this->Paginator->sort('province_id');?></th>
			<th><?php echo $this->Paginator->sort('postal_code');?></th>
			<th><?php echo $this->Paginator->sort('geo_lat');?></th>
			<th><?php echo $this->Paginator->sort('geo_lng');?></th>
			<th><?php echo $this->Paginator->sort('phone_1');?></th>
			<th><?php echo $this->Paginator->sort('phone_2');?></th>
			<th><?php echo $this->Paginator->sort('website_url');?></th>
			<th><?php echo $this->Paginator->sort('social_1_url');?></th>
			<th><?php echo $this->Paginator->sort('social_2_url');?></th>
			<th><?php echo $this->Paginator->sort('hours_sun');?></th>
			<th><?php echo $this->Paginator->sort('hours_mon');?></th>
			<th><?php echo $this->Paginator->sort('hours_tue');?></th>
			<th><?php echo $this->Paginator->sort('hours_wed');?></th>
			<th><?php echo $this->Paginator->sort('hours_thu');?></th>
			<th><?php echo $this->Paginator->sort('hours_fri');?></th>
			<th><?php echo $this->Paginator->sort('hours_sat');?></th>
			<th><?php echo $this->Paginator->sort('business_type_1_id');?></th>
			<th><?php echo $this->Paginator->sort('business_type_2_id');?></th>
			<th><?php echo $this->Paginator->sort('chain_id');?></th>
			<th><?php echo $this->Paginator->sort('seo_title');?></th>
			<th><?php echo $this->Paginator->sort('seo_desc');?></th>
			<th><?php echo $this->Paginator->sort('notes');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('publish_state_id');?></th>
			<th><?php echo $this->Paginator->sort('modifed');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($venues as $venue): ?>
	<tr>
		<td><?php echo h($venue['Venue']['id']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['name']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['slug']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['address']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['city']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($venue['City']['name'], array('controller' => 'cities', 'action' => 'view', $venue['City']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($venue['Province']['name'], array('controller' => 'provinces', 'action' => 'view', $venue['Province']['id'])); ?>
		</td>
		<td><?php echo h($venue['Venue']['postal_code']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['geo_lat']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['geo_lng']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['phone_1']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['phone_2']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['website_url']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['social_1_url']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['social_2_url']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_sun']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_mon']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_tue']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_wed']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_thu']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_fri']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['hours_sat']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($venue['BusinessType1']['name'], array('controller' => 'business_types', 'action' => 'view', $venue['BusinessType1']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($venue['BusinessType2']['name'], array('controller' => 'business_types', 'action' => 'view', $venue['BusinessType2']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($venue['Chain']['name'], array('controller' => 'chains', 'action' => 'view', $venue['Chain']['id'])); ?>
		</td>
		<td><?php echo h($venue['Venue']['seo_title']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['seo_desc']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['notes']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['description']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($venue['PublishState']['name'], array('controller' => 'publish_states', 'action' => 'view', $venue['PublishState']['id'])); ?>
		</td>
		<td><?php echo h($venue['Venue']['modifed']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $venue['Venue']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $venue['Venue']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $venue['Venue']['id']), null, __('Are you sure you want to delete # %s?', $venue['Venue']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Venue'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cities'), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Provinces'), array('controller' => 'provinces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Province'), array('controller' => 'provinces', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Type1'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Chains'), array('controller' => 'chains', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Chain'), array('controller' => 'chains', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Publish States'), array('controller' => 'publish_states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Publish State'), array('controller' => 'publish_states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venue Features'), array('controller' => 'venue_features', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue Feature'), array('controller' => 'venue_features', 'action' => 'add')); ?> </li>
	</ul>
</div>

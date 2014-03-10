<div class="venues view">
<h2><?php  echo __('Venue');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($venue['City']['name'], array('controller' => 'cities', 'action' => 'view', $venue['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Province'); ?></dt>
		<dd>
			<?php echo $this->Html->link($venue['Province']['name'], array('controller' => 'provinces', 'action' => 'view', $venue['Province']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Geo Lat'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['geo_lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Geo Lng'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['geo_lng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone 1'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['phone_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone 2'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['phone_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website Url'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['website_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Social 1 Url'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['social_1_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Social 2 Url'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['social_2_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Sun'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_sun']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Mon'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_mon']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Tue'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_tue']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Wed'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_wed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Thu'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_thu']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Fri'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_fri']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours Sat'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['hours_sat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Type1'); ?></dt>
		<dd>
			<?php echo $this->Html->link($venue['BusinessType1']['name'], array('controller' => 'business_types', 'action' => 'view', $venue['BusinessType1']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Type2'); ?></dt>
		<dd>
			<?php echo $this->Html->link($venue['BusinessType2']['name'], array('controller' => 'business_types', 'action' => 'view', $venue['BusinessType2']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Chain'); ?></dt>
		<dd>
			<?php echo $this->Html->link($venue['Chain']['name'], array('controller' => 'chains', 'action' => 'view', $venue['Chain']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Seo Title'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['seo_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Seo Desc'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['seo_desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publish State'); ?></dt>
		<dd>
			<?php echo $this->Html->link($venue['PublishState']['name'], array('controller' => 'publish_states', 'action' => 'view', $venue['PublishState']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifed'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['modifed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Venue'), array('action' => 'edit', $venue['Venue']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Venue'), array('action' => 'delete', $venue['Venue']['id']), null, __('Are you sure you want to delete # %s?', $venue['Venue']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Venue Features');?></h3>
	<?php if (!empty($venue['VenueFeature'])):?>
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
		foreach ($venue['VenueFeature'] as $venueFeature): ?>
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

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            
            <div class="page-header">
                <h3>Somerville City</h3>
                <h1><?php echo h($venue['Venue']['name']); ?> <small>Computer Store</small></h1>
            </div>

           <img alt="" src="http://maps.google.com/maps/api/staticmap?center=43.677949,-79.458122&zoom=14&markers=label:A|43.677949,-79.458122&size=740x280&sensor=false">

           <?php // echo $this->Advert->displayAd('landscape', $centre = false); ?>  
           
           <div class="row">
            <div class="span4">
                <p>NCIX is a computer shop on 64th Ave. north of the Langley Bypass. in Langley, BC. 
                NCIX sells a wide range of laptops, computers, pc parts, accessories, and build custom computer systems.</p>

            </div>
            <div class="span4">
                <h4>Products</h4>
                    <a href="#">Computer Accessories</a>
                   <a href="#">Computer systems</a>
                    <a href="#">PC Components</a>
                    <a href="#">Security Systems / Parts</a>

                <h4>Services</h4>
                        <a href="#">Computer rentals</a>
                        <a href="#">Custom-built computer systems</a>
                        <a href="#">Linux support</a>
                        <a href="#">Online Computer Store</a>
                       <a href="#">PC Repair</a>

            </div>
           </div>
           
           <div class="page-header">
           <div class="span8">    
               <h4>Business Hours</h4>
           <div class="row">
               <table class="table table-striped table-bordered table-condensed hidden-phone">
                   <thead>
                       <tr>
                           <td><b>Sun.</b></td>
                           <td>Mon.</td>
                           <td>Tues.</td>
                           <td>Wed.</td>
                           <td>Thurs.</td>
                           <td>Fri.</td>
                           <td>Sat.</td>
                           
                       </tr>
                   </thead>
                   <tbody>
                       <tr>
                           <td>Closed</td>
                           <td>9:30am - 6:00pm</td>
                           <td>9:30am - 6:00pm</td>
                           <td>9:30am - 6:00pm</td>
                           <td>9:30am - 6:00pm</td>
                           <td>9:30am - 6:00pm</td>
                           <td>10:30am - 5:00pm</td>                               
                       </tr>
                   </tbody>
               </table>
           </div>
           </div>
           </div>    
        
        </div>
        
        
        
        <div class="span4" style="">
            <!-- Right Col. -->
            <?php //echo $this->Advert->displayAd('box300', $centre = true ); ?>

        </div>
    </div>

</div>

        <?php /* echo $this->Html->scriptBlock(
                    '$(".carousel").carousel({interval: 2000});',
                    array('inline' => false)); 
         */
        ?>
<!--

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
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publish State Id'); ?></dt>
		<dd>
			<?php echo h($venue['Venue']['publish_state_id']); ?>
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
		<li><?php echo $this->Html->link(__('List Provinces'), array('controller' => 'provinces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Province'), array('controller' => 'provinces', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Type1'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Publish States'), array('controller' => 'publish_states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Publish State'), array('controller' => 'publish_states', 'action' => 'add')); ?> </li>
	</ul>
</div>

-->
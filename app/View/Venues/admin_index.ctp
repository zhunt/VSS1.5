<link rel="stylesheet" href="/css/base/jquery.ui.all.css">
<link rel="stylesheet" href="/css/base/jquery.ui.theme.css">
<link rel="stylesheet" href="/css/jqueryui/jquery-ui-1.8.21.custom.css">
<style type="text/css">
	.ui-dialog { position: fixed;}
</style>



<div class="venues index">
    
    <a href="#" id="link_scratch_pad">Show Scratch-Pad</a>
    
    
		<?php echo $this->Form->create(null, array( 'url' => array('controller' => 'locations', 'action' => 'encode_address') ) );
			echo $this->Form->input('name', array('div' => false) );
			echo $this->Form->input('raw_address', array('class' => 'longfield', 'div' => false ) );
			echo $this->Form->input('phone', array( 'div' => false, 'id' => 'VenuePhone' ) );
                        echo $this->Form->input('website', array( 'div' => false, 'id' => 'VenuePhone' ) );
			echo $this->Form->end('Encode');
		?>
    
	<h2><?php echo __('Venues');?></h2>
         <!-- -->
        
        <script>
            
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){
    $('#VenuePhone').mask("999.999.9999? x99999");
});
<?php $this->Html->scriptEnd(); ?>        
        </script>
            
        
        
        <!-- -->
	<table cellpadding="0" cellspacing="0">
            <?php echo $this->Form->create( array( 'url' => array('controller' => 'venues', 'action' => 'index', 'new_filter') ) ); ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $this->Form->input('city_id', array('empty' => true, 'options' => $cities ) ); ?></td>
                <td><?php echo $this->Form->input('province_id', array('empty' => true, 'options' => $provinces ) ); ?></td>
                <td></td>
                <td><?php echo $this->Form->input('business_type_id', array('empty' => true, 'options' => $businessTypes ) ); ?></td>
                <td><?php echo $this->Form->input('chain_id', array('empty' => true, 'options' => $chains ) ); ?></td>
                
               
                <td><?php echo $this->Form->end('Go') ?></td>
            </tr>  
            
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('city_id');?></th>
			<th><?php echo $this->Paginator->sort('province_id');?></th>
			<th><?php echo $this->Paginator->sort('publish_state_id', 'Published');?></th>
			<th><?php echo $this->Paginator->sort('business_type_1_id', 'Business Type');?></th>
			<th><?php echo $this->Paginator->sort('chain_id');?></th>			
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($venues as $venue): ?>
	<tr>
		<td><?php echo h($venue['Venue']['id']); ?>&nbsp;</td>
		<td> <?php echo $this->Html->link( $venue['Venue']['name'] , array('action' => 'edit', $venue['Venue']['id'])); ?></td>
		<td><?php echo h($venue['Venue']['address']); ?>&nbsp;</td>
		<td><?php echo h($venue['City']['name']); ?>&nbsp;</td>
		<td>
		<?php echo $this->Html->link($venue['Province']['name'], array('controller' => 'provinces', 'action' => 'view', $venue['Province']['id'])); ?>
		</td>
                <td>
		<?php echo ( $venue['Venue']['publish_state_id'] == VENUE_PUBLISHED) ? 'X' : ' '; ?>
		</td>
		<td>
		<?php echo $this->Html->link($venue['BusinessType1']['name'], array('controller' => 'business_types', 'action' => 'view', $venue['BusinessType1']['id'])); ?>
		</td>
		<td>
		<?php echo $this->Html->link($venue['Chain']['name'], array('controller' => 'chains', 'action' => 'view', $venue['Chain']['id'])); ?>
		</td>
		
		<td><?php echo h($venue['Venue']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('Multi-Clone' , '#', array('class' => 'link_multi_clone_venue', 'name' => $venue['Venue']['id'] ) ); ?>
			<?php echo $this->Html->link('Clone' , '#', array('class' => 'link_clone_venue', 'name' => $venue['Venue']['id'] ) ); //array('action'=>'clone_venue', $venue['Venue']['id'])); ?>
			<?php echo $this->Html->link('Clone Import' , '#', array('class' => 'link_clone_import_venue', 'name' => $venue['Venue']['id'] ) ); ?>
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

<!-- Dialogs, etc. -->
<div class="jqueryui">
    <div id="dialog-message" title="Scratch-Pad">
	<textarea cols="75" rows="10"></textarea>
    </div>
</div>   

<?php 
/*
 * Set-up venue clone link 
 */

echo $this->Html->script( array('/js/jquery.maskedinput-1.3.min.js'), array('inline' => false) );
echo $this->Html->scriptBlock("
    
    // dialog scratch-pad:
    $('#link_scratch_pad').click(function() { $('#dialog-message').dialog('open'); return false} );
        
    $('#dialog-message').dialog({
                    modal: false,
                    autoOpen: false,
                    width: 'auto',
                    height: 'auto',
                    buttons: {
                            Ok: function() {
                                    $(this).dialog('close');
                            }
                    }
            });   
            
	// clone venue
	$('.link_clone_venue').click(function() { 
                

		var address = prompt('Enter address of new location', '');
		venueId = $(this).attr('name');
		
		if ( address == '' ) {
                    alert('Enter an address');
                    return false;
		}
		
		if ( address != '' && address != null ) {
                    url = '/admin/venues/clone_venue/?venueId=' + venueId +'&address=' + encodeURI(address);
                    window.location.href = url;
		}
		
	});
        // multi-clone
        $('.link_multi_clone_venue').click(function() { 
            venueId = $(this).attr('name'); console.log(venueId);
            if ( venueId ) {
                url = '/admin/venues/multi_clone_venue/?venueId=' + venueId;
                window.location.href = url;
            }   
            return false;
        });
        
        //link_clone_import_venue
        $('.link_clone_import_venue').click(function() { 
            venueId = $(this).attr('name'); console.log(venueId);
            if ( venueId ) {
                url = '/admin/venues/import_clone_venue/?venueId=' + venueId;
                window.location.href = url;
            }   
            return false;
        });        

", array('inline' => false) ); ?>


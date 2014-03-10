<?php
/*
 * Products index page
 */

// $this->Paginator->options(array('url' =>  $this->request->query));

$url = $this->params['url'];

    unset($url['url']);
    if(isset($this->request->data) && !empty($this->request->data)) {
        foreach($this->request->data[$model_name] as $key=>$value)
            $url[$key] = $value;
    }
    $get_var = http_build_query($url);

    $arg1 = array();
    $arg2 = array();
    //take the named url
    if(!empty($this->params['named']))
        $arg1 = $this->params['named'];

    //take the pass arguments
    if(!empty($this->params['pass']))
        $arg2 = $this->params['pass'];

    //merge named and pass
    $args = array_merge($arg1,$arg2);

    //add get variables
    $args["?"] = $get_var;
    $this->Paginator->options(array('url' =>  $args));
    
?>

<?php echo $this->element('header'); ?>

<div class="container"> 
    <div class="row" >
        <div class="span8">
            <h1 style="margin-bottom: .25em">Newest Book, Comics and Magazine Stores</h1>

            <!-- -->
            <?php foreach ($venues as $venue): ?>
            <div class="row">
                <div class="span5">
                    <h3><?php echo $venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name'] ; ?></h3>
                    <h4><?php echo $venue['Venue']['address']; ?>, <?php echo $venue['City']['name']; ?> </h4>
                </div>
               
                <div class="span3">
                    <h4><?php echo $venue['BusinessType1']['name']; ?></h4>
                </div >               
               
                
            </div>
            <div class="row">
                <div class="span8">
                    <hr>
                </div>
                
            </div>
            <?php endforeach; ?>
            <!-- -->
            
        </div>
 
        <div class="span4"> <!-- Right column --->
            <div class="row">
                <div class="span4 border_frame">
                <?php if (!$this->request->is('Mobile') ) :?>    
                    <div class="right_adbox"><?php echo $this->Advert->displayAd('box336'); ?></div>
                <?php else: ?>
                    <div style="margin:5px auto 0; width: 350px; padding: 0"><?php echo $this->Advert->displayAd('landscape'); ?></div>
                <?php endif; ?>                
                </div>
            </div>
                               
        </div>        

                               
        </div>
    </div>
   
</div>

<div class="container" style="background-color: #333">
    <?php echo $this->element('footer'); ?>
    
</div>


<!-- -->

	<h2><?php echo __('Venues');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('slug');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>

			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php foreach ($venues as $venue): ?>
	<tr>
		<td><?php echo h($venue['Venue']['id']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['name']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['slug']); ?>&nbsp;</td>
		<td><?php echo h($venue['Venue']['address']); ?>&nbsp;</td>
		<td><?php echo h($venue['City']['name']); ?>&nbsp;</td>
		
		
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
       
      // $this->Paginator->options(array('url' => array('controller' => 'venue_features', 'action' => 'products_index') ));
        
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('controller' => 'product'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array('controller' => 'product'), null, array('class' => 'next disabled'));
                
	?>
	</div>


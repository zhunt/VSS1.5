<div class="posts form">
<?php echo $this->Form->create('Post', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Post'); ?></legend>
	<?php
		//echo $this->Form->input('id');
		echo $this->Form->input('name');
                echo $this->Form->input('sub_name');
		echo $this->Form->input('feature_title');
		echo $this->Form->input('slug');
		echo $this->Form->input('dek');
		echo $this->Form->input('excerpt');
		echo $this->Form->input('tease_quote');
		echo $this->Form->input('seo_title');
		echo $this->Form->input('seo_desc');
		echo $this->Form->input('post', array('rows' => 20) );
		echo $this->Form->input('info_links');
		
		echo $this->Form->input('related_business_type_id', array('empty' => true ) );
		
		echo $this->Form->input('post_category_id');
		echo $this->Form->input('post_author_id');
                
		echo $this->Form->input('venue_id', array('empty' => true ));
                echo $this->Form->input('province_id', array('empty' => true ));
		echo $this->Form->input('city_id', array('empty' => true ));
                echo $this->Form->input('map_id', array('empty' => true ));
                
		echo $this->Form->input('image_1', array('type' => 'file'));
		echo $this->Form->input('image_2', array('type' => 'file'));
		echo $this->Form->input('image_3', array('type' => 'file'));
		echo $this->Form->input('image_4', array('type' => 'file'));
		echo $this->Form->input('image_5', array('type' => 'file'));
		echo $this->Form->input('image_6', array('type' => 'file'));
                
                echo $this->Form->input('dir', array('type' => 'hidden'));
                echo $this->Form->input('mimetype', array('type' => 'hidden'));
                echo $this->Form->input('filesize', array('type' => 'hidden'));
    
		echo $this->Form->input('publish_state_id');
		echo $this->Form->input('PostTag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Post.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Post.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Business Types'), array('controller' => 'business_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Related Business Type'), array('controller' => 'business_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Provinces'), array('controller' => 'provinces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Province'), array('controller' => 'provinces', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Categories'), array('controller' => 'post_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Category'), array('controller' => 'post_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Authors'), array('controller' => 'post_authors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Author'), array('controller' => 'post_authors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Venues'), array('controller' => 'venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Venue'), array('controller' => 'venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cities'), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Publish States'), array('controller' => 'publish_states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Publish State'), array('controller' => 'publish_states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Meta'), array('controller' => 'post_meta', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Metum'), array('controller' => 'post_meta', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Post Tags'), array('controller' => 'post_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post Tag'), array('controller' => 'post_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php echo $this->Html->script( array(
        '/js/tiny_mce/jquery.tinymce.js',
        '/js/jquery.maskedinput-1.3.min.js',
        ), array('inline' => false)); ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
	// turn on TinyMVC
	$('#PostPost').tinymce({
                // Location of TinyMCE script
                script_url : '/js/tiny_mce/tiny_mce.js',
                theme : 'advanced',
               
                plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',
                // Theme options
                theme_advanced_buttons1 : 'bold,italic,|,link,unlink,|,bullist,numlist,|,forecolor,backcolor,|,fullscreen,cleanup,code',
                theme_advanced_buttons2 : '',
        	theme_advanced_buttons3 : '',
        	theme_advanced_buttons4 : '',
		document_base_url : 'http://yyztech.ca/'	
	});
        
      
    });
", array('inline' => false) ); ?>
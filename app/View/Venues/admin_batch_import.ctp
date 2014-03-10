<style type="text/css">
    
    div.checkbox {
    display: inline-block;
    margin: 0;
    padding: 5px 2px;
    width: 250px;
    }
    
    fieldset { border: 1px solid #ccc;}
    
    #hours_block div.input {
    display: inline-block;
    margin: 0;
    padding: 5px 2px;
    width: 250px;
    }
    
</style>

<link rel="stylesheet" href="/css/base/jquery.ui.all.css">
<link rel="stylesheet" href="/css/base/jquery.ui.theme.css">
<link rel="stylesheet" href="/css/jqueryui/jquery-ui-1.8.21.custom.css">
<style type="text/css">
	.ui-dialog { position: fixed;}
</style>

<div class="venues form">
  



   
<?php echo $this->Form->create('Venue');?>
	<fieldset>
		<legend>Batch Import from JSON</legend>
	<?php
        
            echo $this->Form->input('json', array('type' => 'textarea'));
            
            echo $this->Form->input('description', array('type' => 'textarea'));
            
            // echo $this->Form->create('Venue');
           // echo $this->Form->input('base_venue_id', array('type' => 'hidden', 'value' => $baseVenue['Venue']['id']));

         

            // -------------------
            echo $this->Form->end('Save'); 
                
        ?>
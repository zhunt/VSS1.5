
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
<!-- Dialogs, etc. -->
<div class="jqueryui">
    <div id="dialog-message" title="Scratch-Pad">
	<textarea cols="75" rows="10"></textarea>
    </div>
</div>    



    <a href="#" id="link_scratch_pad" style="padding-right: 3em">Show Scratch-Pad</a>
    <a href="#" id="link_reset_form">Clear Form</a>
<?php echo $this->Form->create('Venue');?>
	<fieldset>
		<legend>Make Multiple Copies of <?php echo $baseVenue['Venue']['name'] . ' ' . $baseVenue['Venue']['sub_name'] ?></legend>
	<?php
        
                
                echo $this->Form->create('Venue');
                echo $this->Form->input('base_venue_id', array('type' => 'hidden', 'value' => $baseVenue['Venue']['id']));
                
              
                
                echo "<fieldset><legend>URLs</legend>";
                echo $this->Form->input('urls', array('type' => 'textarea'));
                echo $this->Form->input('base_description', array('type' => 'textarea', 'value' => $baseVenue['Venue']['description'] ));
                echo '</fieldset>';
                
               
                
                // -------------------
                echo $this->Form->end('Save'); 
                
        ?>
                
             
	
                
<?php echo $this->Html->script( array('/js/jquery.maskedinput-1.3.min.js'), array('inline' => false) ); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){

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
    
    // phone number filter
    $('.phone_field').mask("(999) 999-9999? x99999");
    
    // copy hours from Sunday to other days
    $('.link_copy_hours').click( function() { 
        blockName = $(this).attr('name');
            hours = $.trim($('#' + blockName + 'HoursSun').val());

            $('#' + blockName + 'HoursMon').val(hours);
            $('#' + blockName + 'HoursTue').val(hours);
            $('#' + blockName + 'HoursWed').val(hours);
            $('#' + blockName + 'HoursThu').val(hours);
            $('#' + blockName + 'HoursFri').val(hours);
            $('#' + blockName + 'HoursSat').val(hours);

            return false;
    } ); 
    
    // form reset
    $('#link_reset_form').click( function() { 
    
      // from: http://www.learningjquery.com/2007/08/clearing-form-data
      // iterate over all of the inputs for the form
      // element that was passed in
      $(':input', '#VenueAdminMultiCloneVenueForm').each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        
        // password inputs, and textareas
        if (type == 'text' || type == 'password' || tag == 'textarea')
          this.value = "";
        // checkboxes and radios need to have their checked state cleared
        // but should *not* have their 'value' changed
        else if (type == 'checkbox' || type == 'radio')
          this.checked = false;
        // select elements need to have their 'selectedIndex' property set to -1
        // (this works for both single and multiple select elements)
        else if (tag == 'select')
          this.selectedIndex = -1;
      });
   
      return false;
    
    } );
    
});
<?php $this->Html->scriptEnd(); ?> 
<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php 
    
   // echo $this->Html->css('bootstrap.css'); 
    
    echo $this->Html->css('cake.generic');
    
    //echo $this->Html->css('bootstrap.css');
    ?>
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->    
    
    
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <?php //echo $this->Html->css('bootstrap-responsive.css'); ?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<?php echo $this->Html->charset(); ?>

	<?php
        // Icon
        echo $this->Html->meta(
            'yyztech-icon',
            '/img/yyztech-icon.png',
            array('type' => 'icon')
        );
        
        echo $this->fetch('meta');
	echo $this->fetch('css');
        
	?>
</head>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link('Admin ACD', '/admin/businesses/'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		
	</div>
    
    
    <?php echo $this->Html->script( array(
        'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', 
        'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js',
        '/js/bootstrap.js') ); ?>    
  
   
    
    <?php echo $this->fetch('script'); ?>
    
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>

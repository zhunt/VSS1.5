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
    <meta name="author" content="YYZtech">
	<meta name="msvalidate.01" content="252003D472040B18F7BD92CBBE2EC0F3" />
    <!-- Le styles -->
    <?php echo $this->Html->css('production.min.css'); ?>
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,400,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

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
        
        if (isset($metaDescription)) {
            echo $this->Html->meta(
                'description',
                $metaDescription
            );
        }
        if (isset($metaKeywords)) {
            echo $this->Html->meta(
                'keywords',
                $metaKeywords
            );
        }        

        echo $this->fetch('meta');
	echo $this->fetch('css');
	?>  

<?php echo $this->element('opengraph') ?>
    
<meta name='robots' content='noindex,nofollow' />
<?php if ( Configure::read('debug') == 0) : ?>
    <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-1890732-30']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    </script>	

    <!-- script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script -->

<?php endif; ?>


</head>
<body>
<!--nocache-->    
<?php echo $this->element('admin_panel') ?>
<!--/nocache-->
    
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    <?php //echo $this->Session->flash(); ?>
    
    <?php echo $this->fetch('content'); ?>
    

    <script src="/js/production.min.js"></script>
    
    <?php echo $this->fetch('script'); ?>
    
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5206cf7a632a80f8"></script>

    <?php // echo $this->element('sql_dump'); ?>
</body>
</html>

<?php if (isset($openGraph)):?>
<meta property="og:title" content="<?php echo htmlentities($openGraph['ogTitle']) ?>"/>
<meta property="og:description" content="<?php echo htmlentities($openGraph['ogDesc']) ?>"/>
<meta property="og:type" content="<?php echo $openGraph['ogType'] ?>"/>
<meta property="og:url" content="<?php echo htmlentities($openGraph['ogUrl']) ?>"/>
<meta property="og:site_name" content="<?php echo htmlentities($openGraph['ogSiteName']) ?>"/>
<meta property="og:image" content="<?php echo $openGraph['ogImage'] ?>"/>
<link rel="canonical" href="<?php echo $openGraph['ogUrl'] ?>" />
<link rel="image_src" href="<?php echo $openGraph['ogImage'] ?>" />
<?php endif; ?>
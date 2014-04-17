<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
<?php if ($mobile_store_charset) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php } ?>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/mobile_store_stylesheet.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-device-width: 200px) and (max-device-width: 640px)" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/ms_1_column.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-device-width: 641px) and (max-device-width: 960px)" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/ms_2_column.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-device-width: 961px) and (max-device-width: 1280px)" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/ms_3_column.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-device-width: 1281px) and (max-device-width: 1600px)" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/ms_4_column.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-device-width: 1601px) and (max-device-width: 1940px)" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/ms_5_column.css" />
<!-- <link rel="stylesheet" type="text/css" media="only screen and (min-device-width: 1941px)" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/ms_6_column.css" />  -->


<!-- adapt script -->
<script>
var ADAPT_CONFIG = {
  path: 'catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/',
  dynamic: true,
  range: [
    '0px    to 640px  = ms_1_column.css',
    '640px  to 960px  = ms_2_column.css',
    '960px  to 1280px = ms_3_column.css',
    '1280px to 1600px = ms_4_column.css',
    '1600px to 1940px = ms_5_column.css',
    '1940px           = ms_6_column.css'
  ]
};
</script>
<script src="catalog/view/javascript/adapt.min.js"></script>


<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/mobile_store_common.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />


<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php echo $google_analytics; ?>
</head>
<body>
<div id="container">

<div id="floating-bar">
	<?php if ($logged) { ?>
			<a id="account-button" class="trans-button" href="<?php echo $home;?>">
				<div class="icon account"></div>
				<div class="icon-name"><?php echo $text_home; ?></div>
			</a>
	<?php } ?>
	
	<a id="categories-button" class="trans-button" href="<?php echo $category_list;?>">
		<div class="icon categories"></div>
		<div class="icon-name"><?php echo $text_categories; ?></div>
	</a>
  
	<a id="cart" class="trans-button" href="<?php echo $cart;?>">
	    <div class="icon cart"></div>
	    <div id="cart_total" class="icon-name"><?php echo $text_items.' '.$text_checkout; ?></div>
	</a>
	<!-- 
	<a id="pay-button" class="trans-button" href="<?php echo $checkout;?>">
		<div class="icon pay"></div>
		<div class="icon-name"><?php echo $text_checkout; ?></div>
	</a>
	 -->
</div>

<div id="notification"></div>

<div id="BeeperBox" class="UIBeeper">
 <div class="UIBeeper_Full">
	<div class="Beeps">
	   <div class="UIBeep UIBeep_Top UIBeep_Bottom UIBeep_Selected" style="opacity: 1; ">
		 <div class="UIBeep_Icon">
			<i class="beeper_icon image2"></i>
		 </div>
		 <span class="beeper_x">&nbsp;</span>
		 <div id="notify_text"></div>
		
	   </div>
	</div>
 </div>
</div>


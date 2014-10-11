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

<link type="text/css" rel="stylesheet" href="catalog/view/javascript/jquery_mobile/jquery.mobile-1.4.4.min.css">
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery_mobile/jquery.mobile-1.4.4.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/mobile_store.js"></script>

</head>

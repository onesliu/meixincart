<?php echo $header; ?>
<a href=<?php $code = $_SESSION['oauth_code'];
	$state = $_SESSION['oauth_state'];
echo "http://qy.gz.1251102575.clb.myqcloud.com/pay/paytest.php?code=$code&state=$state";?>>支付测试页面</a>
<div id="content"><?php echo $content_top; ?>
<h1 style="display: none;"><?php echo $heading_title; ?></h1>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
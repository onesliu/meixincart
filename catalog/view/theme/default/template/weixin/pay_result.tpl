<?php echo $header; ?>
<div id="content" class="square" style="background:transparent;border:0px;">

  <div>
	<div class="checkout-content" style="display:block;">
	<?php if ($payresult == true) { ?>
	<span>支付成功</span>
	<?php } else { ?>
	<span>支付失败</span>
	<?php } ?>
	</div>
  </div>
  <?php if ($payresult == true) { ?>
  <div>
    <div class="center"><a href="<?php echo $continue; ?>" class="button_11 blue blue_borderbottom radius4">马上查看订单</a></div>
  </div>
  <?php } ?>
</div>
<?php echo $footer; ?>

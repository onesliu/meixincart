<?php echo $header; ?>
<div id="content" class="square" style="background:transparent;border:0px;">

  <div>
	<div class="checkout-content" style="display:block;">
	<span><?php echo $error_msg; ?></span>
	</div>
  </div>
  <?php if (isset($continue)) { ?>
  <div>
    <div class="center"><a href="<?php echo $continue; ?>" class="button_11 blue blue_borderbottom radius4"><?php echo $text_continue; ?></a></div>
  </div>
  <?php } ?>
</div>
<?php echo $footer; ?>

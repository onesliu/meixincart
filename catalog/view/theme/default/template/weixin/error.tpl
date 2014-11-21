<?php echo $header; ?>
<body>
<div data-role="page" id="weixinerrorpage" data-theme="a" data-title="下单结果">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<div class="ui-body ui-body-b ui-corner-all">
			<p><?php echo $error_msg; ?></p>
		</div>
		<a href="<?php echo $continue; ?>" class="ui-btn ui-btn-a ui-corner-all"><?php echo $text_continue; ?></a>
	</div>
	<?php if (isset($navi)) echo $navi;?>
</div>
</body>


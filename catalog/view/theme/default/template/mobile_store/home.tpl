<?php echo $header; ?>
<body>
<div data-role="page" data-theme="a" id="homepage">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<img id="help1" src="<?php echo $dir_img.'help1.png'; ?>" width="100%" style="display:none;" onclick="$(this).hide();"></img>
		<img src="<?php echo $dir_img.'dm1.jpg'; ?>" width="100%"></img>
	</div>
	<?php echo $navi; ?>
	<script type="text/javascript"><!--

		$(document).on("pageinit", "#homepage", function(){
			if (showhelp > 0) {
				$("#help1").show();
			}
		});
	//--></script>
</div>
</body>

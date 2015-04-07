<?php echo $header; ?>
<body>
<div data-role="page" id="product_page" data-theme="a" data-title="<?php echo $heading_title; ?>">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<div>
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<?php foreach($images as $img) {?>
					<div class="swiper-slide">
						<img src="<?php echo $img['popup']; ?>" />
					</div>
					<?php } ?>
				</div>
				<div class="swiper-pagination swiper-pagination-white"></div>
			</div>

			<div class="ui-body">
				<h3 style="margin-top:.4em;margin-bottom:.4em;"><?php echo $heading_title; ?></h3>
				<h4 style="margin-top:.4em;"><span style="color:red;"><?php echo $price; ?></span><span class="light-font">/<?php echo $unit; ?></span></h4>
			</div>
		</div>
		
		<div class="ui-body line-box">
			<div>
			<?php if ($attribute_groups) { ?>
				<?php foreach ($attribute_groups as $attribute_group) { ?>
				<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
					<div class="attr-block"><?php echo $attribute['name']; ?>：<?php echo $attribute['text']; ?></div>
				<?php }} ?>
			<?php } ?>
			</div>
		</div>
		
		<div class="ui-body line-box">
			<h4>商品详情</h4>
			<p><?php echo $description; ?></p>
		</div>
		
		<div data-role="popup" id="positionWindow" data-transition="slideup" data-position-to="window" class="ui-content" data-theme="a">
			<p id="buy_alert"></p>
		</div>
		
	</div>
	<div data-role="footer" data-position="fixed" data-theme="d" data-tap-toggle="false">
		<span><center><a class="ui-btn ui-corner-all ui-shadow ui-btn-d ui-btn-inline" href="<?php echo $special_url; ?>">犒 劳 自 己</a>
	</div>

	<script type="text/javascript"><!--
	$(document).on("pageinit", "#product_page", function(){
		setTimeout(function(){
			var mySwiper = new Swiper('.swiper-container',{
			    pagination: '.swiper-pagination',
			    paginationClickable: true,
			    autoplay: 2000,
			    loop: true
			  });
			mySwiper.update();
		}, 500);
	});
	//--></script>
</div>
</body>

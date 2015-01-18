<?php echo $header; ?>
<body>
<div data-role="page" id="product_page" data-theme="a" data-title="<?php echo $heading_title; ?>">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
			<div id="productswipe" class="img-box">
				<?php if (isset($thumb)) {?>
				<img class="img-list slide out" src="<?php echo $popup; ?>" />
				<?php } foreach($images as $image) {?>
				<img class="img-list slide out" src="<?php echo $image['popup']; ?>" />
				<?php } ?>
				<div class="img-index"></div>
			</div>
			
			<h3 style="display:inline-block;margin-bottom:.4em;"><?php echo $heading_title; ?></h3>
			<h4 style="display:inline-block;margin-bottom:.4em;"><span style="color:red;"><?php echo $price; ?></span>/<?php echo $unit; ?>
			<!-- 
			<?php if ($product_type == 0) { ?>
  			（每<?php echo $sellunit; ?>:<span style="color:red;">￥<?php echo $sellprice; ?></span>）
  			<?php } else { ?>
  			（每<?php echo $sellunit; ?>约:<span style="color:red;">￥<?php echo $sellprice; ?></span>）
  			<?php } ?>
  			 -->
			</h4>
			<div>
				<h4 style="display:block;margin:1em 0 .3em 0;">购买数量： （<?php echo $model; ?>）</h4>
	    		<button class="ui-btn ui-btn-icon-notext ui-icon-minus ui-btn-inline ui-corner-all" style="margin:.4em .4em .4em 0;border:0px;"
	    		onclick="scount(-1);"></button>
	  			<span id="quantity"><?php echo $minimum; ?></span>
	  			<button class="ui-btn ui-btn-icon-notext ui-icon-plus ui-btn-inline ui-corner-all" style="margin:.4em 1em .4em .4em;border:0px;"
	  			onclick="scount(1);"></button>
	  			<a href="#" onclick="addCart();" class="ui-btn ui-btn-a ui-corner-all ui-icon-shop ui-btn-icon-right ui-btn-inline">加入购物车</a>
  			</div>
		</div>
		
		<?php if ($attribute_groups) { ?>
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
			<?php foreach ($attribute_groups as $attribute_group) { ?>
			<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
				<h4><?php echo $attribute_group['name']; ?>：<?php echo $attribute['name']; ?></h4>
				<p><?php echo $attribute['text']; ?></p>
			<?php }} ?>
		</div>
		<?php } ?>
		
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
			<h4><?php echo $tab_description; ?></h4>
			<p><?php echo $description; ?></p>
		</div>
		
		<div data-role="popup" id="positionWindow" data-transition="slideup" data-position-to="window" class="ui-content" data-theme="a">
			<p id="buy_alert"></p>
		</div>
		
		<script type="text/javascript"><!--
		$(document).on("pageinit", "#product_page", function(){
			setSwipeImg('#productswipe', "swipe");
		});

		function scount(num) {
			var count = $('#quantity').text() - 0;
			num = num - 0;
			count += num;
			if (count < <?php echo $minimum; ?>) {
				count = <?php echo $minimum; ?>;
				return;
			}

			$('#quantity').text(count);
		}

		function addCart() {
			var product_id = <?php echo $product_id; ?>;
			var quantity = $('#quantity').text() - 0;

			$.ajax({
				url: 'index.php?route=mobile_store/cart/add',
				type: 'post',
				data: 'product_id=' + product_id + '&quantity=' + quantity,
				dataType: 'json',
				success: function(json) {
					if (json.success) {
						$('#buy_alert').html(json.success);
						
						$('#positionWindow').popup( 'reposition', 'positionTo: window' );
						$('#positionWindow').popup('open', { positionTo: "window" });
						setTimeout(function() {
							$("#positionWindow").popup('close');
						}, 1000);
					}
				}
			});
		}
		//--></script>
		
	</div>
	<?php echo $navi; ?>
</div>
</body>

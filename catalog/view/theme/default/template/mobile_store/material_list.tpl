<form action="#" id="materials">
<ul data-role="listview" data-inset="true" data-shadow="false" data-theme="c" data-divider-theme="c" data-count-theme="c">
	<li data-role="list-divider">原料自由组合</li>

<?php if ($sources) { ?>
	<li class="ui-field-contain">
		<p style="white-space:normal;">菜品标价是按我们推荐的份量来的，如您需要不同的份量可以自由选择，价格也会随之浮动。</p>
		<fieldset data-role="controlgroup">
			<?php foreach ($sources as $source) { if ($source['source_type'] == 0) { $mid='m'.rand(); ?>
			<input data-iconpos="right" type="checkbox"
				   name="product[<?php echo $source['product_id']; ?>]" id="<?php echo $mid; ?>" 
				   <?php if ($source['status'] > 0) echo 'checked="checked"'; else echo 'disabled="disabled"'; ?>
			/>
			<label for="<?php echo $mid; ?>" class="ui-alt-icon"><?php echo $source['name'].' '.$source['weight_show']; ?>
				<span style="color:red;"><?php if ($source['status'] > 0) echo $source['price_show']; else echo '已下架'; ?></span></label>
			<?php }} ?>
		</fieldset>
	</li>
	
	<li data-role="list-divider">辅料及调味品</li>
	<li class="ui-field-contain">
		<p style="white-space:normal;">请根据您的需要选择，我们都是按固定包装与价格售卖，您可能一次用不完。</p>
		<fieldset data-role="controlgroup">
			<?php foreach ($sources as $source) { if ($source['source_type'] == 1) { $mid='m'.rand(); ?>
			<input data-iconpos="right" type="checkbox" name="product[<?php echo $source['product_id']; ?>]" id="<?php echo $mid; ?>"
				<?php if ($source['status'] <= 0) echo 'disabled="disabled"'; ?>
			/>
			<label for="<?php echo $mid; ?>" class="ui-alt-icon"><?php echo $source['name'].' '.$source['weight_show']; ?>
				<span style="color:red;"><?php if ($source['status'] > 0) echo $source['price_show']; else echo '已下架'; ?></span></label>
			<?php }} ?>
		</fieldset>
	</li>
	
	<li class="ui-body ui-body-b">
		<button type="button" onclick="addToCart();" class="ui-btn ui-btn-a ui-corner-all ui-icon-cart ui-btn-icon-right">打钩原料加入购物车</button>
	</li>
	
	<div data-role="popup" id="positionWindow" data-transition="slideup" data-position-to="window" class="ui-content" data-theme="a">
		<p id="buy_alert"></p>
	</div>
	
	<script type="text/javascript"><!--
	function addToCart(product_id, quantity) {
		quantity = typeof(quantity) != 'undefined' ? quantity : 1;

		$.ajax({
			url: 'index.php?route=mobile_store/cart/add',
			type: 'post',
			data: $('#materials').serialize(),
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
<?php } ?>
	
</ul>
</form>
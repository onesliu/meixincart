<form action="#">
<ul data-role="listview" data-inset="true" data-shadow="false" data-theme="c" data-divider-theme="c" data-count-theme="c">
	<li data-role="list-divider">当前菜谱中所有原料购买</li>

<?php if ($sources) { ?>
	<li class="ui-field-contain">
		<p>原料是按份或个来卖的，如不够可多次加入购物车</p>
		<fieldset data-role="controlgroup">
			<?php foreach ($sources as $source) { if ($source['source_type'] == 0) { $mid='m'.rand(); ?>
			<input data-iconpos="right" type="checkbox" checked="checked" name="product[<?php echo $source['product_id']; ?>]" id="<?php echo $mid; ?>" />
			<label for="<?php echo $mid; ?>"><?php echo $source['name'].' '.$source['weight_show'].'/份 '; ?>
				<span style="color:red;"><?php echo $source['price_show']; ?></span></label>
			<?php }} ?>
		</fieldset>
	</li>
	
	<li data-role="list-divider">辅料及调味品</li>
	<li class="ui-field-contain">
		<p>辅料和调味品请根据您的需要选购</p>
		<fieldset data-role="controlgroup">
			<?php foreach ($sources as $source) { if ($source['source_type'] == 1) { $mid='m'.rand(); ?>
			<input data-iconpos="right" type="checkbox" name="product[<?php echo $source['product_id']; ?>]" id="<?php echo $mid; ?>" />
			<label for="<?php echo $mid; ?>"><?php echo $source['name'].' '.$source['weight_show']; ?>
				<span style="color:red;"><?php echo $source['price_show']; ?></span></label>
			<?php }} ?>
		</fieldset>
	</li>
	
	<li class="ui-body ui-body-b">
		<button type="submit" class="ui-btn ui-btn-a ui-corner-all ui-icon-shop ui-btn-icon-right">打钩原料加入购物车</button>
	</li>
<?php } ?>
	
</ul>
</form>
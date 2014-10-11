<?php foreach ($products as $product) { ?>
<li data-icon="plus" id="plist">
	<a href="<?php echo $product['href']; ?>">
	<img src="<?php echo $product['thumb']; ?>">
	<h2><?php echo $product['name']; ?></h2>
	<p><?php echo $product['description']; ?></p>

	<?php if ($product['price']) { ?>
		<p class="ui-li-aside">
		<span><?php echo $product['price']; ?></span><br/>
		<?php if (!$product['special']) { ?>
			<span><?php echo $product['special']; ?></span>
		<?php } ?>
		</p>
	<?php } ?>
	
	<a href="#" onclick="addToCart(<?php echo $product['product_id'];?>);"><?php echo $button_cart; ?></a>
</li>
<?php } ?>

  <?php foreach ($products as $product) { ?>
  	<li>
  		<a href="<?php echo $product['href']; ?>">
	  		<img src="<?php echo $product['thumb']; ?>" />
	  		<h2><?php echo $product['name']; ?> <span style="color:red;"><?php echo $product['price']; ?></span>/<?php echo $product['unit']; ?></h2>
	  		<p><?php echo $product['model']; ?></p>
		</a>
    	<a href="#1" onclick="addToCart(<?php echo $product['product_id'];?>);" class="ui-alt-icon"><?php echo $button_cart; ?></a>
  	</li>
  <?php } ?>
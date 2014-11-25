  <?php foreach ($products as $product) { ?>
  	<li>
  		<a href="<?php echo $product['href']; ?>">
  		<img src="<?php echo $product['thumb']; ?>" />
  		<h2><?php echo $product['name']; ?></h2>
  		<p><span style="color:red;"><?php echo $product['price']; ?></span>/<?php echo $product['unit']; ?>
  		<?php if ($product['product_type'] == 0) { ?>
  		（每<?php echo $product['sellunit']; ?>:<span style="color:red;">￥<?php echo $product['sellprice']; ?></span>）
  		<?php } else { ?>
  		（每<?php echo $product['sellunit']; ?>约:<span style="color:red;">￥<?php echo $product['sellprice']; ?></span>）
  		<?php } ?>
		</p>

  		<?php if ($product['model']) { ?>
			<p class="ui-li-aside" style="right:.4em">
				<?php echo $product['model']; ?>
			</p>
		<?php } ?>
		</a>
    	<a href="#1" onclick="addToCart(<?php echo $product['product_id'];?>);" style="border-left:0px;"><?php echo $button_cart; ?></a>
  	</li>
  <?php } ?>
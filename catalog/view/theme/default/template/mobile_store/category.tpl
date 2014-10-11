<?php echo $header; ?>
<body>
<div data-role="page">
	<?php echo $navi; ?>
	<div data-role="content">
	<?php echo $content_top; ?>
	  	
  	<ul data-role="listview">
  		<li data-role="divider"><h2><?php echo $heading_title; ?></h2></li>
  	<?php foreach ($products as $product) { ?>
  		<li data-icon="plus">
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
  		<li data-role="divider"></li>
  	</ul>

	<?php if ($pagination->page < $pagination->num_pages) { ?>
	<p><a id="bmore" href="#" data-role="button">点击加载更多</a></p>
	<?php } ?>

	<?php echo $content_bottom; ?>
	</div>
</div>

<script type="text/javascript"><!--
var url_more="<?php echo $pagination->url; ?>";
var um_page=<?php echo $pagination->page; ?>;
var um_pages=<?php echo $pagination->num_pages; ?>;
$("#bmore").click(function(){
	um_page++;
	url = "<?php echo $pagination->url; ?>" + "&page=" + um_page;
	$.get(url, function(data,status) {
		$("#plist").append(data);
		if (um_page >= um_pages) {
			$("#bmore").hide();
		}
	});
});
//--></script> 

</body>

<?php echo $header; echo $column_left; ?>
<div id="content" class="square"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($products) { ?>
  <div class="product-compare"></div>
  <div id="plist" class="product-list">

    <?php foreach ($products as $product) { ?>
    <div>
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <div class="description"><?php echo $product['description']; ?></div>
      <div class="cart"><a onclick="addToCart(<?php echo $product['product_id'];?>);" class="button"><span><?php echo $button_cart; ?></span></a></div>
	  <?php if ($product['price']) { ?>
      <div class="price">
        <?php if (!$product['special']) { ?>
        <?php echo $product['price']; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if (!$categories && !$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <!-- <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div> -->
  <?php } ?>
  <?php echo $content_bottom; ?></div>
  
  <?php if ($pagination->page < $pagination->num_pages) { ?>
  	<br/>
    <div>
    	<div class="center"><a id="bmore" class="button_11 green green_borderbottom radius4">点击加载更多</a></div>
  	</div>
  <?php } ?>
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
<?php echo $footer;?>
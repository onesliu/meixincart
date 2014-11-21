<?php echo $header; ?>
<body>
<div data-role="page" id="categorypage" data-theme="a" data-title="<?php echo $heading_title; ?>">
	<?php echo $titlebar; ?>
	<div data-role="content">

  	<ul data-role="listview" id="plist" data-inset="true" data-split-icon="shop" data-theme="c" data-divider-theme="c" data-count-theme="c">
  		<li data-role="list-divider"><?php echo $heading_title; ?></li>
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
  	</ul>
	<br/>
	<?php if ($pagination->page < $pagination->num_pages) { ?>
	<p><a id="bmore" href="#" data-role="button">更多...</a></p>
	<?php } ?>

	<script type="text/javascript"><!--
	function addToCart(product_id, quantity) {
		quantity = typeof(quantity) != 'undefined' ? quantity : 1;

		$.ajax({
			url: 'index.php?route=mobile_store/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + quantity,
			dataType: 'json',
			success: function(json) {
				$('.success, .warning, .attention, .information, .error').remove();
				
				if (json['redirect']) {
					location = json['redirect'];
				}
				
				if (json['success']) {
					$('#buy_alert').html(json['success']);
					
					//$('#cart_total').html(json['total']);
					$('#positionWindow').popup( 'reposition', 'positionTo: window' );
					$('#positionWindow').popup('open', { positionTo: "window" });
					setTimeout(function() {
						$("#positionWindow").popup('close');
					}, 1000);
				}	
			}
		});
	}
	
	var url_more="<?php echo $pagination->url; ?>";
	var um_page=<?php echo $pagination->page; ?>;
	var um_pages=<?php echo $pagination->num_pages; ?>;
	$(document).on("pageinit","#categorypage",function(){
		$("#bmore").on("click", function(){
			um_page++;
			url = "<?php echo $pagination->url; ?>" + "&page=" + um_page;
			$.get(url, function(data,status) {
				$("#plist").append(data);
				$("#plist").listview('refresh');
				$("#plist").find("li:last").slideDown(300);
				if (um_page >= um_pages) {
					$("#bmore").hide();
				}
			});
		});
	});

	function searchproduct() {
        var url = "<?php echo $searchurl; ?>";
        var filter = $('#product_search').val();
        url += '&filter=' + filter;
        $.mobile.changePage(url, {allowSamePageTransition:true});
	}
	//--></script> 
	</div>
	
	<div data-role="popup" id="positionWindow" data-transition="slideup" data-position-to="window" class="ui-content" data-theme="a">
		<p id="buy_alert"></p>
	</div>
	<?php echo $navi; ?>
</div>

</body>

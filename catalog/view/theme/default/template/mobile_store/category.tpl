<?php echo $header; ?>
<body>
<div data-role="page" id="categorypage" data-theme="a" class="my-page" data-title="<?php echo $heading_title; ?>">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<div class="colum-list">
	  	<ul data-role="listview" id="plist" data-inset="true" data-split-icon="cart" data-theme="c" data-divider-theme="c" data-count-theme="c">
	  		<li data-role="list-divider"><?php echo $heading_title; ?></li> 
			<?php require('category_more.tpl'); ?>
	  	</ul>
	  	</div>
		<?php if ($pagination->page < $pagination->num_pages) { ?>
		<div style="float:left;clear:both;width:100%;"><a id="bmore" style="margin:.5625em;" href="#" data-role="button">更多...</a></div>
		<?php } ?>
	</div>
	
	<div data-role="popup" id="positionWindow" data-transition="slideup" data-position-to="window" class="ui-content" data-theme="a">
		<p id="buy_alert"></p>
	</div>
	
	<?php echo $navi; ?>
	
	<script type="text/javascript"><!--
	function addToCart(product_id, quantity) {
		quantity = typeof(quantity) != 'undefined' ? quantity : 1;

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

		//if (showhelp > 0) {
		//	$("#help2").show();
		//}
	});

	function searchproduct() {
        var url = "<?php echo $searchurl; ?>";
        var filter = $('#product_search').val();
        url += '&filter=' + filter;
        $( ":mobile-pagecontainer" ).pagecontainer( "change", url, {transition:"fade",dataUrl:"search"});
        //$.mobile.changePage(url, {allowSamePageTransition:true});
	}
	//--></script> 
</div>

</body>

<?php if (!isset($orders) || count($orders) == 0) { ?>
	<div class="ui-body ui-body-b ui-corner-all">
		<p>没有订单</p>
	</div>
<?php } elseif ($pagination->page == 1) { ?>
	<ul data-role="listview" id="olist" data-inset="true" data-theme="c" data-divider-theme="c" data-count-theme="c">
		<li data-role="list-divider">订单列表</li>
		<?php foreach($orders as $order) { ?>
		<li><a href="#" onclick="OrderDetail('<?php echo $order['href'];?>');">
			<img src="<?php echo $order['products'][0]['image'];?>"></img>
			<h4 style="margin-top:0px;padding-right:3em;"><?php echo $order['productnames'];?></h4>
			<p style="margin-bottom:0px;"><?php echo $text_total.' '; ?><span style="color:red;"><?php echo $order["total"]; ?></span><br/>
			<?php echo $order["date_added"]; ?></p>
			<p class="ui-li-aside" style="color:<?php 
				switch ($order["order_status_id"]) {
					case '1': echo "blue"; break;
					case '2': echo "red"; break;
					case '3': echo "blue"; break;
					default: echo "black"; break;
				}
			?>;"><strong><?php echo $order["status"];?></strong></p>
		</a></li>
		<?php } ?>
	</ul>
	<?php if ($pagination->page < $pagination->num_pages) { ?>
		<a id="bmore" href="#" onclick="OnMoreOrder();" class="ui-btn ui-btn-a ui-corner-all">更多...</a>
	<?php } ?>
<?php } else { ?>
		<?php foreach($orders as $order) { ?>
		<li><a href="#" onclick="OrderDetail('<?php echo $order['href'];?>');">
			<img src="<?php echo $order['products'][0]['image'];?>"></img>
			<h4 style="margin-top:0px;padding-right:3em;"><?php echo $order['productnames'];?></h4>
			<p style="margin-bottom:0px;"><?php echo $text_total.' '; ?><span style="color:red;"><?php echo $order["total"]; ?></span><br/>
			<?php echo $order["date_added"]; ?></p>
			<p class="ui-li-aside" style="color:<?php 
				switch ($order["order_status_id"]) {
					case '1': echo "blue"; break;
					case '2': echo "red"; break;
					case '3': echo "blue"; break;
					default: echo "black"; break;
				}
			?>;"><strong><?php echo $order["status"];?></strong></p>
		</a></li>
		<?php } ?>
<?php } ?>

<script type="text/javascript"><!--
var url_more="<?php echo $pagination->url; ?>";
var um_page=<?php echo $pagination->page; ?>;
var um_pages=<?php echo $pagination->num_pages; ?>;
function OnMoreOrder() {
	um_page++;
	url = "<?php echo $pagination->url; ?>" + "&page=" + um_page;
	$.get(url, function(data,status) {
		$("#olist").append(data);
		$("#olist").listview('refresh');
		$("#olist").find("li:last").slideDown(300);
		if (um_page >= um_pages) {
			$("#bmore").hide();
		}
	});
}

function OrderDetail(url) {
	url += "&customer=" + userid;
	$.get(url, function(data,status) {
		$('#content').html(data);
	});
}
//--></script>



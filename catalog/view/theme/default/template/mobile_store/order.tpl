<?php echo $header; ?>
<body>
<div data-role="page" id="orderpage" data-theme="a" data-title="<?php echo $heading_title; ?>">
	<?php echo $titlebar; ?>
	<div data-role="content">
	<?php if (!isset($orders)) { ?>
		<div class="ui-body ui-body-b ui-corner-all">
			<p>暂时没有订单</p>
		</div>
	<?php } else { ?>
		<ul data-role="listview" id="olist" data-inset="true" data-theme="c" data-divider-theme="c" data-count-theme="c">
			<li data-role="list-divider">订单列表</li>
			<?php foreach($orders as $order) { ?>
			<li><a href="<?php echo $order["href"]; ?>">
				<img src="<?php echo $order['products'][0]['image'];?>"></img>
				<h4 style="margin-top:0px;padding-right:3em;"><?php echo $order['productnames'];?></h4>
				<p style="margin-bottom:0px;"><?php echo $text_total.' '; ?><span style="color:red;"><?php echo $order["total"]; ?></span><br/>
				<?php echo $order["date_added"]; ?></p>
				<p class="ui-li-aside"><strong><?php echo $order["status"];?></strong></p>
			</a></li>
			<?php } ?>
		</ul>
	<?php } ?>
		<?php if ($pagination->page < $pagination->num_pages) { ?>
		<p><a id="bmore" href="#" data-role="button">更多...</a></p>
		<?php } ?>

		<script type="text/javascript"><!--
		var url_more="<?php echo $pagination->url; ?>";
		var um_page=<?php echo $pagination->page; ?>;
		var um_pages=<?php echo $pagination->num_pages; ?>;
		$(document).on("pageinit","#orderpage",function(){
			$("#bmore").on("click", function(){
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
			});
		});
		//--></script> 
	</div>
	<?php echo $navi; ?>
</div>
</body>
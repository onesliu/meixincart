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
			<?php require('order_more.tpl'); ?>
		</ul>
	<?php } ?>
		<?php if ($pagination->page < $pagination->num_pages) { ?>
		<a id="bmore" href="#" class="ui-btn ui-btn-a ui-corner-all">更多...</a>
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
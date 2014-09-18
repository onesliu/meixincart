<?php if ($pagination->page <= 1) { echo $header; ?>

<div id="content" class="square" style="background:transparent;border:0px;"><?php echo $content_top; ?>
  
  <?php } foreach($orders as $order) { ?>
  <div class="checkout-content order-list" style="display:block;">
	  <a href="<?php echo $order["href"]; ?>">
	  <table>
	  <tbody>
	  	<tr>
	      <td width="30%"><?php echo $text_order_id; ?></td>
	      <td><?php echo $order["order_id"]; ?></td>
	  	</tr>
	  	<tr>
	      <td><?php echo $text_date_added; ?></td>
	      <td><?php echo $order["date_added"]; ?></td>
	  	</tr>
	  	<tr>
	      <td><?php echo $text_total; ?></td>
	      <td><span class="price"><?php echo $order["total"]; ?></span>
	      <span class="order-status"><?php echo $order["status"];?></span></td>
	  	</tr>
	  </tbody>
	  </table>

	  <div class="order-detail"><?php for($i = 0; $i < 4 && $i < count($order["products"]); $i++) {?>
	  	<span><?php echo $order["products"][$i]["name"]; ?></span>
	  <?php } ?>
	  	<!-- <a class="button" style="float:right;">申请退款</a>  -->
	  </div>
	  </a>
  </div>
  <?php } ?>
  
<?php if ($pagination->page <= 1) {?>
  <?php echo $content_bottom; ?>
</div>

  <?php if ($pagination->page < $pagination->num_pages) { ?>
	<div>
	  <div class="center"><a id="bmore" class="button_11 green green_borderbottom radius4">点击加载更多</a></div>
	</div>
  <?php } ?>
  
<script type="text/javascript"><!--
var um_page=<?php echo $pagination->page; ?>;
var um_pages=<?php echo $pagination->num_pages; ?>;
$("#bmore").click(function(){
	url = "<?php echo $pagination->url; ?>";
	um_page++;
	$.get(url, function(data,status) {
		$("#content").append(data);
		if (um_page >= um_pages) {
			$("#bmore").hide();
		}
	});
});

//--></script>

<?php echo $footer; } ?>
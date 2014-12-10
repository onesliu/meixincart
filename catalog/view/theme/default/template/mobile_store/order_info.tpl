<?php echo $header; ?>
<body>
<div data-role="page" id="orderinfopage" data-theme="a" data-title="<?php echo $heading_title; ?>">
<style type="text/css">
.ui-table-columntoggle-btn {
    display: none !important;
}
</style>
	<?php echo $titlebar; ?>
	<div data-role="content">
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
			<p><?php echo $text_order_id; ?><?php echo $order_id; ?></p>
			<p><?php echo $text_date_added; ?><?php echo $date_added; ?></p>
		</div>
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
		  <table data-role="table" data-mode="columntoggle" class="ui-responsive table-stripe">
		    <thead>
		      <tr>
		        <td data-priority="1"><?php echo $column_name; ?></td>
		        <td data-priority="2"><?php echo $column_quantity; ?></td>
		        <td data-priority="3"><?php echo $column_total; ?></td>
		      </tr>
		    </thead>
		    <tbody>
		      <?php foreach ($products as $product) { ?>
		      <tr>
		        <td><?php echo $product['name']; ?></td>
		        <td><?php echo $product['quantity']; ?></td>
		        <td><?php echo $product['total']; ?></td>
		      </tr>
		      <?php } ?>
		      <tr>
		      <tfoot>
      		  <?php foreach ($totals as $total) {  ?>
      		  <tr>
		        <td> </td>
		        <td><?php echo $total['title']; ?>:</td>
		        <td><?php echo $total['text']; ?></td>
		      </tr>
		      <?php } ?>
		    </tbody>
		  </table>
		</div>
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
		  <table data-role="table" data-mode="columntoggle" class="ui-responsive table-stripe">
		    <thead>
		      <tr>
		        <td data-priority="1"><?php echo $text_history; ?></td>
		        <td data-priority="2"><?php echo $column_status; ?></td>
		        <td data-priority="3"><?php echo $column_comment; ?></td>
		      </tr>
		    </thead>
		    <tbody>
		      <?php foreach ($histories as $history) { ?>
		      <tr>
		        <td><?php echo $history['date_added']; ?></td>
		        <td><?php echo $history['status']; ?></td>
		        <td><?php echo $history['comment']; ?></td>
		      </tr>
		      <?php } ?>
		    </tbody>
		  </table>
		</div>
		<div class="ui-body ui-body-b ui-corner-all" style="margin-bottom:.4em;">
			<table data-role="table" data-mode="columntoggle" class="ui-responsive table-stroke">
			    <thead>
			      <tr>
			        <td data-priority="1">配送信息</td>
			      </tr>
			    </thead>
			    <tbody>
			    	<tr><td><?php echo $shipping_address; ?></td></tr>
			    	<tr><td><?php echo $shipping_district; ?><br/><?php echo $shipping_district_addr; ?></td></tr>
			    	<tr><td>希望收货时间：<?php echo $shipping_time; ?></td></tr>
			    </tbody>
		  	</table>
		</div>
		<?php if (isset($weixin_payment)) {?>
		<div data-role="footer" data-position="fixed" data-theme="b" data-tap-toggle="false">
			<span><center><a href="<?php echo $weixin_payment; ?>" class="ui-btn ui-btn-a ui-corner-all" style="width: 50%"><?php echo $text_pay_btn;?></a></center></span>
		</div>
		<?php } ?>
	</div>
</div>
</body>

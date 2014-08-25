<?php echo $header; ?>
<div id="content" class="square" style="background:transparent;border:0px;"><?php echo $content_top; ?>

  <div class="checkout">
    <div id="confirm">
      <div class="checkout-content" style="display:block;">
      <div class="checkout-heading">订单明细</div>
		<div class="checkout-product">
		  <table>
		    <thead>
		      <tr>
		        <td class="name"><?php echo $column_name; ?></td>
		        <td class="quantity"><?php echo $column_quantity; ?></td>
		        <td class="price"><?php echo $column_price; ?></td>
		        <td class="total"><?php echo $column_total; ?></td>
		      </tr>
		    </thead>
		    <tbody>
		      <?php foreach ($products as $product) { ?>
		      <tr>
		        <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
		          <?php foreach ($product['option'] as $option) { ?>
		          <br />
		          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
		          <?php } ?></td>
		        <td class="quantity"><?php echo $product['quantity']; ?></td>
		        <td class="price"><?php echo $product['price']; ?></td>
		        <td class="total"><?php echo $product['total']; ?></td>
		      </tr>
		      <?php } ?>
		      <?php if (isset($vouchers)) { foreach ($vouchers as $voucher) { ?>
		      <tr>
		        <td class="name"><?php echo $voucher['description']; ?></td>
		        <td class="quantity">1</td>
		        <td class="price"><?php echo $voucher['amount']; ?></td>
		        <td class="total"><?php echo $voucher['amount']; ?></td>
		      </tr>
		      <?php }} ?>
		    </tbody>
		    <tfoot>
		      <?php foreach ($totals as $total) { ?>
		      <tr>
		        <td colspan="3" class="price"><b><?php echo $total['title']; ?>:</b></td>
		        <td class="total"><?php echo $total['text']; ?></td>
		      </tr>
		      <?php } ?>
		    </tfoot>
		  </table>
		</div>
      </div>
    </div>
    
    <form id="weixin_payment" name="weixin_payment" method="post" action="<?php echo $weixin_payment; ?>">
    <div id="checkout">
      <div class="checkout-content" style="display:block;" onclick="editaddr();" >
		<div id="addr" <?php if (!isset($address)) echo "style=\"display:none\""; ?> >
			<div class="checkout-heading">收货地址</div>
		    <div><span id="user_name"><?php if (isset($address)) {echo $address['firstname']; echo $address['lastname'];} ?></span>
		    	<span id="user_telephone"><?php echo $telephone; ?></span></div>
		    <div id="user_addr"><?php if (isset($address)) {echo $address['address_1'];} ?></div>
		    <br/>
		    <span class="checkout-heading"><?php echo $text_shipping_district; ?></span>
		    <select id="district-select" name="district-select">
	      		<option value="0">请选择就近的配送点</option>
	      		<?php foreach($shipping_districts as $district) {
	      			if ($district['id'] != $order_info['shipping_district_id']) {
	      		?>
	      		<option value="<?php echo $district['id']; ?>"><?php echo $district['name'];?></option>
	      		<?php } else { ?>
	      		<option selected="selected" value="<?php echo $district['id']; ?>"><?php echo $district['name'];?></option>
	      		<?php }} ?>
      		</select>
      	</div>
		<div id="addr_none" <?php if (isset($address)) echo "style=\"display:none\""; ?> >选择收货地址</div>
      </div>
    </div>

    <div id="shipping-time">
      <div class="checkout-content" style="display:block;">
      	<span class="checkout-heading"><?php echo $text_shipping_time; ?></span>
      	<select name="time-select">
      		<?php foreach($shipping_time as $sk => $st) {?>
      		<option value="<?php echo $sk; ?>"><?php echo $st; ?></option>
      		<?php } ?>
      	</select>
      </div>
    </div>
  </div>
  </form>
  
  <div>
    <div class="center"><a onclick="if (check_form() && weixin_pay()) {$('#weixin_payment').submit();}" class="button_11 orange orange_borderbottom radius4">微信支付</a></div>
  </div>
  
  <?php echo $content_bottom; ?>
</div>
<script type="text/javascript"><!--
function check_form() {
	if ($('#addr').css("display") == "none") {
		alert('请选择一下收货地址吧！');
		return false;
	}
	
	if ($('#district-select option:selected').val() == 0) {
		alert('系统无法自动从您的地址中判断出就近的配送点，请人工选择。如果太远无法配送，客服会联络您哦～');
		return false;
	}

	return true;
}
//--></script>
<?php echo $pay; ?>
<?php echo $footer; ?>
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
    <?php echo $shipping; ?>
    </form>
    
  </div>
  <div>
    <div class="center"><a onclick="if (check_form()) {$('#weixin_payment').submit();}" class="button_11 orange orange_borderbottom radius4"><?php echo $text_pay_btn; ?></a></div>
  </div>
    
<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>
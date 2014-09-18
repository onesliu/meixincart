<?php echo $header; ?>
<div id="content" class="square"><?php echo $content_top; ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left title" colspan="2"><?php echo $heading_title; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left">
          <?php echo $text_order_id; ?><?php echo $order_id; ?><br />
          <?php echo $text_date_added; ?><?php echo $date_added; ?>
        </td>
      </tr>
    </tbody>
  </table>
  <?php if (isset($shipping_district) && $shipping_district != '') { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left title" colspan="2">配送信息</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php if ($shipping_address) {
        	echo $shipping_address; } ?>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $shipping_district; ?><br/>
        <?php echo $shipping_district_addr; ?></td>
      </tr>
      <tr>
        <td class="left">希望收货时间：<?php echo $shipping_time; ?>
        </td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left title"><?php echo $column_name; ?></td>
        <td class="center title"><?php echo $column_quantity; ?></td>
        <td class="center title"><?php echo $column_price; ?></td>
        <td class="center title"><?php echo $column_total; ?></td>
        <?php if ($products) { ?>
        <td class="center title"><?php echo $text_return; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="left"><?php echo $product['name']; ?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td class="center"><?php echo $product['quantity']; ?></td>
        <td class="center"><?php echo $product['price']; ?></td>
        <td class="center"><?php echo $product['total']; ?></td>
        <td class="center"><a href="<?php echo $product['return']; ?>"><img src="catalog/view/theme/default/image/return.png" alt="<?php echo $button_return; ?>" title="<?php echo $button_return; ?>" /></a></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="left"><?php echo $voucher['description']; ?></td>
        <td class="left"></td>
        <td class="right">1</td>
        <td class="right"><?php echo $voucher['amount']; ?></td>
        <td class="right"><?php echo $voucher['amount']; ?></td>
        <?php if ($products) { ?>
        <td></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) {  ?>
      <tr>
        <td colspan="3"></td>
        <td class="right"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
  <?php if ($comment) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left title"><?php echo $text_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <?php if ($histories) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left title"><?php echo $text_history; ?></td>
        <td class="left title"><?php echo $column_status; ?></td>
        <td class="left title"><?php echo $column_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td class="left"><?php echo $history['date_added']; ?></td>
        <td class="left"><?php echo $history['status']; ?></td>
        <td class="left"><?php echo $history['comment']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 
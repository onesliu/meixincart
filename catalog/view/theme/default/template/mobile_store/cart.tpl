<?php echo $header; ?>
<?php if ($attention) { ?>
<div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>

<div id="content" class="square"><?php echo $content_top; ?>
  
  <h1><?php echo $heading_title; ?>
    <?php if ($weight) { ?>
    &nbsp;(<?php echo $weight; ?>)
    <?php } ?>
  </h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <ul class="responsive_table">
          <li class="table_row lgreen radius4">
            <div class="table_section_small"><?php echo $column_remove; ?></div>
            <div class="table_section"><?php echo $column_name; ?></div>
            <div class="table_section"><?php echo $column_quantity; ?></div>
            <div class="table_section_small"><?php echo $column_price; ?></div>
            <div class="table_section_small"><?php echo $column_total; ?></div>
          </li>
          <?php foreach ($products as $product) { ?>
          <li class="table_row lgray radius4">
            <div class="table_section_small"><a href="<?php echo $product['remove']; ?>"><img style="vertical-align:middle;" src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a></div>
            <div class="table_section"><?php echo $product['name']; ?>
              <?php if (!$product['stock']) { ?>
              <span class="stock">***</span>
              <?php } ?>
              <div>
                <?php foreach ($product['option'] as $option) { ?>
                - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                <?php } ?>
              </div>
              <?php if ($product['reward']) { ?>
              <small><?php echo $product['reward']; ?></small>
              <?php } ?></div>
            <div class="table_section">
			  <input type="text" onchange="" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="3" />
			  <input type="image" src="catalog/view/theme/default/image/update.png" alt="<?php echo $button_update; ?>" title="<?php echo $button_update; ?>" /> 
            </div>
            <div class="table_section_small"><?php echo $product['price']; ?></div>
            <div class="table_section_small"><?php echo $product['total']; ?></div>
          </li>
          <?php } ?>
          <?php foreach ($vouchers as $vouchers) { ?>
          <li class="table_row lgray radius4">
            <div class="table_section_small"></div>
            <div class="table_section"><?php echo $vouchers['description']; ?></div>
            <div class="table_section"></div>
            <div class="table_section"><input type="text" name="" value="1" size="4" disabled="disabled" />
              &nbsp;<a href="<?php echo $vouchers['remove']; ?>"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $text_remove; ?>" title="<?php echo $button_remove; ?>" /></a></div>
            <div class="table_section_small"><?php echo $vouchers['amount']; ?></div>
            <div class="table_section_small"><?php echo $vouchers['amount']; ?></div>
          </li>
          <?php } ?>
    </ul>
  </form>
  <div class="clearfix"></div>
  <div class="cart-total">
    <table id="total">
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="5" class="right"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div class="buttons">
    <div class="center"><a href="<?php echo $checkout; ?>" class="button_11 orange orange_borderbottom radius4"><?php echo $button_checkout; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--

$('input[name=\'next\']').bind('change', function() {
	$('.cart-module > div').hide();
	
	$('#' + this.value).show();
});


<?php if ($next == 'coupon') { ?>
$('#use_coupon').trigger('click');
<?php } ?>
<?php if ($next == 'voucher') { ?>
$('#use_voucher').trigger('click');
<?php } ?>
<?php if ($next == 'reward') { ?>
$('#use_reward').trigger('click');
<?php } ?>
<?php if ($next == 'shipping') { ?>
$('#shipping_estimate').trigger('click');
<?php } ?>
//--></script>
<?php if ($shipping_status) { ?>
<script type="text/javascript"><!--
$('#button-quote').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/quote',
		type: 'post',
		data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-quote').attr('disabled', true);
			$('#button-quote').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-quote').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();			
						
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
							
				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}					
			}
			
			if (json['shipping_method']) {
				html  = '<h2><?php echo $text_shipping_method; ?></h2>';
				html += '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">';
				html += '  <table class="radio">';
				
				for (i in json['shipping_method']) {
					html += '<tr>';
					html += '  <td colspan="3"><b>' + json['shipping_method'][i]['title'] + '</b></td>';
					html += '</tr>';
				
					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<tr class="highlight">';
							
							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" /></td>';
							} else {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" /></td>';
							}
								
							html += '  <td><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</label></td>';
							html += '  <td style="text-align: right;"><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['text'] + '</label></td>';
							html += '</tr>';
						}		
					} else {
						html += '<tr>';
						html += '  <td colspan="3"><div class="error">' + json['shipping_method'][i]['error'] + '</div></td>';
						html += '</tr>';						
					}
				}
				
				html += '  </table>';
				html += '  <br />';
				html += '  <input type="hidden" name="next" value="shipping" />';
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" class="button" />';				
				html += '</form>';
				
				$.colorbox({
					overlayClose: true,
					opacity: 0.5,
					width: '600px',
					height: '400px',
					href: false,
					html: html
				});
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').trigger('change');
//--></script>
<?php } ?>
<?php echo $footer; ?>
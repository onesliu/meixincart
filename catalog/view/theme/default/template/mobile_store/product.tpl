<?php echo $header; ?>
<div id="content" class="square"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  
  <?php if ($images) { ?>
	  <div class="image-additional" style="height: <?php echo $ps_galery_height; ?>px;">
		<ul id="ps-gallery">
		<?php if ($thumb) { ?>
			<li><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
		<?php } ?>
		<?php if ($images) { ?>
			<?php foreach ($images as $image) { ?>
				<li><a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
			<?php } ?>
	    <?php } ?>
		</ul>
	   </div>
  <?php } ?>
  
  <div class="product-info">
    <div class="right">
      <div class="description">
		<?php if ($thumb && !$images) { ?>
		<div class="image">
			<ul id="ps-gallery" style="list-style:none; margin:0; padding:0;">
				<li><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">
					<img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" 
					alt="<?php echo $heading_title; ?>" id="image" 
					style="width:<?php echo $image_width;?>px; height:<?php echo $image_height;?>px;"/></a></li>
			</ul>	
		</div>
	    <?php } ?>
        <?php if ($manufacturer) { ?>
        <span><?php echo $text_manufacturer; ?></span><?php echo $manufacturer; ?><br />
        <?php } ?>
        
        <?php if ($price) { ?>
	      <span><?php echo $text_price; ?></span>
	      <span class="price" style="color:#f17225;">
	        <?php if (!$special) { ?>
	        <?php echo $price; ?>
	        <?php } else { ?>
	        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
	        <?php } ?>
	        <?php if ($tax) { ?>
	        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
	        <?php } ?>
	        <?php if ($points) { ?>
	        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span>
	        <?php } ?>
	        <?php if ($discounts) { ?>
	        <div class="discount">
	          <?php foreach ($discounts as $discount) { ?>
	          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?>
	          <?php } ?>
	        </div>
	        <?php } ?>
	      </span><span><?php echo '/'.$weight; ?></span>
	      <?php } ?>
		<br/>
        <span><?php echo $text_sellrule; ?></span> <?php echo $model; ?><br />
        <!-- <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />  -->
        <span><?php echo $text_model; ?></span> <?php echo $type; ?>
		
		<?php if ($review_status) { ?>
			<!-- <div style="margin-top: 3px;"><img src="catalog/view/theme/default/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" /></div> -->
		<?php } ?>
	  
	  </div>
		
      <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
        <br />
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
            <table class="option-image">
              <?php foreach ($option['option_value'] as $option_value) { ?>
              <tr>
                <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
                <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label></td>
              </tr>
              <?php } ?>
            </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <a id="button-option-<?php echo $option['product_option_id']; ?>" class="button"><span><?php echo $button_upload; ?></span></a>
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="cart">
        <div><?php echo $text_qty; ?>
          <input type="text" name="quantity" size="5" value="<?php echo $minimum; ?>" />
          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
          &nbsp;</div>
          <a id="button-cart" class="button_12 green green_borderbottom radius4"><span><?php echo $button_cart; ?></span></a>
       
        <?php if ($minimum > 1) { ?>
        <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
    </div>
  </div>
  
  <?php if ($attribute_groups) { ?>
   <div>	
<!--	<div class="row-title no-mb active round"><?php echo $tab_attribute; ?></div> 
	  <div id="tab-attribute" class="row-content no-bt active"> -->
		<table class="attribute">
		  <?php foreach ($attribute_groups as $attribute_group) { ?>
		  <thead>
			<tr>
			  <td colspan="2"><?php echo $attribute_group['name']; ?></td>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
			<tr>
			  <td width="40%"><?php echo $attribute['name']; ?></td>
			  <td width="60%"><?php echo $attribute['text']; ?></td>
			</tr>
			<?php } ?>
		  </tbody>
		  <?php } ?>
		</table>
<!-- 	  </div> -->
  </div>
  <?php } ?>

  <div>
	  <div class="row-title no-mb active round"><?php echo $tab_description; ?></div>
	  <div id="tab-description" class="row-content no-bt active"><?php echo $description; ?></div>
  </div>
  
  <?php if ($review_status && false) { ?>
  <div>		
	  <div class="row-title no-mb round"><?php echo $tab_review; ?></div>
	  <div id="tab-review" class="row-content">
		<div id="review"></div>
		<h2 id="review-title"><?php echo $text_write; ?></h2>
		<b><?php echo $entry_name; ?></b><br />
		<input class="maximize" type="text" name="name" value="" />
		<br />
		<br />
		<b><?php echo $entry_review; ?></b>
		<textarea class="maximize" name="text" cols="40" rows="8" style="width: 98%;"></textarea>
		<span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
		<br />
		<b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
		<input type="radio" name="rating" value="1" />
		&nbsp;
		<input type="radio" name="rating" value="2" />
		&nbsp;
		<input type="radio" name="rating" value="3" />
		&nbsp;
		<input type="radio" name="rating" value="4" />
		&nbsp;
		<input type="radio" name="rating" value="5" />
		&nbsp; <span><?php echo $entry_good; ?></span><br />
		<br />
		<b><?php echo $entry_captcha; ?></b><br />
		<input type="text" name="captcha" value="" />
		<br />
		<img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
		<br />
		<div class="buttons">
		  <div class="right"><a id="button-review" class="button"><span><?php echo $button_continue; ?></span></a></div>
		</div>
	  </div>
  </div>	  
  <?php } ?>
  <?php if ($products) { ?>
  <div>	  
	  <div class="row-title"><?php echo $tab_related; ?></div>
	  <div id="tab-related" class="row-content">
		<div class="box-product">
		  <?php foreach ($products as $product) { ?>
		  <div>
			<?php if ($product['thumb']) { ?>
			<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
			<?php } ?>
			<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
			<?php if ($product['price']) { ?>
			<div class="price">
			  <?php if (!$product['special']) { ?>
			  <?php echo $product['price']; ?>
			  <?php } else { ?>
			  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
			  <?php } ?>
			</div>
			<?php } ?>
			<?php if ($product['rating']) { ?>
			<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
			<?php } ?>
			<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><span><?php echo $button_cart; ?></span></a></div>
		  <?php } ?>
		</div>
	  </div>
  </div>	  
  <?php } ?>
  <?php if ($tags && false) { ?>
  <div class="tags"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
  
<script type="text/javascript">
	(function(window, $, PhotoSwipe){
		$(document).ready(function(){
			var options = {};
			$("#ps-gallery a").photoSwipe(options);
		});
	}(window, window.jQuery, window.Code.PhotoSwipe));
	
</script>  

<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=mobile_store/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 	 
						
			if (json['success']) {
				$('#notify_text').html(json['success']);
				//$('.success').fadeIn('slow');
				$('#cart_total').html(json['total']);
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				$('#BeeperBox').slideDown('fast');
				setTimeout(function() {
					$("#BeeperBox").hide()
				}, 2000);
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
	},
	onComplete: function(file, json) {
		$('.error').remove();
		
		if (json.success) {
			alert(json.success);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json.file);
		}
		
		if (json.error) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json.error + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').slideUp('slow');
		
	$('#review').load(this.href);
	
	$('#review').slideDown('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review-title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review-title').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<?php echo $footer; ?>
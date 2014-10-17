$(document).ready(function() {

	var new_dimension = $('#header').width() - $('#home-up').width() - $('#search-up').width() - 30;
	$('#store-name').css('width', new_dimension+'px');
	$('#search .search').css('width', new_dimension+'px');

	$('#search input[name=\'filter_name\']').keydown(function(e) {
		if (e.keyCode == 13) { 
			$('#search-up').trigger('click');
		}
	});
	
	/* Search */
	$('#search-up').bind('click', function() {
		if ( $('#search').is(':visible') && $('#search input[name=\'filter_name\']').attr('value') != "" ){
		
			url = 'index.php?route=mobile_store/search'; 
			
			var filter_name = $('#search input[name=\'filter_name\']').attr('value');
			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			} else {
				url += '&filter_name=';
			}
			
			url += '&filter_sub_category=true';
			url += '&filter_description=true';
			
			location = url;
		} else {	
			$('#store-name').toggle('slow');
			$('#search').toggle('slow');
		}
	});
	
	/* Ajax Cart */
	$('#cart > .heading a').bind('click', function() {
		$('#cart').addClass('active');
		
		$.ajax({
			url: 'index.php?route=mobile_store/cart/update',
			dataType: 'json',
			success: function(json) {
				if (json['output']) {
					$('#cart .content').html(json['output']);
				}
			}
		});			
		
		$('#cart').bind('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
	
	$('.success img, .warning img, .attention img, .information img').delegate('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});

	$('.beeper_x').bind('click', function(){
		$('#BeeperBox').slideUp('fast');
	});	
	
	$('.category-arrow').bind('click', function(){
		var current_class = $(this).attr('class').replace("category-arrow ", "");
		
		if (current_class == "up"){
			$(this).removeClass("up");
			$(this).addClass("down");
			$('.box-category').slideUp('slow');
		}
		
		if (current_class == "down"){
			$(this).removeClass("down");
			$(this).addClass("up");
			$('.box-category').slideDown('slow');
		}
	});
	
	
	$('body').bind('ajaxComplete',function(event,request,settings){
		if ( settings.url.match(/.*payment\/.*\/confirm/)){
			location = 'index.php?route=mobile_store/checkoutsuccess'; 
		}
	});
	
});

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=mobile_store/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notify_text').html(json['success']);
				
				//$('.success').fadeIn('fast');
				$('#cart_total').html(json['total']);
				//$('html, body').animate({ scrollTop: 0 }, 'fast'); 
				$('#BeeperBox').slideDown('fast');
				setTimeout(function() {
					$("#BeeperBox").hide()
				}, 1000);
			}	
		}
	});
}


function removeCart(key) {
	$.ajax({
		url: 'index.php?route=mobile_store/cart/update',
		type: 'post',
		data: 'remove=' + key,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			
			if (json['output']) {
				$('#cart_total').html(json['total']);
				
				$('#cart .content').html(json['output']);
			}			
		}
	});
}

function removeVoucher(key) {
	$.ajax({
		url: 'index.php?route=mobile_store/cart/update',
		type: 'post',
		data: 'voucher=' + key,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			
			if (json['output']) {
				$('#cart_total').html(json['total']);
				
				$('#cart .content').html(json['output']);
			}			
		}
	});
}





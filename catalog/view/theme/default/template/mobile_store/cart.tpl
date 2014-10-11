<?php echo $header; ?>
<body>
<div data-role="page">
	<?php echo $navi; ?>
	<div data-role="content">
	  	<ul data-role="listview" data-inset="true">
	  		<li data-role="divider"><h2><?php echo $heading_title; ?></h2></li>
	  	<?php foreach ($products as $product) { ?>
	  		<li data-icon="delete" id="<?php echo "p".$product['key']; ?>">
	  			<a href="#1" onClick="changecount();">
	  			<img src="<?php echo $product['thumb']; ?>">
	  			<h2><?php echo $product['name']; ?></h2>
	  			<p class="ui-li-aside"><?php echo $product['price']; ?><br/>
	  				x<?php echo $product['quantity']; ?></p>
	  			</a>
    			<a href="#1" onClick="dconfirm('<?php echo "p".$product['key']; ?>',
    			'<?php echo $product['remove']; ?>','<?php echo $product['name']; ?>');"></a>
	  		</li>
	  	<?php } ?>
	  		<li data-role="divider"></li>
	  	</ul>
		
		<?php echo $content_bottom; ?>
		
		<script type="text/javascript"><!--
		function closeBar() {
			$('#cart_footer').slideUp('fast');
			return true;
		}
		function showinfo(desc) {
			$('#cart_footer').slideDown('fast');
			setTimeout(function() {
				$("#cart_footer").hide()
			}, 1500);
			$('#change_count').hide();
			$('#confirm').hide();
			$('#cart_info').show();
		}
		function dconfirm(id, url, name) {
			$('#cart_footer').slideDown('fast');
			$('#change_count').hide();
			$('#cart_info').hide();
			$('#confirm').show();
			$('#cart_delname').text(name);
			$('#cart_del').on('click', function(){
				$.get(url, function(){
					closeBar();
					showinfo(name+'删除成功');
					$('#'+id).remove();
				});
			});
			$('#delcancel').on('click', closeBar);
		}
		function changecount() {
			$('#cart_footer').slideDown('fast');
			$('#confirm').hide();
			$('#cart_info').hide();
			$('#change_count').show();
			$('#cok').on('click', closeBar);
			$('#ccancel').on('click', closeBar);
		}
		//--></script>

	</div>
	
	<div data-role="footer" id="cart_footer" data-position="fixed" style="display:none;text-align:center;">
		<div id="confirm" style="display:none;">
			<p id="cart_delname"></p>
			<a href="#" data-role="button" data-icon="delete" id="cart_del">删除</a>
			<a href="#" data-role="button" data-icon="back" id="delcancel">取消</a>
		</div>
		<div id="change_count" style="display:none;">
			<p>购买数量:</p>
			<input type="range" name="points" id="points" min="1" value="1" max="10">
			<a href="#" data-role="button" data-icon="delete" id="cok">确定</a>
			<a href="#" data-role="button" data-icon="back" id="ccancel">取消</a>
		</div>
		<div id="cart_info" style="display:none;">
			<p id="idesc"></p>
		</div>
	</div>
	
</div>
</body>

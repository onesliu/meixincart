<?php echo $header; ?>
<body>
<div data-role="page">
	<?php echo $navi; ?>
	<div data-role="content">
	  	<ul data-role="listview">
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
			$('#alert_footer').slideUp('fast');
			return true;
		}
		function showinfo(desc) {
			$('#alert_footer').slideDown('fast');
			setTimeout(function() {
				$("#alert_footer").hide()
			}, 1500);
			$('#change_count').hide();
			$('#confirm').hide();
			$('#info').show();
		}
		function dconfirm(id, url, name) {
			$('#alert_footer').slideDown('fast');
			$('#change_count').hide();
			$('#info').hide();
			$('#confirm').show();
			$('#delname').text(name);
			$('#del').on('click', function(){
				$.get(url, function(){
					closeBar();
					showinfo(name+'删除成功');
					$('#'+id).remove();
				});
			});
			$('#delcancel').on('click', closeBar);
		}
		function changecount() {
			$('#alert_footer').slideDown('fast');
			$('#confirm').hide();
			$('#info').hide();
			$('#change_count').show();
			$('#cok').on('click', closeBar);
			$('#ccancel').on('click', closeBar);
		}
		//--></script>

	</div>
	
	<div data-role="footer" class="ui-btn" id="alert_footer" data-position="fixed" style="display:none;">
		<div id="confirm" style="display:none;">
			<p id="delname"></p>
			<a href="#" data-role="button" data-icon="delete" id="del">删除</a>
			<a href="#" data-role="button" data-icon="back" id="delcancel">取消</a>
		</div>
		<div id="change_count" style="display:none;">
			<div data-role="content">
				<p>购买数量:
				<input type="range" data-role="none" name="points" id="points" min="1" value="1" max=100>
				</p>
				<a href="#" data-role="button" data-icon="delete" id="cok">确定</a>
				<a href="#" data-role="button" data-icon="back" id="ccancel">取消</a>
			</div>
		</div>
		<div id="info" style="display:none;">
			<h1 id="idesc"></h1>
		</div>
	</div>
	
</div>
</body>

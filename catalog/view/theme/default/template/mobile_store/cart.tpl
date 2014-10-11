<?php echo $header; ?>
<body>
<div data-role="page">
	<?php echo $navi; ?>
	<div data-role="content">
		<?php if ($attention) { ?>
		<p><?php echo $attention; ?></p>
		<?php } ?>
		<?php if ($success) { ?>
		<p><?php echo $success; ?></p>
		<?php } ?>
		<?php if ($error_warning) { ?>
		<p><?php echo $error_warning; ?></p>
		<?php } ?>
		<?php echo $content_top; ?>
		
	  	<ul data-role="listview">
	  		<li data-role="divider"><h2><?php echo $heading_title; ?></h2></li>
	  	<?php foreach ($products as $product) { ?>
	  		<li data-icon="delete">
	  			<a href="#change_count" data-rel="dialog" data-transition="slidedown"
	  				onclick="setval(<?php echo $product['quantity']; ?>)">
	  			<img src="<?php echo $product['thumb']; ?>">
	  			<h2><?php echo $product['name']; ?></h2>
	  			<p class="ui-li-aside"><?php echo $product['price']; ?><br/>
	  				x<?php echo $product['quantity']; ?></p>
	  			</a>
    			<a href="#1" onclick="dconfirm();"></a>
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
		function dconfirm(url) {
			$('#alert_footer').slideDown('fast');
			$('#change_count').hide();
			$('#confirm').show();
			$('#del').attr('href', url);
			$('#del').on('click', closeBar);
			$('#delcancel').on('click', closeBar);
		}
		
		function changecount(int val) {
			$('#alert_footer').slideDown('fast');
			$('#confirm').hide();
			$('#change_count').show();
			$('#cok').on('click', closeBar);
			$('#ccancel').on('click', closeBar);
		}
		//--></script>

	</div>
	
	<div data-role="footer" id="alert_footer" data-position="fixed" style="display:none;">
		<div id="confirm" style="display:none;">
			<div data-role="controlgroup" data-type="horizontal">
				<a href="#" data-role="button" data-icon="delete" id="del">删除</a>
				<a href="#" data-role="button" data-icon="back" id="delcancel">取消</a>
			</div>
		</div>
		<div id="change_count" style="display:none;">
			<div data-role="header"><h1>调整数量</h1></div>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
			<div data-role="content">
				<div data-role="fieldcontain">
					<label for="points">购买数量:</label>
					<input type="range" name="points" id="points" value="50" min="1" max="100" data-highlight="true">
				</div>
				<div data-role="controlgroup" data-type="horizontal">
					<a href="#" data-role="button" data-icon="delete" id="cok">确定</a>
					<a href="#" data-role="button" data-icon="back" id="ccancel">取消</a>
				</div>
			</div>
			</form>
		</div>
	</div>
	
</div>
</body>

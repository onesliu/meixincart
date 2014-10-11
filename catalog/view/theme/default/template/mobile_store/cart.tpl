<?php echo $header; ?>
<body>
<div data-role="page">
	<?php echo $navi; ?>
	<div data-role="content">
		<?php if ($attention) { ?>
		<div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
		<?php } ?>
		<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
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
    			<a href="<?php echo $product['remove']; ?>" onclick="delcfm();"></a>
	  		</li>
	  	<?php } ?>
	  		<li data-role="divider"></li>
	  	</ul>
		
		<?php echo $content_bottom; ?>
	</div>
<script>
function delcfm() {
    if (!confirm("确认要删除？")) {
        window.event.returnValue = false;
    }
}

function setval(int val) {
	$("#points").val(val);
}
</script>
</div>

<div data-role="page" id="change_count">
	<div data-role="header"><h1>调整数量</h1></div>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div data-role="content">
		<div data-role="fieldcontain">
			<label for="points">购买数量:</label>
			<input type="range" name="points" id="points" value="50" min="1" max="100" data-highlight="true">
		</div>
		<input type="submit" value="确认">
		<a href="#" data-role="button" data-rel="back">取消</a>
	</div>
	</form>
</div>

<?php echo $category_list; ?>
</body>

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
		
		<h1><?php echo $heading_title; ?>
	    <?php if ($weight) { ?>
	    &nbsp;(<?php echo $weight; ?>)
	    <?php } ?>
	  	</h1>
	  	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	  	<ul data-role="listview" data-inset="true">
	  		<li data-role="divider">购物车</li>
	  	<?php foreach ($products as $product) { ?>
	  		<li data-icon="delete">
	  			<a href="#"><img src="<?php echo $product['thumb']; ?>">
	  			<h2><?php echo $product['name']; ?></h2>
	  			<p class="ui-li-aside"><?php echo $product['price']; ?><br/>
	  				<a data-role="button" href="#change_count" data-rel="dialog" data-transition="pop"><?php echo $product['quantity']; ?></a></p>
	  			</a>
    			<a href="<?php echo $product['remove']; ?>"></a>
	  		</li>
	  	<?php } ?>
	  	</ul>
		</form>
		
		<?php echo $content_bottom; ?>
	</div>
</div>

<div data-role="page" id="change_count">
  <div data-role="content">
  <h3>调整数量</h3>
    <p>该按钮仅供演示。</p>
    <a href="#" data-role="button" data-rel="back" data-icon="check" data-inline="true" data-mini="true">下载</a>
    <a href="#" data-role="button" data-rel="back" data-inline="true" data-mini="true">取消</a>
  </div>
</div>

<?php echo $category_list; ?>
</body>

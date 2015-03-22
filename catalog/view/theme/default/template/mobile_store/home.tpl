<?php echo $header; ?>
<body>
<div data-role="page" data-theme="a" id="homepage" class="my-page">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<?php if (isset($actionimg)) { ?>
		<div id="homeswipe" class="img-box">
			<?php if (isset($actionimg['image1'])) {?>
			<img class="img-list slide out" src="<?php echo $actionimg['image1']; ?>" />
			<?php } if (isset($actionimg['image2'])) {?>
			<img class="img-list slide out" src="<?php echo $actionimg['image2']; ?>" />
			<?php } if (isset($actionimg['image3'])) {?>
			<img class="img-list slide out" src="<?php echo $actionimg['image3']; ?>" />
			<?php } ?>
			<div class="img-index"></div>
		</div>
		<?php } ?>
		
		<div class="colum-list">
			<?php foreach($category as $c) { ?>
		  	<ul data-role="listview" id="plist" data-inset="true" data-split-icon="cart" data-theme="c" data-divider-theme="c" data-count-theme="c">
			  	<li>
			  		<a href="<?php echo $c['href']; ?>">
				  		<img src="<?php echo $c['thumb']; ?>" />
				  		<h2><?php echo $c['name']; ?></h2>
				  		<p> </p>
					</a>
			  	</li>
		  	</ul>
		  	<?php } ?>
	  	</div>
	</div>
	<?php echo $navi; ?>
	<script type="text/javascript"><!--

		$(document).on("pageinit", "#homepage", function(){
			if (typeof homeswipe != "undefined")
				setSwipeImg('#homeswipe', "swipe");
		});
	//--></script>
</div>
</body>

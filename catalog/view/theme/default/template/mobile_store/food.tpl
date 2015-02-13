<?php echo $header; ?>
<body>
<div data-role="page" data-theme="a" id="foodpage">
	<?php echo $titlebar; ?>
	<div data-role="content">
		<div class="ui-body ui-body-b ui-corner-all">
			<div id="foodswipe" class="img-box">
				<?php if (isset($food['image1'])) {?>
				<img class="img-list slide out" src="<?php echo $food['image1']; ?>" />
				<?php } if (isset($food['image2'])) {?>
				<img class="img-list slide out" src="<?php echo $food['image2']; ?>" />
				<?php } if (isset($food['image3'])) {?>
				<img class="img-list slide out" src="<?php echo $food['image3']; ?>" />
				<?php } ?>
				<div class="img-index"></div>
			</div>
			
			<h3 style="display:inline-block;margin-bottom:.4em;"><?php echo $food['name']; ?></h3>
			<h5 style="color:gray;display:inline-block;margin-bottom:.4em;">[ <?php foreach($food['attrs'] as $attr) { foreach($attr as $a) {echo $a['name'].' ';}} ?>]</h5>
			<p><?php echo $food['desp']; ?></p>
		</div>
		
		<?php require('material_list.tpl'); ?>
		
		<ul data-role="listview" data-inset="true" data-theme="b" data-divider-theme="b" data-count-theme="b">
			<li data-role="list-divider">制作过程推荐</li>
			<li><a href="<?php echo $food['make_url']; ?>" data-transition="slidefade">
				<h2>菜鸽子学做馆子菜</h2>
				<p>在家里体验下馆子的味道！</p>
			</a></li>
		</ul>
		
		<script type="text/javascript"><!--
		$(document).on("pageinit", "#foodpage", function(){
			setSwipeImg('#foodswipe', "swipe");
		});
		//--></script>
	</div>
	<?php echo $navi; ?>
</div>
</body>

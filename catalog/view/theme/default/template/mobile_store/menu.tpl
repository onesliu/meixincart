<?php echo $header; ?>
<body>
<div data-role="page" data-theme="a" id="menupage">
	<?php echo $titlebar; ?>
	<div data-role="content">
	    <div class="ui-body ui-body-b ui-corner-all">
	    	<h4 style="margin-bottom:3px;">菜谱选择：</h4>
			<a href="#popupMenu" data-rel="popup" data-transition="pop" class="ui-btn ui-btn-b ui-corner-all ui-icon-carat-d ui-btn-icon-right"><?php echo $menu['name']; ?></a>
		    <div data-role="popup" id="popupMenu" data-theme="b">
		    	<ul data-role="listview" data-inset="true">
			    	<?php foreach ($menus as $m) {?>
		    		<li><a href="<?php echo $m['url']; ?>"><?php echo $m['name']; ?></a></li>
		    		<?php } ?>
		    	</ul>
		    </div>
			<p><?php echo $menu['desp']; ?></p>
		</div>
		
		<?php $menu_food = $menu['menu_food']; require('food_list.tpl'); ?>
		<?php $sources = $menu['sources']; require('material_list.tpl'); ?>
		
	</div>
	<?php echo $navi; ?>
</div>
</body>
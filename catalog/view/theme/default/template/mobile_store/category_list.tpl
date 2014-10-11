<?php if ($categories) { ?>
<div data-role="page" id="category_list">
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<?php foreach($categories as $category) {
				if ($category['childs']) { $subcategories = $category['childs']; ?>
			 <li data-role="list-divider"><h2><?php echo $category['name']; ?></h2></li>
			  <?php foreach ($subcategories as $subcategory) { ?>
			  <li><a href="<?php echo $subcategory['href']; ?>" data-transition="slide"><?php echo $subcategory['name']; ?>
			  	<span class="ui-li-count"><?php echo $subcategory['count']; ?></span></a></li>
			  <?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>
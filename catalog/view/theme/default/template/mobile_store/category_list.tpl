<?php if ($categories) { ?>
<div data-role="page" id="category_list">
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<?php foreach($categories as $category) {
				if ($category['childs']) { $subcategories = $category['childs']; ?>
			 <li data-role="list-divider"><?php echo $category['name']; ?></li>
			  <?php foreach ($subcategories as $subcategory) { ?>
			  <li><a href="<?php echo $subcategory['href']; ?>"><?php echo $subcategory['name']; ?>
			  	<span class="ui-li-count"><?php echo $subcategory['count']; ?></span></a></li>
			  <?php } ?>
			<?php }} ?>
		</ul>
	</div>
</div>
<?php } ?>
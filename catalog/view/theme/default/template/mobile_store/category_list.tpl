<?php echo $header; ?>
<div id="content" class="square"><?php echo $content_top; ?>
  
<?php if ($categories) { ?>
<div class="category-list">
	<ul>
	<?php foreach($categories as $category) { ?> 
		<!-- <a href="<?php echo $category['href']; ?>"><li><?php echo $category['name']; ?></li></a> -->
		<li><h1><?php echo $category['name']; ?></h1>
		  <?php if ($category['childs']) { $subcategories = $category['childs']; ?>
		  <div class="refine-list">
		    <?php if (count($subcategories) <= 5) { ?>
		    <div>
		      <?php foreach ($subcategories as $subcategory) { ?>
		      <a href="<?php echo $subcategory['href']; ?>"><span><?php echo $subcategory['name']; ?></span></a>
		      <?php } ?>
		    </div>
		    <?php } else { ?>
		    <div>
			<?php for ($i = 0; $i < count($subcategories);) { ?>
		    
		      <?php $j = $i + ceil(count($subcategories) / 4); ?>
		      <?php for (; $i < $j; $i++) { ?>
		      <?php if (isset($subcategories[$i])) { ?>
		      <a href="<?php echo $subcategories[$i]['href']; ?>"><span><?php echo $subcategories[$i]['name']; ?></span></a>
		      <?php } ?>
		      <?php } ?>
		    <?php } ?>
			</div>
		    <?php } ?>
		  </div>
		  <?php } ?>
		</li>
	<?php } ?>	
	</ul>
</div>
<?php } else { ?>
<div class="content"><?php echo $text_empty; ?></div>
<?php } ?>

<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
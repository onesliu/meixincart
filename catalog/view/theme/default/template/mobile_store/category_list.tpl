<?php echo $header; ?>
<div id="content" class="round"><?php echo $content_top; ?>
  
<?php if ($categories) { ?>
<div class="category-list">
	<ul>
	<?php foreach($categories as $category) { ?> 
		<a href="<?php echo $category['href']; ?>"><li><?php echo $category['name']; ?></li></a>
	<?php } ?>	
	</ul>
</div>
<?php } else { ?>
<div class="content"><?php echo $text_empty; ?></div>
<?php } ?>
 

<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<?php foreach($orders as $order) { ?>
<li><a href="<?php echo $order["href"]; ?>">
	<img src="<?php echo $order['products'][0]['image'];?>"></img>
	<h4 style="margin-top:0px;padding-right:3em;"><?php echo $order['productnames'];?></h4>
	<p style="margin-bottom:0px;"><?php echo $text_total.' '; ?><span style="color:red;"><?php echo $order["total"]; ?></span><br/>
	<?php echo $order["date_added"]; ?></p>
	<p class="ui-li-aside"><strong><?php echo $order["status"];?></strong></p>
</a></li>
<?php } ?>

<?php echo $header; ?>
<body>
<div data-role="page" id="kforders" data-theme="a">
	<?php echo $titlebar; ?>
	<div data-role="content" id="content">
	</div>
	
	<script type="text/javascript"><!--
	
	$(document).on("pageinit", "#kforders", function(){
	});

	var userid;
	
	function MCS_ClientNotify(EventData) {
	    var evdata = strToJson(EventData);
	    switch(evdata['event']){
	        case 'OnUserChange':{
		        userid = evdata.useraccount;
	            OnUserChange(evdata);
	            break;
	        }
	        case 'OnMapMsgClick':{
	            OnMapMsgClick(evdata);
	            break;
	        }
	    }
	}
	
	function strToJson(str){
		var json = (new Function("return " + str))();
		return json;
	}

	function OnUserChange(evdata) {
		var url = "<?php echo $orderlist; ?>" + "&customer=" + evdata.useraccount;
		$.get(url, function(data,status) {
			$('#content').html(data);
			$("#olist").listview('refresh');
		});
	}

	function OnMapMsgClick(evdata) {
	}
	
	//--></script>

</div>
</body>

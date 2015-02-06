<?php echo $header; ?>
<body>

	<script type="text/javascript"><!--
	
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
		window.open(url);
	}

	function OnMapMsgClick(evdata) {
	}
	
	//--></script>

</body>

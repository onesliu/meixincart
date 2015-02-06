<?php echo $header; ?>
<body>
<div data-role="page" id="kforders" data-theme="a">
	<div data-role="content"></div>
	
	<script type="text/javascript"><!--

	$(document).on("pageinit", "#kforders", function(){
		$.mobile.ajaxEnabled = true;
		$.mobile.pushStateEnabled = true; //建议在关闭 Ajax 导航和大量使用外部链接的情况下关闭这个特性
	});
	
	function MCS_ClientNotify(EventData) {
	    var evdata = strToJson(EventData);
	    switch(evdata['event']){
	        case 'OnUserChange':{
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
		$( ":mobile-pagecontainer" ).pagecontainer( "change", url );
	}
	
	function OnMapMsgClick(evdata) {
	}
	
	//--></script>
</div>
</body>

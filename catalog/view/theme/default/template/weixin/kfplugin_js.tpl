<script type="text/javascript"><!--

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
	window.location.href = url;
}

function OnMapMsgClick(evdata) {
}

//--></script>

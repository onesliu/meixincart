$(document).bind("mobileinit", function(){
    $.mobile.ajaxEnabled = false;
	$.mobile.hashListeningEnabled = true;
	$.mobile.pushStateEnabled = true; //建议在关闭 Ajax 导航和大量使用外部链接的情况下关闭这个特性
	$.mobile.defaultPageTransition = 'slide';
	$.mobile.pageLoadErrorMessage = '文件载入出错';
});

function chgpage(url) {
	$( ":mobile-pagecontainer" ).pagecontainer( "change", url);
}

function auto_scroll(dofunc){
	if (dofunc == null) {
		$(document).unbind("scroll");
	}
	else {
	    $(document).bind("scroll", (function(){
	    	viewH = $(window).height(); //可见高度  
	    	contentH = $(document).height(); //内容高度  
	    	scrollTop = $(document).scrollTop(); //滚动高度  
	    	if(scrollTop/(contentH - viewH) >= 0.95) { //到达底部100px时,加载新内容 
	    		if(typeof dofunc == 'function')
	    			dofunc();
	    	}
	    }));
	}
}  
$(document).bind("mobileinit", function(){
    $.mobile.ajaxEnabled = true;
	$.mobile.hashListeningEnabled = true;
	$.mobile.pushStateEnabled = true; //建议在关闭 Ajax 导航和大量使用外部链接的情况下关闭这个特性
	$.mobile.defaultPageTransition = 'slidefade';
	$.mobile.pageLoadErrorMessage = '文件载入出错';
});
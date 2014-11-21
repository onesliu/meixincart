//var eleIndex = $("#index"), eleList = $("#box .list");

function funIndex(eleIndex, eleList) {
    var htmlIndex = '';
    eleList.each(function() {
        if ($(this).hasClass("out")) {
            htmlIndex += '<i></i>';    
        } else {
            htmlIndex += '<i class="on"></i>';
        }
    });
    eleIndex.html(htmlIndex);
};

function setSwipeImg(targetBox, touchEvt) {
	var target = $(targetBox).get(0);
	target.indexElement = -1;
	target.eleSlideIn = null;
	target.eleList = $(targetBox+" .img-list");
	target.eleIndex = $(targetBox+" .img-index");
	
	var objEvt = $._data($(targetBox)[0], "events");
	if (!objEvt || !objEvt[touchEvt]) {
		$(targetBox).on(touchEvt,function(){
			var target = $(this).get(0);
			target.indexElement++;
			if (target.indexElement >= target.eleList.length) {
				target.indexElement = 0;
			}
			target.eleSlideIn && target.eleSlideIn.removeClass("in").addClass("out");
			target.eleSlideIn = $(target.eleList.get(target.indexElement)).removeClass("out").addClass("in");
			funIndex(target.eleIndex, target.eleList);
			return false;
		}).trigger("swipe");
	}
	
	//$(targetBox).trigger("swipe");
}

function clearSwipeImg(targetBox) {
	var target = $(targetBox).get(0);
	target.indexElement = -1;
	target.eleSlideIn = null;
	target.eleList = $(targetBox+" .img-list");
	target.eleIndex = $(targetBox+" .img-index");
}

/************************HTML********************
<div class="img-box">
	<img class="img-list slide in" src="<?php echo $food['image1']; ?>" />
	<img class="img-list slide out" src="<?php echo $food['image2']; ?>" />
	<img class="img-list slide out" src="<?php echo $food['image3']; ?>" />
	<div class="img-index"></div>
</div>
************************************************/
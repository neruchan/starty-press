jQuery(function($) {
  
var nav    = $('#navi'),
    offset = nav.offset();
  
$(window).scroll(function () {
  if($(window).scrollTop() > offset.top) {
    nav.addClass('navi-fixed');
  } else {
    nav.removeClass('navi-fixed');
  }
});
  
});




$(function() {
	var topBtn = $('#page-top');	
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 600) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
    topBtn.click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
    });
});
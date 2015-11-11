jQuery(window).scroll(function () {

    var scrollHeight = jQuery(document).scrollTop();
    var shadowDepth = scrollHeight;
    var killHeight = 400;
    if (scrollHeight > killHeight) {var shadowDepth = killHeight;}
  
    if (scrollHeight > 0) {
      jQuery('#navigationContainer').css('box-shadow','5px 0px 15px rgba(31,38,47,'+shadowDepth/killHeight+')');
    } else if (scrollHeight > killHeight) {
      jQuery('#navigationContainer').css('box-shadow','3px 0px 10px rgba(31,38,47,1)');
    } else {
      jQuery('#navigationContainer').css('box-shadow','3px 0px 10px rgba(31,38,47,0)');
    }
  
    
});

	var headerHeight = jQuery('#navigationContainer').outerHeight();
	jQuery('#headerFix').height(headerHeight + 'px');

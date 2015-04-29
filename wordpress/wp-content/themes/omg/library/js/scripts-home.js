/* jquery cycle */
jQuery(document).ready(function($){
	var $slider = $('.cycle-slideshow');
	$slider.imagesLoaded( function() {
	$('#load-cycle').hide(); /* preloader */
	$slider.slideDown(1000);
	});
});

jQuery(window).load(function() {
var container = document.querySelector('#masonry');
var msnry = new Masonry( container, {
  	columnWidth: '.item',
  	itemSelector: '.item',
});
});

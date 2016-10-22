$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	if( $('.mainpage-success-stories').length ) {
		// Initialize slick for main page success stories block
		$('.mainpage-success-stories').css('visibility', 'visible');
		$('.mainpage-success-stories-wrapper').slick({
			arrows: true,
			autoplay: true,
			slide: '.mainpage-success-stories-slide',
			prevArrow: $('.mainpage-success-stories .prev-arrow'),
			nextArrow: $('.mainpage-success-stories .next-arrow'),
			swipe: false,
			swipeToSlide: false,
			touchMove: false
		});
	}
});
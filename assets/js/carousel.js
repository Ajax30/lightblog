$(document).ready(function() {
	var setCarouselImage = function() {
		$('#demo').find('.carousel-item .image-container').each(function() {
			var imgContainer = $(this),
				bkImg = imgContainer.find('img').attr('src');
			if ($(window).width() > 575) {
				imgContainer.css("background-image", 'url("' + bkImg + '")');
			} else {
				imgContainer.css("background-image", 'none');
			}
		});
	}

	setCarouselImage();
	$(window).resize(setCarouselImage);
});
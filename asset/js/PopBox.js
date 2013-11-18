$(function() {
	$('.PopIt').click(function(e) {
		e.preventDefault();

		//	Set position
		$(window).resize();

		//	Create Overlay
		$('body').append('<div class="PopBox_overlay"></div>');
		// 	Display box & overlay
		$('.PopBox.' + $(this).attr('name')).fadeIn();
		$('.PopBox_overlay').fadeIn();

		//	Set listener
		$('.PopBox .close, .PopBox_overlay').click(function(e) {
			e.preventDefault();
			
			closePopBox();
		});
	});
	PopBoxReposition();
});

function closePopBox() {
	$('.PopBox').css('display', 'none');
	$('.PopBox_overlay').remove();
}

$(window).resize(PopBoxReposition);

function PopBoxReposition() {
	$('.PopBox').css('top', ($(window).innerHeight() - $('.PopBox').outerHeight()) / 2);
	$('.PopBox').css('left', ($(window).innerWidth() - $('.PopBox').outerWidth()) / 2);
}
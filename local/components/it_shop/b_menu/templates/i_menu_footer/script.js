	// Установить\удалить обработчик событий при разрешении j_mo_w
	function navFmAd()
	{
		var fm = $('.j_fm');

		$('.j_fm_x').toggleClass('i_fm_x_open');

		fm.slideToggle();
	}
// ---------------------------------------------------------------------------------------------------- [iLaB Script]
$(document).ready(function(){

	// Width adaptive
	var j_fm_w = 480;

	// Resize menu overflow
	$(window).resize(function(){

		if( $(window).width()>j_fm_w )
		{

			if( $('.j_fm').attr('style') )
			{
				$('.j_fm').attr('style','');

				if( $('.j_fm_x').is('.i_fm_x_open') )
					$('.j_fm_x').removeClass('i_fm_x_open');
			}

		}

	});

	$('body').on('click', '.j_fm_ad', navFmAd);

});
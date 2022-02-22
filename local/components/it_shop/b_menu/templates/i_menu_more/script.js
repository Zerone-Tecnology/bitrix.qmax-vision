// ---------------------------------------------------------------------------------------------------- [iLaB Script]
$(document).ready(function(){

	// Width adaptive
	var j_mo_w = 640,
		state;

	// First initialization
	if( $(window).width()>j_mo_w )
	{
		navMoResize();

		state = 'm';

	}
	else if( $(window).width()<=j_mo_w )
	{

		$('.j_mo_ad').bind('click', navMoAd);
		$('.j_mo').prepend($('.j_mo_inside > li'));

		state = 'd';

	}

	// Resize menu overflow
	$(window).resize(function(){

		if( $(window).width()>j_mo_w )
		{

			if( state == 'd' )
			{
				$('.j_mo_ad').unbind('click', navMoAd);

				if( $('.j_mo').is(':hidden') )
					$('.j_mo').show();

				$('.j_mo_x').removeClass('i_mo_x_open');
				$('.j_tblock').removeClass('i_tb_nav');


				state = 'm';
			}

			navMoResize();

		}
		else if( $(window).width()<=j_mo_w && state == 'm' )
		{
			$('.j_mo_ad').bind('click', navMoAd);

			if( $('.j_mo').is(':visible') )
				$('.j_mo').hide();

			if( $('.j_mo_inside > li').length )
			{
				$('.j_mo').append($('.j_mo_inside > li'));
				$('.j_mo_more', $('.j_mo')).appendTo($('.j_mo'));
			}

			state = 'd';

		}

	});

	// Resize more
	function navMoResize()
	{

		$('.j_mo li.j_mo_more').before($('.j_mo_inside > li'));

		var $navItemMore = $('.j_mo > li.j_mo_more').show(),
			$navItems = $('.j_mo > li:not(.j_mo_more)'),
			navItemMoreWidth = navItemWidth = $navItemMore.width(),
			windowWidth = Math.floor($('.j_mo').width()),
			navItemMoreLeft, offset, navOverflowWidth;

		$navItems.each(function() {
			navItemWidth += $(this).width();
		});

		navItemWidth = Math.floor(navItemWidth);

		navItemWidth > windowWidth ? $navItemMore.show() : $navItemMore.hide();
			
		while (navItemWidth > windowWidth)
		{
			navItemWidth -= $navItems.last().width();
			$navItems.last().prependTo('.j_mo_inside');
			$navItems.splice(-1,1);
		}

		navMoSelected();
		
		navItemMoreLeft = $('.j_mo .j_mo_more').position().left;
		navOverflowWidth = $('.j_mo_inside').width();  
		offset = navItemMoreLeft + navItemMoreWidth - navOverflowWidth;

		$('.j_mo_inside').css({
			'left': offset
		});

	}

	// Клик на подменю и кнопку 'Ещё'
	window.j_mo = false;
	$('body').on('click', '.j_mo_more > span, .j_mo_sub > a', function(){

		if( window.j_mo )
			return false;

		window.j_mo = true;

		var th = $(this);
		var sb = th.siblings('ul');

		var im = th.parents('.i_mo_inside').parent('.j_mo_more').length ? true : false;

		if( $(window).width()>j_mo_w )
			navMoClickHide(this, im);

		th.addClass('i_mo_select');

		if( im )
			navMoAnimate(th, sb);
		else
			navMoSlide(th, sb);	

		return false;

	});

	// Установить\удалить обработчик событий при разрешении j_mo_w
	function navMoAd()
	{
		var mo = $('.j_mo');

		if( $(mo).is(':visible') )
			navMoClickHide();

		if( $(mo).is(':hidden') )
			$('.j_tblock').toggleClass('i_tb_nav', true);

		$('.j_mo_x').toggleClass('i_mo_x_open');

		mo.slideToggle(400, function(){
			if( $(mo).is(':hidden') )
				$('.j_tblock').toggleClass('i_tb_nav', false);
		});
	}

	// Скрыть выбранные подменю
	function navMoClickHide()
	{

		if( $('.i_mo_select').length )
			$('.i_mo_select').removeClass('i_mo_select').siblings('ul').hide();

	}

	// Скрыть остальные подменю, при клике на пунк меню
	function navMoClickHide(th, im)
	{

		if( $('.i_mo_select').length )
		{
			var s = $('.i_mo_select').filter(function(){
				return this!=th && !(im && $(this).siblings('.j_mo_inside').length);
			});

			if( s )
				s.each(function(){
					var th = $(this);
					var sb = th.siblings('ul');

					if( th.parents('.i_mo_inside').parent('.j_mo_more').length )
						navMoAnimate(th, sb);
					else
						navMoSlide(th, sb);

				});
		}

	}

	// Раскрыть\скрыть подменю
	function navMoSlide(th, sb)
	{

		sb.slideToggle(400, function(){
			if( $(this).is(':hidden') )
				th.removeClass('i_mo_select');

			window.j_mo = false;
		});

	}

	// Выдвинуть\задвинуть подменю
	function navMoAnimate(th, sb)
	{

		sb.animate({width:'toggle'}, 400, false, function(){
			if( $(this).is(':hidden') )
				th.removeClass('i_mo_select');

			window.j_mo = false;
		});

	}

	// Выделение пункта меню 'Ещё' и скрывание подменю при ресайзе
	function navMoSelected()
	{

		// Выделить пункт меню 'Ещё', если в нём есть выбранный пункт меню
		if( $('.j_mo_inside').find('.i_mo_selected').length )
			$('.j_mo_more > span').addClass('i_mo_selected');
		else
			$('.j_mo_more > span').removeClass('i_mo_selected');

		// Если есть видимые подменю то скрыть их, при перемещении пункта меню в 'Ещё' или наоборот
		if( $('.j_mo_more span.i_mo_select').length && $('.j_mo > li:not(.j_mo_more) > .i_mo_select').length )
			$('.j_mo > li:not(.j_mo_more) > .i_mo_select').removeClass('i_mo_select').siblings('ul').hide();
		else if( $('.j_mo_more span:not(.i_mo_select)').length && $('.j_mo_inside > li > .i_mo_select').length  )
			$('.j_mo_inside > li > .i_mo_select').removeClass('i_mo_select').siblings('ul').hide();

	}

});
// ---------------------------------------------------------------------------------------------------- [iLaB Script]
$(document).ready(function(){

	$('.i_h_menu_preload').fadeOut(600).queue(function () {
		$(this).remove();
	});

	function navHmResizeDesktop()
	{

		if( $('.j_hmt_x').is('.i_hmt_x_select') )
		{
			$('.j_h_menu').css('display','');
			$('.j_hmt_x').removeClass('i_hmt_x_select');
		}

		$('.j_h_menu li.j_h_more').before($('.j_h_inside > li'));

		var $navItemMore = $('.j_h_menu > li.j_h_more').show(),
			$navItems = $('.j_h_menu > li:not(.j_h_more)'),
			navItemMoreWidth = navItemWidth = $navItemMore.width(),
			windowWidth = Math.floor($('.j_h_menu').width());
	//		navItemMoreLeft, offset, navOverflowWidth;

		$navItems.each(function() {
			navItemWidth += $(this).width();
		});

		navItemWidth = Math.floor(navItemWidth);

		navItemWidth > windowWidth ? $navItemMore.show() : $navItemMore.hide();

		while (navItemWidth > windowWidth)
		{
			navItemWidth -= $navItems.last().width();
			$navItems.last().prependTo('.j_h_inside').toggleClass('i_hm_select', false);
			$navItems.splice(-1,1);
		}

		$('.j_h_menu').find('.j_hm_ul:hidden').css('display', '');

		navHmSelected();

		var s = $('.j_hm_li.i_hm_select').children('.j_hm_sub');
		if( s.length )
			navHmPosition( s );

	}

	function navHmResizeMobile()
	{

		var x = $('.j_hmt_x');

		if( $('.j_h_inside').length && $('.j_h_inside li').length )
			$('.j_h_menu li.j_h_more').before($('.j_h_inside > li'));

		/*if( $('.j_h_menu').find('.i_hm_selected').length )
			x.toggleClass('i_hmt_x_selected', true);
		else
			x.toggleClass('i_hmt_x_selected', false);*/

	}

	// Выделение пункта меню 'Ещё' и скрывание подменю при ресайзе
	function navHmSelected()
	{

		var m = $('.j_h_more');

		if( $('.j_h_inside').find('.i_hm_selected').length )
			m.addClass('i_hm_selected');
		else
			m.removeClass('i_hm_selected');

	}

	function navHmPosition(th)
	{

		var w = $('.j_h_menu_bl').width();

		var ul = th.siblings('ul.j_hm_ul');

		var pl = th.position().left;
		var pr = pl+th.innerWidth();
		var ulw = ul.innerWidth();

		//console.log(w, ul, pl, pr, ulw);

		// ширина под меню < меню до правой границы
		if( ulw<pr )
			ul.css({ 'right':(w-pr), 'left':'auto' });

		// ширина под меню < ширина меню - меню до левой границы 
		if( ulw<(w-pl) )
			ul.css({ 'left':pl, 'right':'auto' });

	}

	var hm_w = 920;// width resize Desktop - Mobile

	$(window).resize(function(){
		var w = $(window).width();

		w>hm_w ? navHmResizeDesktop() : navHmResizeMobile();
	});

	$('body').on('click', '.j_hm_sub', function(){
		var th = $(this);
		var pr = th.parent('li.j_hm_li');
		var sb = th.siblings('ul.j_hm_ul');

		var w = $(window).width();// Width
		var d = w>hm_w && pr.parent('.j_h_menu').length;// Desktop
		var m = w<=hm_w;// Mobile

		if( d )
			return;

		// reset
		sb.css({
			'right': '',
			'left': ''
		});

		if( d && pr.is(':not(.i_hm_select)') && $('.i_hm_select').length )
			$('.i_hm_select').toggleClass('i_hm_select', false).children('ul.j_hm_ul').hide();

		pr.toggleClass('i_hm_select');

		if( d )
			sb.fadeToggle();
		else if( m )
			sb.slideToggle();

		navHmPosition(th);

		if( m )
			return false;
	});

	$('body').on('mouseenter', '.j_hm_sub', function () {
		var th = $(this);
		var sb = th.siblings('ul.j_hm_ul');
		var pr = th.parent('li.j_hm_li');
		var w = $(window).width();// Width
		var d = w>hm_w && pr.parent('.j_h_menu').length;// Desktop
		var m = w<=hm_w;// Mobile

		if(d) {
			//console.log('hello');

			sb.css({
				'right': '',
				'left': ''
			});

			navHmPosition(th);
		}
	});

	$(window).width()>hm_w ? navHmResizeDesktop() : navHmResizeMobile();

	$('body').on('click', '.j_hm_title', function(){
		var th = $(this);
		var ul = th.siblings('.j_h_menu');
		var x = th.find('.j_hmt_x');

		ul.slideToggle(400, function(){
			if( $(this).is(':hidden') )
				$('.j_h_menu').css('display', '')
		});

		x.toggleClass('i_hmt_x_select');
	});

});
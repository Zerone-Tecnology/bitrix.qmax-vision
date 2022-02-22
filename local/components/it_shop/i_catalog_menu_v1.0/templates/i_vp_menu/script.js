// ---------------------------------------------------------------------------------------------------- [iLaB Script]
$(document).ready(function(){

	function navVpResizeDesktop(state)
	{

		if( $('.j_vpt_x').is('.i_vpt_x_select') )
		{
			$('.j_vp_menu').css('display','');
			$('.i_vp_column_cont').hide();
			$('.j_vpt_x').removeClass('i_vpt_x_select');
            $('.i_arrow_bot').hide();
		}

		$('.j_vp_menu li.j_vp_more').before($('.j_vp_inside > li'));

		var $navItemMore = $('.j_vp_menu > li.j_vp_more').show(),
			$navItems = $('.j_vp_menu > li:not(.j_vp_more)'),
			navItemMoreWidth = navItemWidth = $navItemMore.width(),
			windowWidth = Math.floor($('.j_vp_menu').width());
	//		navItemMoreLeft, offset, navOverflowWidth;

		$navItems.each(function() {
			navItemWidth += $(this).width();
		});

		navItemWidth = Math.floor(navItemWidth);

		navItemWidth > windowWidth ? $navItemMore.show() : $navItemMore.hide();

		while (navItemWidth > windowWidth)
		{
			navItemWidth -= $navItems.last().width();
			$navItems.last().prependTo('.j_vp_inside').toggleClass('i_vp_select', false);
			$navItems.splice(-1,1);
		}

		$('.j_vp_menu').find('.j_vp_ul:hidden').css('display', '');

		navVpSelected();

		var s = $('.j_vp_li.i_vp_select').children('.j_vp_sub');
		if( s.length )
			navVpPosition( s );
	}

	function navVpResizeMobile(state)
	{

		var x = $('.j_vpt_x');

        if( $('.j_vpt_x').is('.i_vpt_x_select') )
        {
            $('.j_vp_menu').css('display','');
            $('.i_vp_column_cont').hide();
            $('.i_arrow_bot').hide();
            $('.j_vpt_x').removeClass('i_vpt_x_select');
        }

		if( $('.j_vp_inside').length && $('.j_vp_inside li').length )
			$('.j_vp_menu li.j_vp_more').before($('.j_vp_inside > li'));

		/*if( $('.j_vp_menu').find('.i_vp_selected').length )
			x.toggleClass('i_vpt_x_selected', true);
		else
			x.toggleClass('i_vpt_x_selected', false);*/

	}

	// Выделение пункта меню 'Ещё' и скрывание подменю при ресайзе
	function navVpSelected()
	{

		var m = $('.j_vp_more');

		if( $('.j_vp_inside').find('.i_vp_selected').length )
			m.addClass('i_vp_selected');
		else
			m.removeClass('i_vp_selected');

	}

	function navVpPosition(th) {

        var h = $('.i_vp_li_cont').height();

        var dl = th.siblings('div.i_vp_column_cont');
        var ul = dl.find('ul.i_vp_ul');
        var pl = th.position().left;
        var pr = pl + th.innerWidth();
        var ulh = ul.innerHeight();
        var pt = th.position().top;

        var ulww = ul.innerWidth();
        var ww = document.body.clientWidth;
        var wh = $(window).height();
        var vp_h = 640;
        var li = $('.i_vp_li_cont').children('.i_vp_li.i_vp_select');
        var offset = h-(ulh+pt);

        if (ww > vp_h) {
                li.children('.i_arrow_block_in').fadeToggle().css({'top': pt+20});
                li.children('.i_arrow_block_on').fadeToggle().css({'top': pt+14});

			if(pt>400) {
				dl.css({'top': 'unset', 'bottom': '20px' });
			}

			else {
                dl.css({'top': pt});
			}

            /*if (ulww + pr > ww - pr) {
                dl.css({'right': '20px'})
            }*/
            if (offset<0) {
				$('.scroll-wrapper.i_vp_column_cont').css({'bottom': '20px', 'top': 'unset'});
			}

			else {
                $('.scroll-wrapper.i_vp_column_cont').css({'bottom': 'unset'});
			}

            // Максимальная высота по меню 1-го уровня
            if (ulh > h) {
                dl.css({'max-height': wh-(wh/4) })
            }
        }
    }

	var vp_w = 640;// width resize Desktop - Mobile
    var bw = $(window).width();
    var state = 'e';

    bw>vp_w ? state = 'd' : state = 'm';

	$(window).resize(function(){
        var w = $(window).width();

        if( (w>vp_w) && (state != 'd') )
        {
        	state = 'd';
			navVpResizeDesktop(state);

		}
		else if ((w<vp_w) && (state != 'm'))
		{
        	state = 'm';
            navVpResizeMobile(state);
		}
	});

	$('body').on('click', '.j_vp_sub', function(){
		var th = $(this);
		var pr = th.parent('li.j_vp_li');
		var dsb = th.siblings('div.i_vp_column_cont');
        var usb = dsb.find('ul.j_vp_ul');
        var mul = th.siblings('ul.j_vp_ul');

		var w = $(window).width();// Width
		var d = w>vp_w && pr.parent('.i_vp_li_cont').length;// Desktop
		var m = w<=vp_w;// Mobile

		if( d && pr.is(':not(.i_vp_select)') && $('.i_vp_select').length )
		{
            dsb.hide();
            $('.i_arrow_block_in').hide();
            $('.i_arrow_block_on').hide();
            $('.i_vp_select').toggleClass('i_vp_select', false).children('div.i_vp_column_cont').hide();
		}

		pr.toggleClass('i_vp_select');

		if( d ) {
            dsb.fadeToggle();
            $('.i_arrow_block_in').fadeOut();
            $('.i_arrow_block_on').fadeOut();
            //jQuery('.scrollbar-outer').scrollbar();

            $(document).on('click', function (e) {
                if (!$(e.target).closest(".j_vp_ul").length) {
                	$('.i_arrow_block_in').fadeOut();
                	$('.i_arrow_block_on').fadeOut();
                    $('div.i_vp_column_cont').fadeOut('callback');
                    $('.i_vp_select').toggleClass('i_vp_select', false).children('div.i_vp_column_cont').fadeOut('callback');
                }
                e.stopPropagation();
            });

        }
		else if( m )
		{
            dsb.slideToggle();
            mul.slideToggle();
		}

		navVpPosition(th);

		if( d || m )
			return false;
	});

	$(window).width()>vp_w ? navVpResizeDesktop() : navVpResizeMobile();

	$('body').on('click', '.j_vp_title', function(){
		var th = $(this);
		var ul = th.siblings('.j_vp_menu');
		var x = th.find('.j_vpt_x');
		var h = $(window).height();
		var ch = $('.i_vp_li_cont').height();

		ul.fadeToggle(400, function(){
			if( $(this).is(':hidden') )
				$('.j_vp_menu').css('display', '')
		});

        $('.i_arrow_bot').fadeToggle(50);

		x.toggleClass('i_vpt_x_select');
		if (ch<h)
		{
            $('.i_vp_li_cont').css({'max-height': h-120 });
		}
});

    //---------------------------------------------------------------------------------------------Scroll
    jQuery('.j_vp_scrollbar').scrollbar({
        "disableBodyScroll": true,
	});
    jQuery('.scrollbar-outer').scrollbar({
        "disableBodyScroll": true,
	});
});
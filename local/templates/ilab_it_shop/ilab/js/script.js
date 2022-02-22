// ---------------------------------------------------------------------------------------------------- iLaB Script | FUNCTIONS [local/templates/ilab_it_shop/ilab/js/functions.js]
$(document).ready(function(){

	if($('.i_basket_wrap').length != 1)
	{
		setTimeout(function() {
			$('input, select').styler();
		}, 100);
	}

	// Новости на всю ширину если нет акций в широком варианте
	if( !$('.i_action_wide').length )
		$('.i_new_wide').addClass('i_new_fwidth');
// ---------------------------------------------------------------------------------------------------- Клик вне элемента
	i_outside_element('.jq_sub, .jq_modal, .jq_login_a, .jq_buy_succes, .jq_compare_succes, .jq_item_compare, .jq_item, .jq_vmenu_out, .jqc_vmenu_out, .jq_vmenu_catalog, .jqc_vmenu_catalog, .jq_add_review, .jq_reviews_reply_form, .jq_hmenu, .bx_filter_popup_result, .i_cele .jq_mbuy, .jq_ba_terms_of_use, .jq_copnumb, .jq_order_buy');
// ---------------------------------------------------------------------------------------------------- Принудительная загрузка img в скрытых стилях
	if( $('.jq_banner').find('div[jqpreimg]').length )
	{
		$('.jq_banner div[jqpreimg]').each(function(i,e){
			jQuery.preLoadImages($(e).attr('jqpreimg'));
		});
	}

	jQuery.preLoadImages('/local/templates/ilab_it_shop/ilab/img/loader.gif', '/local/templates/ilab_it_shop/ilab/img/recaptcha_anim.gif', '/local/templates/ilab_it_shop/ilab/img/recaptcha.gif');
// ---------------------------------------------------------------------------------------------------- [Globals]
	window.i_topmenu = $('.i_topmenu').width()-70;// Ширина меню (-минус) ширина для кнопки 'Ещё'
	window.i_vermenu = $('.jq_vmenu_out').height()-33;//-33(последний пунк для плашки раскрытия)
	window.i_hedetxt = $('.jq_dtxt').innerHeight();
	window.i_vl_menu = $('.jq_vmenu .jq_vmenu_div_1').length;// Количество эл. вертикального меню Каталога
	window.i_tl_menu = $('.jq_tm_item').length;// Количество эл. верхнего меню
// ---------------------------------------------------------------------------------------------------- Пойск
	$('.jq_search input[type="text"]').focus(function(){
		if ($(this).val()=='Поиск по каталогу') $(this).val('');
		if ($(this).val()=='Search the catalog') $(this).val('');
	});
	$('.jq_search input[type="text"]').blur(function(){
		if ($(this).val()=='')$(this).val('Поиск по каталогу');
	});
// ---------------------------------------------------------------------------------------------------- Banner
	if( $('.jq_banner').length )
	{
		var bannerSwiper = new Swiper('.jq_banner',
		{
			loop: true,
			grabCursor: true,

			autoplay: {
				delay: 5321
			},

			pagination: {
				el: $(this).siblings('.jq_banner-pagination'),
				dynamicBullets: true,
//				type: 'bullets',// "bullets", "fraction", "progressbar" or "custom"
				clickable: true,
			},

			on: {
				init: function (swiper) {
					var jqimg = $('.jq_banner').find('.swiper-slide-active').attr('jqimg');

					if( jqimg )
					{
						$('.jq_ban_bg').css({'background': jqimg})
							.animate({opacity: 1});
					}
				},
				slideChangeTransitionStart: function (swiper, direction) {
					var jqimg = $('.jq_banner').find('.swiper-slide-active').attr('jqimg');

					if( jqimg )
					{
						$('.jq_ban_bg').animate({opacity: 0}, 'fast', function() {
							$(this)
								.css({'background': jqimg})
								.animate({opacity: 1});
						});
					} else if( $('.jq_banner').find('.swiper-slide[jqimg]').length ) {
						$('.jq_ban_bg').animate({opacity: 0}, 'slow', function() {
							$(this)
								.css({'background': ''})
								.animate({opacity: 1});
						});
					}
				}
			}
		});
		$('.jq_banner-left').on('click', function(e){
			e.preventDefault()
			bannerSwiper.swipePrev()
		});
		$('.jq_banner-right').on('click', function(e){
			e.preventDefault()
			bannerSwiper.swipeNext()
		});
	} else if( $('.i_banner').find('.swiper-slide[jqimg]').length ) {
		var jqimg = $('.i_banner').find('.swiper-slide[jqimg]').attr('jqimg');

		$('.jq_ban_bg').css({'background': jqimg})
			.animate({opacity: 1});
	}
// ---------------------------------------------------------------------------------------------------- rBanner
	if( $('.jq_lbanner').length )
	{
		var lbannerSwiper = new Swiper('.jq_lbanner', {// API Swiper - http://www.idangero.us/swiper/api/
			wrapperClass: 'swiper-wrapper',
			slideClass: 'swiper-slide',
			slideActiveClass: 'swiper-slide-active',
			slideVisibleClass: 'swiper-slide-visible',

			loop: true,
			grabCursor: true,

			autoplay: {
				delay: 5321
			}
		});
	}
// ---------------------------------------------------------------------------------------------------- botoom Banner main
	if( $('.jq_main_banner').length )
	{
		var lbannerSwiper = new Swiper('.jq_main_banner',
		{
			loop: true,
			grabCursor: true,

			autoplay: {
				delay: 5321
			}
		});
	}
// ---------------------------------------------------------------------------------------------------- Топ меню
	var i_w = $(window).width();
	i_tm_class(i_w);
	if( i_w>639 )
		i_tm_more_restart();

	if($(window).width()>639)
	{
		$('body').on('click', '.jq_tm_a', function(){// Клик на пункт меню 1ур.

			// $(this).parents('.i_tm_item').siblings('.i_tm_item').find('.jq_sub, .jq_mo').hide();
			// $(this).parents('.i_tm_item').siblings('.i_tm_item').find('.jq_tm_a').removeClass('i_tm_hover');

			$('.jq_sub, .jq_mo').hide();// Скроем все под-меню 2ур.-3ур.
			$('.jq_tm_a').removeClass('i_tm_hover');// Уберём весь hover с 1ур.

			if( $(this).siblings('.jq_sub').length > 0 ) // Если есть под-меню
			{
				$(this).addClass('i_tm_hover').siblings('.jq_sub').show();// Показать hover/под-меню
				return false;
			}
			else
			{
				$('.jq_tm_a').removeClass('i_tm_selected');// Уберём весь selected с 1ур.
				$(this).addClass('i_tm_selected');// Выделим пункт меню 1ур. в которое перешли
			}
		});
		$('body').on('click', '.jq_sub_a', function(){// Клик на пункт меню 2ур.
			if( !$(this).is('.ijq_hsub') )// Если нет подуровней
			{
				$('.jq_tm_a').removeClass('i_tm_selected');// Уберём весь hover с 1ур.
				$('.jq_sub_a').removeClass('i_sub_selected i_mo_selected');// Уберём весь selected c 2ур.
				$('.jq_mo').hide();// Скроем все под-меню 3ур.
				$(this).addClass('i_sub_selected');// Выделим пункт меню 2ур. в которое перешли
			}
		});
		$('body').on('click', '.i_mo_a', function(){// Клик на пункт меню 3ур.
			$('.jq_tm_a').removeClass('i_tm_selected');// Уберём весь selected с 1ур.
			$('.jq_sub_a').removeClass('i_sub_selected i_mo_selected');// Уберём весь selected c 2ур.
			$('.jq_mo_a').removeClass('i_sub_selected');// Уберём весь selected c 3ур.
			$(this).addClass('i_sub_selected').parents('.jq_mo').siblings('.jq_sub_a').addClass('i_sub_selected');// Выделим пункт меню 3ур. в которое перешли и кнопку 'Еще'
		});
		$('body').on('click', '.ijq_hsub', function(){// Клик на пункт меню 2ур. с под-меню (пункт меню в кнопочке Еще)
			$('.jq_mo').hide();// Скроем все под-меню 3ур.
			$('.ijq_hsub').removeClass('i_sub_selected');// Уберём selected с меню 2ур.(имеющий подуровень)
			$(this).addClass('i_sub_selected').siblings('.jq_mo').show();// Выделим пункт меню 2ур. с под-меню/покажем под-меню
			return false;
		});
	}
// ---------------------------------------------------------------------------------------------------- [i_vmenu]
	$('.jq_ver_shapeshift').each(function(){
		var col=4;

		if( $(this).parent('.jq_vsub_1').attr('jq_vm_col') )
			var col	= +$(this).parent('.jq_vsub_1').attr('jq_vm_col');

		if( $(this).children('.jq_item').length>0 && !$(this).parent('.jq_vsub_1').attr('jq_vm_col') )
			col -= 1;

		$(this).shapeshift({// API Shapeshift - https://github.com/McPants/jquery.shapeshift/wiki/2.0-api-documentation | Demo - http://mcpants.github.io/jquery.shapeshift/
			// The Basics
			selector:			'.i_vmenu_div_2',
			// Features
			enableDrag:			false,
			enableCrossDrop:	false,
			// Drag/Drop Options
			dragClone:			false,
			// Grid Properties
			align:				'left',
			columns:			col,
			minHeight:			null,
			gutterX:			0,
			gutterY:			0,
			paddingX:			0,
			paddingY:			0
		});

		$(this).parents('.jq_vsub_1').addClass('idnone');// fixed height footer
	});

	$('.jq_vmenu .jq_vmenu_div_1').each(function(indx){
		var pt = $(this).position().top;
		var he = $(this).children('.jq_vsub_1').height();
		var th = pt+$(this).height();

//		console.log( window.i_vl_menu+' | '+indx+' | '+pt+' | '+he+' | '+th+' | '+window.i_vermenu )

		if( he<pt )
			$(this).addClass('iprel').children('.jq_vsub_1').addClass('i_vmb');
		if( window.i_vermenu<th && $('.jq_vmenu').is('.i_vmenu') )
			$(this).addClass('jq_vmenu_hide idnone');
		if( window.i_vl_menu == (indx+1) )
			$('.jq_vmenu_out').css('overflow', 'visible');
	});
	$('body').on('click', '.jq_vmenu_arrow', function(){
		$('.jq_vmenu_arrow').parent('.i_vmenu_div_1').removeClass('i_vmenu_div_1_activ');
		$('.jq_vsub_1').css('visibility', 'hidden').hide();
		$(this).parent('.i_vmenu_div_1').addClass('i_vmenu_div_1_activ').children('div').css('visibility', 'visible').show();
		return false;
	});
	$('.jq_vmenu_catalog, .jq_buttom_vmenu').click(function(){
		var vme = $('.jq_vmenu_catalog').siblings('.jq_vmenu_out');
		if( vme.find('.jq_vmenu_hide:hidden').length>0 )
		{
			$('.jq_vmenu_hide').show();
			vme.addClass('i_vmenu_box').animate({height: (vme.children('.jq_vmenu_in').height()) },500, function(){
				$('.jq_buttom_vmenu').addClass('i_buttom_vmenu_activ');
			});
			$('.jq_vmenu_catalog').children('.jq_vmenu_catarr').addClass('i_vmenu_carrt');
		}else
			i_hide_vmenu(vme);
	});
	$('body').on('click', '.jqc_vmenu_catalog', function(){
		var jqc_vo = $('.jqc_vmenu_out');
		var jqc_th = $(this);

		if( jqc_vo.is('.jqc_open') )
		{
			$(this).children('.jq_vmenu_catarr').removeClass('i_vmenu_carrt');
			jqc_vo.removeClass('i_vmenu_box jqc_open').slideUp(function(){ jqc_th.addClass('ibr5i'); });
		}else{
			$(this).children('.jq_vmenu_catarr').addClass('i_vmenu_carrt');
			$(this).removeClass('ibr5i');
			jqc_vo.addClass('i_vmenu_box jqc_open idnone').removeClass('ivhid').slideDown();
		}
	});
// ---------------------------------------------------------------------------------------------------- [i_hmenu]

	if( $(window).width() > 1000 )
	{
		$('.jq_hor_shapeshift').each(function(i){
			var col	= 3;
//			var att = +$(this).parent('.jq_hsub_1').attr('jq_hm_col');

			if( $(this).parent('.jq_hsub_1').attr('jq_hm_col') )
				var col	= +$(this).parent('.jq_hsub_1').attr('jq_hm_col');

			//if( $(this).children('.jq_item').length>0 && !$(this).parent('.jq_hsub_1').attr('jq_hm_col') )
			//	col -= 1;

//		console.log(i+' element | = '+col);

			$(this).shapeshift({// API Shapeshift - https://github.com/McPants/jquery.shapeshift/wiki/2.0-api-documentation | Demo - http://mcpants.github.io/jquery.shapeshift/
				// The Basics
				selector:			'.i_hmenu_div_2',
				// Features
				enableDrag:			false,
				enableCrossDrop:	false,
				// Drag/Drop Options
				dragClone:			false,
				// Grid Properties
				align:				'left',
				columns:			col,
				minHeight:			null,
				gutterX:			0,
				gutterY:			0,
				paddingX:			0,
				paddingY:			0
			});
		});
	}

	// $('.jq_hmenu_arrow').click(function(){
	// 	закоменченая область
	// 	var menu 	= $('.jq_hsub_1[jq_hm_open='+$(this).attr('jq_hm_open')+']');
	// 	var menu_l	= $(this).position().left;
	// 	var menu_r	= menu_l+$(this).innerWidth();
	// 	var menu_w 	= menu.innerWidth();
	//
	// 	if( menu.css('visibility')=='visible' )
	// 	{
	// 		$(this).removeClass('i_hmenu_a_1_activ');
	// 		$('.jq_hsub_1').css('visibility', 'hidden');
	// 	}
	// 	else
	// 	{
	// 		$('.jq_hmenu_arrow').removeClass('i_hmenu_a_1_activ');
	// 		$('.jq_hsub_1').css('visibility', 'hidden');
	//
	// 		//		console.log(menu_l+' | '+menu_r+' | '+menu_w);
	//
	// 		if( menu_w<menu_r )
	// 			menu.css({ 'right':(940-menu_r),'left':'auto' });
	//
	// 		if( (940-menu_l)>menu_w )
	// 			menu.css( 'left',menu_l );
	//
	// 		menu.css('visibility', 'visible');
	// 		$(this).addClass('i_hmenu_a_1_activ');
	// 	}
	//
	// 	return false;
	// });
	$('.jq_hmenu_arrow').on('mouseenter', function(){
		var menu 	= $('.jq_hsub_1[jq_hm_open='+$(this).attr('jq_hm_open')+']');
		var menu_l	= $(this).position().right;
		var menu_r	= menu_l+$(this).innerWidth();
		var menu_w 	= menu.innerWidth();

		if( menu.css('visibility')=='visible' )
		{
			$(this).removeClass('i_hmenu_a_1_activ');
			$('.jq_hsub_1').css('visibility', 'hidden');
		}
		else
		{
			$('.jq_hmenu_arrow').removeClass('i_hmenu_a_1_activ');
			$('.jq_hsub_1').css('visibility', 'hidden');

			//		console.log(menu_l+' | '+menu_r+' | '+menu_w);

			if( menu_w>menu_r )
				menu.css({ 'left':(940-menu_r),'right':'auto' });

			if( (940-menu_l)>menu_w )
				menu.css( 'right',menu_l );

			menu.css('visibility', 'visible');
			$(this).addClass('i_hmenu_a_1_activ');
		}

		return false;
	});
	$('.jq_hmenu_arrow').on('mouseleave', function () {
		/*var menu 	= $('.jq_hsub_1[jq_hm_open='+$(this).attr('jq_hm_open')+']');
		var menu_l	= $(this).position().right;*/

	});
// ---------------------------------------------------------------------------------------------------- [Basket]
	// Кнопка купить
	$('body').on('click', '.jq_buy', function(){
		var th			= $('.jq_buy[jq_id="'+$(this).attr('jq_id')+'"]');
		var url			= '/local/templates/ilab_it_shop/ilab/ajax/basket/add.php';// Файл ajax
		var id			= $(this).attr('jq_id');// id
		var type		= 'N';
		var sku_code	= $('.i_sku_code').val();
		var lid			= $('.jq_hbask').attr('jq_lid');
		var quan		= 1;

//		var $name		= $(this).attr('name');
//		var $price		= $(this).attr('price');

		var m_succes	= th.siblings('.jq_buy_succes');
		var m_s_quan	= +m_succes.data('quan') || 100000;
//		var m_s_id      = $('.jq_bought').attr('jq_id');

		var mbuy = th.parents('.jq_mbuy');

		if( $(this).attr('jqcount').length )// Количество
			var quan		= + $(this).attr('jqcount');
		i_hide('BUY_MENU');

		if( id )
		{
			if( $('.jq_select_offers').length )
				$('.jq_select_offers').stop().hide(0);

//			if( $(this).is('.icard_buy_buttom') && $(this).siblings('.jq_count').length )
//				$(this).siblings('.jq_count').hide();

			if( mbuy.length )
				mbuy.siblings('.jq_datext').hide(0);

			th.hide(0)
//				.siblings('.jq_count').hide()
				.siblings('.jq_bought').addClass('i_buy_loader').fadeIn(500).css('display', 'flex')
//				.attr('jqbacount', m_s_quan<quan ? m_s_quan : quan )// коментирование специфики i-store
				.siblings('.jq_delete_item').fadeIn(500)//.data('id', id).attr('jqid', id)
				.siblings('.jq_bought').find('.j_m_ratio').text( m_s_quan<quan ? m_s_quan : quan );// коментирование специфики i-store

			i_addBasket(url, id, quan, type, lid, sku_code, m_succes, mbuy, m_s_quan/*, $name, $price*/);

		} else {
			$('.jq_select_offers').fadeIn(400)
				.delay(10000).fadeOut(400);
		}

		if( $(this).is('.jq_buy_scroll') && !$(this).attr('jq_id') )
			$('html, body').animate({scrollTop:0},'slow')

		return false;
	});
	// Кнопка купить
	/*$('body').on('click', '.jq_buy', function(){
		var th			= $('.jq_buy[jq_id="'+$(this).attr('jq_id')+'"]');
		var url			= '/local/templates/ilab_it_shop/ilab/ajax/basket_add_she.php';// Файл ajax
		var id			= $(this).attr('jq_id');// id
		var type		= 'N';
		var basketid	= $('.jq_basket_id').val();
		var sku_code	= $('.i_sku_code').val();
		var lid			= $('.jq_hbask').attr('jq_lid');
		var quan		= 1;

//		var $name		= $(this).attr('name');
//		var $price		= $(this).attr('price');

		var m_succes	= $(this).siblings('.jq_buy_succes');
		var m_s_quan	= +m_succes.data('quan') || 100000;
//		var m_s_id      = $('.jq_bought').attr('jq_id');

		if( $(this).attr('jqcount').length )// Количество
			var quan		= + $(this).attr('jqcount');
		i_hide('BUY_MENU');

		if( id )
		{
			if( $('.jq_select_offers').length )
				$('.jq_select_offers').stop().hide(0);

//			if( $(this).is('.icard_buy_buttom') && $(this).siblings('.jq_count').length )
//				$(this).siblings('.jq_count').hide();

			th//.hide(0)
				//.siblings('.jq_count').hide()
				.siblings('.jq_bought').addClass('i_buy_loader').fadeIn(500).css('display', 'flex')
//				.attr('jqbacount', m_s_quan<quan ? m_s_quan : quan )// коментирование специфики i-store
//				.siblings('.jq_delete_item').fadeIn(500).data('id', id).attr('jqid', id)
				.find('.j_m_ratio').text( m_s_quan<quan ? m_s_quan : quan );// коментирование специфики i-store

			i_addBasketFavorite(url, id, quan, type, lid, sku_code, m_succes, m_s_quan);

		} else {
			$('.jq_select_offers').fadeIn(400)
				.delay(10000).fadeOut(400);
		}

		if( $(this).is('.jq_buy_scroll') && !$(this).attr('jq_id') )
			$('html, body').animate({scrollTop:0},'slow')

		return false;
	});*/
	/*$('body').on('click', '.jq_buy', function(){
		var th			= $('.jq_buy[jq_id="'+$(this).attr('jq_id')+'"]');
		var url			= '/local/templates/ilab_it_shop/ilab/ajax/basket_add_she.php';// Файл ajax
		var id			= $(this).attr('jq_id');// id
		var type		= 'N';
		var basketid	= $('.jq_basket_id').val();
		var sku_code	= $('.i_sku_code').val();
		var lid			= $('.jq_hbask').attr('jq_lid');
		var quan		= 1;
		var m_succes	= $(this).siblings('.jq_buy_succes');
		var m_s_quan	= +m_succes.data('quan');
		var m_s_id      = $('.jq_bought').attr('jq_id');
		if( $(this).attr('jqcount').length )// Количество
			var quan		= + $(this).attr('jqcount');
		i_hide('BUY_MENU');

		if( id )
		{
			if( $('.jq_select_offers').length )
				$('.jq_select_offers').stop().hide(0);

//			if( $(this).is('.icard_buy_buttom') && $(this).siblings('.jq_count').length )
//				$(this).siblings('.jq_count').hide();

			th.hide(0)
				.siblings('.jq_bought').addClass('i_buy_loader').css('display','inline-block');
			if( bid = i_addBasketFavorite(url, id, quan, type, lid, sku_code) )
			{
				$('.jq_basket_id').val( basketid+id+'↕' );
				if ( !$(this).attr('jq_compare') =='Y' )
				{
					$(this).parents('.jq_item').find('.jq_favorite').attr('jq_bid','').removeClass('i_item_favorite_act').find('span').text($(this).parents('.jq_item').find('.jq_favorite').data('change_text').txt_default);
					$(this).parents('.jq_item').find('.j_favorite_succes').stop().fadeOut(400)// FADEOUT(очистка очереди)
				}
				th.siblings('.jq_bought').removeClass('i_buy_loader');

				if( m_s_quan<quan ) {
					m_succes.find('.j_q_m').text(m_s_quan).parents('.j_quan_miss').show().delay(10000).fadeOut(400);
					th.siblings('.jq_bought').attr('jqbacount', m_s_quan);
				} else
					m_succes.find('.j_bask_succes').show().delay(10000).fadeOut(400);
				m_succes.fadeIn(400)
					.delay(10000).fadeOut(400);
				th.siblings('.jq_delete_item').attr('jqid', bid).show();
			}
		} else {
			$('.jq_select_offers').fadeIn(400)
				.delay(10000).fadeOut(400);
		}

		if( $(this).is('.jq_buy_scroll') && !$(this).attr('jq_id') )
			$('html, body').animate({scrollTop:0},'slow')

		return false;
	});*/
	// Закрытие окна succes покупки
	$('.jq_bs_close').click(function(){
		$('.jq_buy_succes, .jq_select_offers').stop().fadeOut(400);// FADEOUT(очистка очереди)
		$('.jq_chec_modal').fadeOut();

		return false;
	});
	$('.jq_bat_close').click(function(){
		$('.jq_ba_terms_of_use').fadeOut();

		return false;
	});
	$('.jq_ba_ss_close').click(function(){
		$('.jq_ba_m_steaker_status').fadeOut();

		return false;
	});
// ---------------------------------------------------------------------------------------------------- Удалить товар с корзины
	$('body').on('click', '.jq_bs_delete', function(){
		var th		= $(this);
		var id		= th.parents('.jq_basket_item').attr('id');

		th.parents('.jq_basket_item')
			/*.children('td, th')
			.animate({ paddingBottom: 0, paddingTop: 0 })
			.wrapInner('<div />')
			.children()*/
			.slideUp(600, function() {
				$(this).remove();
			});

		if( il_basket_del_item(id) == 'true' )
		{
			if( $('.jq_basket_item').length == 1 )
			{
				$('#basket_items_list, .bx_sort_container').hide();
				$('.jqba_bask_last').fadeIn();
			} else
				recalcBasketAjax({});// ilabitrix
		}

		return false;
	});
	/*
	 $('.jq_bs_delete').click(function(){
	 var th = $(this);
	 $.post(
	 th.attr('href'),
	 function(z)
	 {
	 th.parents('.jq_basket_item')
	 .children('td, th')
	 .animate({ padding: 0 })
	 .wrapInner('<div />')
	 .children()
	 .slideUp(function() {
	 $(this).closest('tr').remove();
	 });

	 //				console.log($('.jq_basket_item').length);

	 if( $('.jq_basket_item').length == 1 )// Перезагрузим страницу если последний элементы
	 location.reload();

	 recalcBasketAjax({});// Пересчитали сумму итого
	 }
	 );

	 return false;
	 });
	 */
// ---------------------------------------------------------------------------------------------------- Order
	il_aemail();
// ---------------------------------------------------------------------------------------------------- [SKU]
	/*
	 $('.jq_sku_ul').on('click', '.jq_sku_ele:not(.jq_sku_ex)', function(){//:not(.jq_sku_ex)
	 var reg			= $(this).attr('jq_sku_id');
	 var sec			= $(this).parent('.jq_sku_ul').attr('jq_sec');
	 var first		= $('.jq_sku').find('.i_sku_check').length==0	? true : false;
	 var sib_check	= $(this).siblings('.i_sku_check').length==0	? false : true;

	 console.log( reg+' | '+sec+' | '+first+' | '+sib_check );

	 if( first )// Если первый клик
	 {

	 }

	 if( !first )
	 {

	 $('.i_sku_check').each(function(i){
	 reg += '|'+$(this).attr('jq_sku_id');
	 });
	 var reg_arr = reg.split('|');
	 //			console.log(reg+' | '+reg_arr);

	 // Удалим повтор элементов
	 var arr = unique(reg_arr);
	 //			console.log( arr );

	 // Если элемент встречается больше 2 раз то в массив
	 var result = [];
	 for(i in arr)
	 if( substr_count(reg, arr[i])>1 )
	 result.push(arr[i]);

	 console.log( result.join('|') );
	 reg = result.join('|');

	 }

	 if( sib_check )// Если клик рядом
	 $(this).siblings('.i_sku_check').removeClass('i_sku_check');

	 var reg = RegExp(reg,'i');
	 $('.jq_sku_ele').each(function(i){//:not(.jq_sku_ex)
	 var esec		= $(this).parent('.jq_sku_ul').attr('jq_sec');
	 var reg_exec	= $(this).attr('jq_sku_id');

	 if( !reg.exec(reg_exec) && sec!=esec )
	 $(this).addClass('i_sku_ex jq_sku_ex');

	 });

	 $(this).addClass('i_sku_check');

	 });
	 */
//	console.log($.parseJSON($('.i_sku_json').val()));
	$('.jq_sku_ele').on('click', function(){
		i_hide();
		var $th = $(this);
		if(!$th.hasClass('i_sku_noact')) // если свойство можно кликнуть
		{
			var $pid = $th.attr('jq_parent');
			var $value = $th.attr('val');
			var $skuff = $('.i_sku_ff');
			var $ffinal = $('.i_sku_ffinal');
			var $ffilter = $('.i_sku_ffilter');
			var $skulast = $('.i_sku_last');
			var $ff = [];
			var $step = $('.i_sku_step');
			var $arstep = [];
			var $strstep = '';
			var $skuid = $('.i_sku_id');
			var $fid = 0;
			var $count = $skuff.attr('count');
			var $countnow = 0;
			var $tov = 0; // количество отфильтрованных товаров
			if($th.hasClass('i_sku_check')) // если это свойство уже выбрано, убираем выбор
			{
				$skuid.val('');
				$ffinal.val($skuff.val());
				$ffilter.val($skuff.val());
				// удаляем выбранное свойство из фильтра
				var $now = 1;
				var $keynow = 0;
				$arstep = $step.val().split('^');
				$arstep.pop(); // удаляем пустой последний
				$.each( $arstep, function( key, value ) {
					if(value != $value)
						$strstep += value+'^';
					else
						$keynow = key;
				});
				$arstep.splice($keynow, 1); // удалим из массива убранное свойство
				if($arstep.length){ // если остались выбранные свойства
					$('.jq_sku_ele').each(function(){ // активируем все и отфильтруем снова
						if(!$(this).hasClass('i_sku_check'))
							$(this).removeClass('i_sku_noact');
					});
					$.each( $arstep, function( key, valuez ) {
						var $ffin = '';
						$tov = 0;
						$ff = $ffinal.val().split('↕');
						$ff.pop();
						// установим родительскую группу последнего выбранного свойства
						$('.jq_sku_ele').each(function(){
							if($(this).attr('val') == valuez)
								$skulast.val($(this).attr('jq_parent'));
						});
						$('.jq_sku_ele').each(function(){ // деактивируем все кроме текущей группы
							if($skulast.val() != $(this).attr('jq_parent') && !$(this).hasClass('i_sku_check'))
								$(this).addClass('i_sku_noact');
						});
						$.each( $ff, function( key, valuex ) { // найдем выбранное значение
							$ffsplit = valuex.split('^');
							$arSplit = $ffsplit[1].split('#');

							if(in_array(valuez, $arSplit)) // проверим наличие в товаре
							{
								$tov++;
								$('.jq_sku_ele').each(function(){ // деактивируем которых нет
									if(!$(this).hasClass('i_sku_check') && $skulast.val() != $(this).attr('jq_parent')){
										var $value2 = $(this).attr('val');
										if($ffsplit[1].indexOf($value2) != -1)
											$(this).removeClass('i_sku_noact');
									}
								});
								$ffin += $ffsplit[0]+'^'+$ffsplit[1]+'↕';
								$fid = $ffsplit[0];
							}
						});
						$ffilter.val($ffinal.val());
						$ffinal.val($ffin);
						$now++;
					});
				}else{ // если убранное было одним
					$('.jq_sku_ele').each(function(){ // активируем все
						$(this).removeClass('i_sku_noact').removeClass('i_sku_check');
					});
					$skulast.val('');
				}
				$step.val($strstep);
				//@
				$th.removeClass('i_sku_check');
			}
			else // если это свойство еще не выбрано
			{
				// выбрали ту же группу свойств или другую, выбираем нужный массив товаров
				if($skulast.val() == $pid)
					$ff = $ffilter.val().split('↕');
				else{
					$ff = $ffinal.val().split('↕');
					$('.i_sku_ffilter').val($ffinal.val());
				}
				$skuid.val('');
				// выбрали ту же группу свойств или другую, строим путь выбора
				if($skulast.val() == $pid)
				{
					$arstep = $step.val().split('^');
					$arstep.pop(); // удаляем пустой последний
					$arstep.pop(); // удаляем последний выбранный
					$.each( $arstep, function( key, value ) {
						$strstep += value+'^';
					});
					$step.val($strstep+$value+'^');
				}else{
					$step.val($step.val()+$value+'^');
				}
				// получим количество выбранных свойств
				$arstep = $step.val().split('^');
				$arstep.pop(); // удаляем пустой последни
				$countnow = $arstep.length;

				$('.jq_sku_ele').each(function(){
					if($pid == $(this).attr('jq_parent'))
						$(this).removeClass('i_sku_check');
				});
				$tov = 0; // количество отфильтрованных товаров
				var $ffin = '';
				$ff.pop(); // удалим последний пустой
				$('.jq_sku_ele').each(function(){ // деактивируем все не из текущей группы свойств
					if($pid != $(this).attr('jq_parent') && !$(this).hasClass('i_sku_check')){
						$(this).addClass('i_sku_noact');
					}
				});
				$.each( $ff, function( key, value ) { // найдем выбранное значение
					$ffsplit = value.split('^');
					$arSplit = $ffsplit[1].split('#');

					if(in_array($value, $arSplit)) // проверим наличие в товаре
					{
						$tov++;
						$('.jq_sku_ele').each(function(){ // проверим наличие других свойств и активируем которые есть
							if($pid != $(this).attr('jq_parent') && !$(this).hasClass('i_sku_check')){
								var $value2 = $(this).attr('val');
								if($ffsplit[1].indexOf($value2) != -1)
									$(this).removeClass('i_sku_noact');
							}
						});
						$ffin += $ffsplit[0]+'^'+$ffsplit[1]+'↕';
						$fid = $ffsplit[0];
					}
				});
				$ffinal.val($ffin);
				$skulast.val($pid);
				$th.addClass('i_sku_check');
			}

			if($tov == 1){
				$skuid.val($fid);

				i_element_tp_price( $('.i_sku_iblock').val()+'↕'+$fid );// Цены для ТП
				$('.icard_buy .jq_buy').attr('jq_id',$fid);// добавим id в кнопку купить для покупки ТП
				if( $('.icard_buy .jq_order_buy').length )
					$('.icard_buy .jq_order_buy').attr('jq_item_id', $('.i_sku_iblock').val()+'|'+$fid);// добавим id в кнопку заказать для покупки ТП

				$('.j_item_favorite').attr('jq_id',$fid);// добавим id в кнопку избранного для добавления ТП

				if( $('.jq_matrix[jqmpsku='+$fid+']').length )
				{
//					console.log('item');
					$('.jq_matrix').hide();
					$('.jq_matrix[jqmpsku='+$fid+']').show();
					il_mbuy_price($('.jq_conumb'), 1);
				}
			}
		}

		if( $fid && $tov==1 )
		{
			i_element_each($fid);// Кнопки 'Вкорзине'/'Купить' для ТП

			i_element_tp_img( $('.i_sku_iblock').val()+'↕'+$fid );// Картинки для ТП

			$('.jq_quick_order, .jq_unit_quick_order').attr('jq_item_id', $('.i_sku_iblock').val()+'|'+$fid );// Быстрый заказ
		}

		if ($('.j_item_favorite').attr('jq_id').length && $('.jq_favorite_id').data('id').indexOf($('.j_item_favorite').attr('jq_id')) != -1) {
			var id = $('.j_item_favorite').attr('jq_id');
			var ch = $('.j_item_favorite').data('change_text').txt_change;
			var bid = $('.jq_favorite_id').data('bids')[id];

			//console.log($('.jq_favorite_id').data('bids')[id]);

			$('.j_item_favorite').attr('jq_bid', bid).addClass('i_item_favorite_act').find('span').text(ch);
		}

		if( $tov>1 || $tov==0 )
		{
			i_element_return();// Убрали выбор, вернули цены/картинки товара/кнопку купить

			$('.jq_quick_order, .jq_unit_quick_order').attr('jq_item_id', '');// Быстрый заказ

			$('.jq_matrix').hide();
			$('.jq_matrix_block .jq_matrix:first-child').show();
			il_mbuy_price($('.jq_conumb'), 1);
		}

	});

	if( $('.jq_sku').is('.jq_act_more') )
	{
		if( $('.jq_sku_he_img').find('.jq_sku_ele').length>8 )
		{
			$('.jq_sku_he_img').css('height', '58px');
			$('.jq_sku_he_img').find('.i_sku_more').show();
		}
		$('.jq_sku_he_pro').each(function(indx, element){
			if( $(this).find('.jq_sku_ele').length>8 )
			{
				$(this).css('height', '90px');
				$(this).find('.i_sku_more').show();
			}
		});

		$('body').on('click', '.i_sku_more', function(){
			var he = $(this).parent('.jq_sku_ul').height();

			$(this).parents('.jq_sku_he').animate({height: he },500);
			$(this).fadeOut();
		});
	}
// ---------------------------------------------------------------------------------------------------- [Favorite]
	$('body').on('click', '.j_item_favorite', function(){
		var th = $(this);
		var url = '/local/templates/ilab_it_shop/ilab/ajax/basket/add_she.php';// Файл ajax
		var id = $(this).attr('jq_id');
		var quan = 1;
		var type = 'Y';

		var lid = $('.jq_hbask').attr('jq_lid');

		i_hide('BUY_MENU');

		if( $(this).attr('jq_bid') )
		{

			var ch		= $(this).data('change_text').txt_default;
			var bid		= $(this).attr('jq_bid');
			var href	= '/local/templates/ilab_it_shop/ilab/ajax/delete2basket.php';
			var dir 	= $('.jq_favorite_id');
			var id_num 	= parseInt(id, 10);

			$.post(
				href,
				{ id: bid },
				function(z)
				{
					th.attr('jq_bid', '').removeClass('i_item_favorite_act').find('span').text(ch);
					th.siblings('.j_favorite_success').stop().fadeOut(400);
					th.siblings('.j_favorite_success').find('.i_fv_succes_ms').stop().fadeOut(400);
					th.siblings('.j_favorite_success').find('.i_fv_error_ms').stop().fadeOut(400);
					i_basket_sum(lid);


					dir.data('id').splice($.inArray(id, dir.data('id')), 1);
					delete dir.data('bids')[id];
				}
			);

		} else if( bid = i_addFavorite(url, id, quan, type, lid)) {
			var ch = $(this).data('change_text').txt_change;

			th.siblings('.j_favorite_success').show().delay(10000).fadeOut(400);
			th.siblings('.j_favorite_success').find('.i_fv_succes_ms').show().delay(10000).fadeOut(400);
			$(this).attr('jq_bid', bid).addClass('i_item_favorite_act').find('span').text(ch)
				.parents('.jq_item').find('.jq_bought').fadeOut(400)
				.siblings('.jq_buy').fadeIn(400)
				.siblings('.jq_count').fadeIn(400)
				.siblings('.jq_buy_succes').stop().fadeOut(400)// FADEOUT(очистка очереди)
				.siblings('.jq_delete_item').attr('jqid', bid).hide(); // удаляет х на кнопке купить
		}

		if (th.attr('jq_id') == '') {
			th.siblings('.j_favorite_success').show().delay(10000).fadeOut(400);
			th.siblings('.j_favorite_success').find('.i_fv_error_ms').show().delay(10000).fadeOut(400);
		}

		return false;
	});
	$('body')
		// Закрытие окна succes покупки
		.on('click', '.j_cs_close', function(){
			var th = $(this);
			$('.j_favorite_success').stop().fadeOut(400);// FADEOUT(очистка очереди)
			th.siblings('.j_favorite_success').find('.i_fv_succes_ms').stop().fadeOut(400);
			th.siblings('.j_favorite_success').find('.i_fv_error_ms').stop().fadeOut(400);
		});
	/*$('body').on('click', '.jq_favorite', function(){
		var th		= $(this);
		var url		= '/local/templates/ilab_it_shop/ilab/ajax/basket_add_she.php';// Файл ajax
		var id		= $(this).attr('jq_id');
		var quan	= 1;
		var type	= 'Y';
		var lid		= $('.jq_hbask').attr('jq_lid');

		i_hide();

		if( $(this).attr('jq_bid') )
		{

			var ch		= $(this).data('change_text').txt_default;
			var bid		= $(this).attr('jq_bid');
			var href	= '/local/templates/ilab_it_shop/ilab/ajax/delete2basket.php';

			i_hide();

			$.post(
				href,
				{ id: bid },
				function(z)
				{
					th.attr('jq_bid', '').removeClass('i_item_favorite_act').find('span').text(ch);
					th.siblings('.j_favorite_succes').stop().fadeOut(400);
				}
			);

		} else if( bid = i_addBasketFavorite(url, id, quan, type, lid)) {
			var ch = $(this).data('change_text').txt_change;

			th.siblings('.j_favorite_succes').show().delay(10000).fadeOut(400);
			$(this).attr('jq_bid', bid).addClass('i_item_favorite_act').find('span').text(ch)
				.parents('.jq_item').find('.jq_bought').fadeOut(400)
				.siblings('.jq_buy').fadeIn(400)
				.siblings('.jq_buy_succes').stop().fadeOut(400)// FADEOUT(очистка очереди)
				.siblings('.jq_delete_item').attr('jqid', bid).hide(); // удаляет х на кнопке купить
		}

		return false;
	});*/
	/*

	 $('body').on('click', '.jq_favorite', function(){
	 var th		= $(this);
	 var url		= '/local/templates/ilab_it_shop/ilab/ajax/basket_add_she.php';// Файл ajax
	 var id		= $(this).attr('jq_id');
	 var quan	= 1;
	 var type	= 'Y';
	 var lid		= $('.jq_hbask').attr('jq_lid');

	 if( $(this).attr('jq_bid') )
	 {

	 var ch		= $(this).data('change_text').txt_default;
	 var bid		= $(this).attr('jq_bid');
	 var href	= '/local/templates/ilab_it_shop/ilab/ajax/delete2basket.php';

	 i_hide();

	 $.post(
	 href,
	 { id: bid },
	 function(z)
	 {
	 th.attr('jq_bid', '').removeClass('i_item_favorite_act').find('span').text(ch);
	 }
	 );

	 } else if( bid = i_addBasketFavorite(url, id, quan, type, lid)) {

	 var ch = $(this).data('change_text').txt_change;

	 $(this).attr('jq_bid', bid).addClass('i_item_favorite_act').find('span').text(ch)
	 .parents('.jq_item').find('.jq_bought').fadeOut(400)
	 .siblings('.jq_buy').fadeIn(400)
	 .siblings('.jq_buy_succes').stop().fadeOut(400)// FADEOUT(очистка очереди)
	 .siblings('.jq_delete_item').attr('jqid', bid).hide(); // удаляет х на кнопке купить

	 }

	 return false;
	 });*/
// ---------------------------------------------------------------------------------------------------- [Compare]
	/* OLD functionals

	if( $.fn.ilab )
	{
		$.ilab('InputHidden', {
			compare: {
				input			: true,
				update_button	: true,
				button_class	: '.jq_item_compare',
				change_class	: 'i_item_compare_act',
				change_text		: { class : 'span' }
			}
		});
		$('body').on('click', '.jq_item_compare', function(){
			$(this).ilab('CompareAdd', {
				loader_class	: 'i_item_compare_load',
				change_class	: 'i_item_compare_act',
				change_text		: { class : 'span' },
				remove_second	: true,
				button_class	: '.jq_item_compare',
				//			onBefore		: function( o ) {}
			});

			return false;
		});
		$('body').on('click', '.j_open_compare', function(){
			$.ilab('CompareModal', {
				onAfter: function(){
					if( typeof(i_buy_buttom)=='function' )
					{ i_buy_buttom(); }
				}
			});
		});
	}*/
// ---------------------------------------------------------------------------------------------------- [Compare]
	if( $.fn.ilab )
	{
		$.ilab('InputHidden', {
			compare: {
				input : true,
				update_button : true,
				button_class : '.j_item_compare',
				change_class : 'i_item_compare_act',
				change_text : { class : 'span' }
			},
			onBefore : function( o, f ) {},
			onAfter : function( o, f ) {}
		});
		$('body').on('click', '.j_item_compare', function(){
			$(this).ilab('CompareToggle', {
				loader_class : 'i_item_compare_load',
				change_class : 'i_item_compare_act',
				change_text : { class : 'span' },
				remove_second : true,
				button_class : '.j_item_compare',
				onBefore : function( o, f ) {
					i_hide('BUY_MENU');
				},
				onAfter : function( o, f ) {}
			});
			return false;
		});
		$('body').on('click', '.j_open_compare', function(){
			var c = $('.j_compare');

			if( c.length )
				c.find('.j_compare_close').click();
			else
			{
				$.ilab('CompareModal', {
					onAfter: function(){
						if( typeof(i_buy_buttom)=='function' )
							i_buy_buttom();
					}
				});
			}
		});
	}

// ---------------------------------------------------------------------------------------------------- Relaod Captcha
	$('.jq_recaptcha').click (function(){
		i_reload_captcha( $(this).siblings('.jq_captcha'), $(this) );
	});
// ---------------------------------------------------------------------------------------------------- Написать ещё - Связаться с нами внутри
	$('.jq_click_again').click(
		function(){
			var form = $(this).parents('form.j_form_result_new');

			$(this).parent('.jq_again').hide();
			form.find('input[type="submit"]').fadeIn();
			form.find('input[name="captcha_word"]').val('');
			form.find('.jq_recaptcha').click();
			return false;
	});
// ---------------------------------------------------------------------------------------------------- Веб-форма
	$('body').on('click', '.j_form_submit_result_new', function(){ 
		var form = $(this).parents('form.j_form_result_new');

		form.ajaxSubmit({
		//$('form[name="<?=$arResult['WEB_FORM_NAME']?>"]').ajaxForm({
			data: { FPRO_KEY: '45gsiLab+1S23T' },
			beforeSubmit: function()
			{
//					var form			= $('form[name="<?=$arResult['WEB_FORM_NAME']?>"]');
				var captcha_user	= form.find('.jq_captcha');
				var required		= false;

				var ar_Field		= form.find('[jqfields="Y"]').fieldSerialize().split('&');// Заберём у input и textarea name=value&name=value&... кроме input[type='submit'], создадим массив

				form.find('.fi_empty').removeClass('fi_empty');
				form.find('.fi_error').empty();

//				form.find('.jq_loader').fadeIn();
				form.find('.jq_buttom_loader').addClass('i_buttom_loader');

//					   Создадим массив по порядку input'ов вида
//						<input name="form_text_1" value="Кирилл">
//						[form_text_1] = Кирилл
//						[0] =>
//							[0] => form_text_1
//							[1] => Кирилл

				var f = [];
				for (var i = 0; i < ar_Field.length; i++)
				{
					var val = ar_Field[i].split('=');

					// Если пустое/обязательное поле покрасить в красный
					if( !val[1] && form.find('[name="'+val[0]+'"]').attr('jq_required') == 'Y' )
					{
						var required = true;// Заполните обязательные поля
						form.find('[name="'+val[0]+'"]').addClass('fi_empty');
					}

					if(val[0] == 'captcha_word')// Если каптча то в переменную cap (для удобства)
						var cap		= val[1];
					else if( /form_email/i.test(val[0]) )// Если email то в переменую email (для удобства)
						var email	= val;
					else// Остальные поля в массив f
						f.push( [ val[0], val[1] ] );
				}
//console.log(email);
				if( email && !il_email(email[1]) )// Проверка корректности емайл адреса
				{
					form.find('.fi_error').append('<li>Введите корректный адрес эл.почты.</li>');
					form.find('[name="'+email[0]+'"]').addClass('fi_empty');
				}

				if( required || !cap )
				{
					form.find('.fi_error').append('<li>Заполните обязательные поля.</li>');
//					form.find('.jq_loader').delay(500).fadeOut();
					form.find('.jq_buttom_loader').delay(500).queue(function(){		$(this).removeClass('i_buttom_loader').dequeue();	});;
					return false;// Стоп отправки
				}else{
					var fsuc = $.ajax({
						type: 'POST',
						url: '/local/templates/ilab_it_shop/ilab/ajax/captcha_check.php',
						data: 'captcha_user=' + cap + '&captcha_sid=' + captcha_user.attr('jq_code'),
						async: false,
						success: function(z) {
							console.log(z);
							if(z == 'false'){
								form.find('input[name="captcha_word"]').val('');
								form.find('input[name="captcha_word"]').addClass('fi_empty');
								form.find('.fi_error').append('<li>Символы с картинки введены неправильно.</li>');
								form.find('.jq_recaptcha').click();
							}else{
								form.find('.fi_error').empty();
							}
						}
					}).responseText;

					if(fsuc == 'false')
					{
						//form.find('.jq_loader').delay(500).fadeOut();
						form.find('.jq_buttom_loader').delay(500).queue(function(){		$(this).removeClass('i_buttom_loader').dequeue();	});;
						return false;// Стоп отправки
					}
				}
			},
			complete: function(xhr)
			{
				form.find('input[type="submit"]').hide();
//				form.find('.jq_loader').hide();
				form.find('.jq_buttom_loader').removeClass('i_buttom_loader');
				form.find('.jq_again').fadeIn();
			}
		});
		return false;
	});


	 $('body').on('click', '.jq_fmap_a', function() {
		 var th = $('.jq_fmap_div[jq_id=' + $(this).attr('jq_id') + ']');
		 var th_c = $(this);
		 var $lat = th_c.data('city').lat;
		 var $lng = th_c.data('city').lng;

		 $('.jq_fmap_div').removeClass('ivhid').hide();
		 $('.jq_fmap_a').removeClass('i_fmap_activ');
		 $(this).addClass('i_fmap_activ');

		 toPoint(myMap,$lat,$lng,16);

		 th.fadeIn();
		//map
		return false;
	 });

// ---------------------------------------------------------------------------------------------------- Left menu
	$('.jq_lmenu_a').click(function(){
		if ($(this).parents('.jq_lmenu_li_1').is('.i_lmenu_close'))
			$(this).parents('.jq_lmenu_li_1').removeClass('i_lmenu_close');
		else
			$(this).parents('.jq_lmenu_li_1').addClass('i_lmenu_close');
		return false;
	});
// ---------------------------------------------------------------------------------------------------- Детальная картинка
	// Детальная картинка - карточка товара
	if( $('.jq_cele_img_sw').length )
	{
		i_element_fancybox('jq_fancybox');// fancybox - детальная картинка
		i_element_swiper('jq_cele_img_sw', 'jq_cele_nav_img_block');// Swiper - детальная картинка
	}
// ---------------------------------------------------------------------------------------------------- Detail text element
	if(window.i_hedetxt < window.i_hemindetxt){
		$('.jq_dtxt').css('height','auto');
		$('.jq_more_dtxt').css('display', 'none');
	}else{
		$('.jq_dtxt').css('height',window.i_hemindetxt);
		$('.jq_dtxt').css('overflow','hidden');
	}
	$('.jq_more_dtxt').click(function(){
		var tx		= $(this).siblings('.jq_dtxt');
		var minhe	= window.i_hedetxt;
		var curhe	= tx.innerHeight();
		var authe	= tx.css('height', 'auto').innerHeight();

//		console.log(minhe+' | '+curhe+' | '+authe);

		tx.css('height', curhe).animate({
			height: (curhe == authe ? minhe : authe)
		},500);

		if(curhe == authe)
		{
			$('.jq_mored_show').show();
			$('.jq_mored_hide').hide();
		} else {
			$('.jq_mored_show').hide();
			$('.jq_mored_hide').show();
		}
	});

	if( $('.jq_cele_property_hide').length == 0 )
		$('.jq_more_features').hide();

	$('.jq_more_features').click(function(){
		var th = $(this).siblings('.jq_cele_property_hide');
		if( th.is(':hidden') )
		{
			$('.jq_moref_show').hide();
			$('.jq_moref_hide').show();
		} else {
			$('.jq_moref_show').show();
			$('.jq_moref_hide').hide();
		}

		$('.jq_cele_property_hide').slideToggle();
	});

	$('body').on('click', '.jq_ai_but', function() {
		var cl = $(this).attr('data-class');

		i_cele_property_click($(this), cl, true);
	});
	$('select.j_offers_sl_mobile').change(function(){
		var os = $('option:selected', $(this));
		var sel = os.attr('jq_ai_but');
		var cl = os.attr('data-class');

		//console.log(sel);
		i_cele_property_click($('.jq_ai_but[jq_ai_but='+sel+']'), cl, false);
	});
	$('.jq_ai_up').on('click', function(){
		$('html, body').animate({scrollTop:0},'slow');
	});
// ---------------------------------------------------------------------------------------------------- Быстрый заказ
	/*$('.jq_quick_order').click(function(){
		var th		= $(this);
		var name	= th.attr('jq_item_name');
		var id		= th.attr('jq_item_id');

		if( id )
		{
			$('.jqm_quick').find('.jq_item_name').text(name);
			$('.jqm_quick').find('[name="id"]').val(id);
			$('.jq_quick_order_modal').fadeToggle();
			//i_modal('.jqm_quick', 'i_pos_quick', 'top', $(this));
		} else {
			th.siblings('.jq_quor').fadeIn().delay(10000).fadeOut(400);
		}

		return false;
	});
	$('.jq_unit_quick_order').click(function(){
		var th		= $(this);
		var name	= th.attr('jq_item_name');
		var id		= th.attr('jq_item_id');

		if( id )
		{
			$('.jqm_quick').find('.jq_item_name').text(name);
			$('.jqm_quick').find('[name="id"]').val(id);
			$('.jq_unit_quick_order_modal').fadeToggle();
			//i_modal('.jqm_quick', 'i_pos_quick_unit', 'top', $(this));
		} else {
			th.siblings('.jq_quor').fadeIn().delay(10000).fadeOut(400);

			$('.jq_select_offers').fadeIn(400)
				.delay(10000).fadeOut(400);

			$('html, body').animate({scrollTop:0},'slow');
		}

		return false;
	});*/
	$('.jq_qr_close').click(function(){
		$('.jq_quor').stop().fadeOut(400);// FADEOUT(очистка очереди)
		$('.jq_chec_modal').fadeOut();

		return false;
	});
/*
	$('.jq_quick_order').click(function(){
		var name	= $(this).attr('jq_item_name');
		var id		= $(this).attr('jq_item_id');

		$('.jqm_quick').find('.jq_item_name').text(name);
		$('.jqm_quick').find('[name="id"]').val(id);
		// i_modal('.jqm_quick', 'i_pos_quick', 'top', $(this));
		$('.jq_quick_order_modal').fadeToggle();
		//$('.jq_quick_order_modal').find('form[name="quick_order"]').attr('q_order', 'qorder');
		return false;
	});
	$('.jq_unit_quick_order').click(function(){
		var name	= $(this).attr('jq_item_name');
		var id		= $(this).attr('jq_item_id');

		$('.jqm_quick').find('.jq_item_name').text(name);
		$('.jqm_quick').find('[name="id"]').val(id);
		// i_modal('.jqm_quick', 'i_pos_quick_unit', 'top', $(this));
		$('.jq_unit_quick_order_modal').fadeToggle();
		//$('.jq_unit_quick_order_modal').find('form[name="quick_order"]').attr('q_order', 'quorder');
		return false;
	});
*/
// ---------------------------------------------------------------------------------------------------- Tizer item
	$('.jq_teaser_i_item').click(function(){

		if( $('.jq_teaser_i_modal[jq_st_id="'+$(this).attr('jq_st_id')+'"]:hidden').length )
		{
			$('.jq_teaser_i_modal, .jq_teaser_i_delta').hide();

			$('.jq_teaser_i_modal[jq_st_id="'+$(this).attr('jq_st_id')+'"]').fadeIn();
			$(this).siblings('.jq_teaser_i_delta').fadeIn();

		} else {

			$('.jq_teaser_i_modal[jq_st_id="'+$(this).attr('jq_st_id')+'"]').fadeOut();
			$(this).siblings('.jq_teaser_i_delta').fadeOut();

		}

		return false;
	});
	$('.jq_teaser_im_close').click(function(){
		$('.jq_teaser_i_modal, .jq_teaser_i_delta').hide();
	});

// ---------------------------------------------------------------------------------------------------- DEMO
	$('body').on('click', '.jq_demo_close', function(){
		$('.jq_demo').fadeOut();
		$('.jq_demo_info').fadeIn();
		$.cookie('I_DEMO', 'Y');// jquery.cookie.js
	});
	$('body').on('click', '.jq_demo_info', function(){
		$('.jq_demo').fadeIn();
		$('.jq_demo_info').fadeOut();
	});
// ---------------------------------------------------------------------------------------------------- Условия заказа(быстрый заказ)
	$('.jq_order_spec_link').click(function(){
		$('.jq_order_spec').slideToggle();
		return false;
	});
// ---------------------------------------------------------------------------------------------------- Contacts
	$('.jq_cont_point').click(function(){
		if( $('.jq_cont_point').length>1 )
		{
			var th = $('.jq_cont_dpoint[jqid='+$(this).attr('jqid')+']');

			$('.i_cont_act').removeClass('i_cont_act');
			$(this).addClass('i_cont_act');
			$('.jq_cont_dpoint').hide();
			th.fadeIn();
		}
	});
// ---------------------------------------------------------------------------------------------------- bx filter close
	$('body').on('click', '.bx_pop_close', function(){
		$(this).parent().fadeOut();
	});
// ---------------------------------------------------------------------------------------------------- iLaB Script
	$('body').on('click', '.i_checkout_inactive', function(){
		$('.jq_chec_modal').fadeIn();
	});
// ---------------------------------------------------------------------------------------------------- Buy count
	// Plus
	$('body').on('click', '.jq_co_plus', function(){
		var co		= $(this).siblings('.jq_conumb');
		var val		= +co.val();
		var factor	= parseFloat( co.attr('jqmeasure') );

		if( val<999999 )
			val = parseFloat( (val+factor).toFixed(1) );co.val( val );

		il_mbuy_price($(this), val);

		return false;
	});
	// Minus
	$('body').on('click', '.jq_co_minu', function(){
		var co		= $(this).siblings('.jq_conumb');
		var val		= +co.val();
		var factor	= parseFloat( co.attr('jqmeasure') );

		if( val>factor )
			val = parseFloat( (val-factor).toFixed(1) );co.val( val );

		il_mbuy_price($(this), val);

		return false;
	});
	$('.jq_conumb').change(function(){
		var val = il_quan_factor($(this));

		il_mbuy_price($(this), val);
		$(this).val(val);
	});
	// Plus
	$('body').on('click', '.jq_cop_plus', function(){
		var co		= $(this).siblings('.jq_copnumb');
		var val		= +co.val();
		var factor	= parseFloat( co.attr('jqmeasure') );

		if( val<999999 )
			val = parseFloat( (val+factor).toFixed(1) );co.val( val );

		il_cop_price($(this), val);

		return false;
	});
	// Minus
	$('body').on('click', '.jq_cop_minu', function(){
		var co		= $(this).siblings('.jq_copnumb');
		var val		= +co.val();
		var factor	= parseFloat( co.attr('jqmeasure') );

		if( val>factor )
			val = parseFloat( (val-factor).toFixed(1) );co.val( val );

		il_cop_price($(this), val);

		return false;
	});
	$('.jq_copnumb').change(function(){
		var val = il_quan_factor($(this));

		il_cop_price($(this), val);
		$(this).val(val);
	});
	// В инпуты можно писать только числа
	jQuery('.jq_conumb, .jq_copnumb').keypress(function(event){
		var key, keyChar;
		if(!event) var event = window.event;

		if (event.keyCode)
			key = event.keyCode;
		else if(event.which)
			key = event.which;

		if(key==44)
			$(this).val( $(this).val()+'.' );

		if( key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39)
			return true;

		keyChar=String.fromCharCode(key);

		if(!/\d/.test(keyChar))
			return false;
	});
// ---------------------------------------------------------------------------------------------------- Скидка на количество
	$('body').on('click', '.jq_datext', function(){
		$(this).siblings('.jq_mbuy').fadeIn();
//		console.log('jq_mbuy show');
		return false;
	});
	$('body').on('click', '.jq_mbuy_close', function(){
		$(this).parents('.jq_mbuy').hide();
	});
// ---------------------------------------------------------------------------------------------------- Регистрация - [Пользовательское соглашение]
	if( $('.jq_main_regi_tou').length )
	{
		$('.jq_main_regi').addClass('i_main_regi');
		$('body').on('change', '.jq_main_regi_tou', function(){
//			console.log('message');
			if( $(this).is(':checked') )
				$('.jq_main_regi').removeClass('i_main_regi');
			else
				$('.jq_main_regi').addClass('i_main_regi');
		});
		$('body').on('click', '.jq_main_regi', function(){
			if( !$('.jq_main_regi_tou').is(':checked') )
				return false;
		});
	}
// ---------------------------------------------------------------------------------------------------- Удалить товар с корзины
	$('body').on('click', '.jq_delete_item', function(){
		var id		= $(this).attr('jqid');
		var th		= $('.jq_delete_item[jqid='+id+']');
		var href	= '/local/templates/ilab_it_shop/ilab/ajax/delete2basket.php';
		var lid		= $('.jq_hbask').attr('jq_lid');
//		console.log($('.jq_basket_item').length);
		var basketid = $('.jq_basket_id');

		i_hide();

		$.post(
			href,
			{ id: id },
			function(z)
			{
				th.data('id', '').attr('jqid', '').hide()
					.siblings('.jq_bought').hide().siblings('.jq_buy').show();

				delete basketid.data('d')[basketid.data('l')[id]];
				basketid.data('ids').splice(basketid.data('ids').indexOf(basketid.data('l')[id]), 1);
				delete basketid.data('l')[id];

				i_basket_sum(lid);
			}
		);

		return false;
	});
	/*$('body').on('click', '.jq_delete_item', function(){
		var id		= $(this).attr('jqid');
		var th		= $('.jq_delete_item[jqid='+id+']');
		var href	= '/local/templates/ilab_it_shop/ilab/ajax/delete2basket.php';
		var lid		= $('.jq_hbask').attr('jq_lid');
//		console.log($('.jq_basket_item').length);
		i_hide();

		$.post(
			href,
			{ id: id },
			function(z)
			{
				th.hide().siblings('.jq_bought').hide().siblings('.jq_buy').show();
				i_basket_sum(lid);
			}
		);

		return false;
	});*/
// ---------------------------------------------------------------------------------------------------- Удалить товар с корзины
	$('body').on('click', '.js_cat_view svg', function(){
		var v		= $(this).data('view').class;
		var v_all	= $('.js_cat_view svg[data-view]').map(function(){ return $(this).data('view').class; }).get().join(' ');
		$.cookie('I_VIEW_CATALOG', v);// jquery.cookie.js

//console.log(v,v_all);
		$('.js_cat_view svg.i_c_view_act').attr('class','')
		$(this).attr('class', 'i_c_view_act');
		$('.js_cs_cat').removeClass(v_all).addClass(v);
	});
// ---------------------------------------------------------------------------------------------------- Количество товара
	$('.j_pp_select').change(function(){
		$.cookie('I_COO_PAGES', $('option:selected', $(this)).val());// jquery.cookie.js
//		document.cookie="ABRIS_COO_PAGES="+$('.sel option:selected').val()+"; path=/; expires=01-Dec-20 00:00:00 GMT";
		window.location.reload();
	});
	// ------------------------------------- catalog_flex ----------------------------
	il_adap_cat();
	$( window ).resize(function() {
		il_adap_cat();
		if($(window).width() > 1066)
		{
			/*if( $('.i_lmenu').css('display') == 'none' )
				$('.i_lmenu').show();*/

			$('.jq_vmenu_out').show();
		}
	});
	/* ----------------------------------------------------------------------------------- */
	if($('.i_index_top_left').length) {
		if($(window).width() < 1024) {


			$('body').on('click','.i_vmenu_catalog',function() {
				if($(this).hasClass('ibr5i')) $(this).removeClass('ibr5i');
				$(this).siblings('.i_vmenu_out').slideToggle();
			});
		}
	}
	/* ---------------------------------------------- адаптивный баннер --------------------------- */
	if($('.jq_adaptive_banner').length)
	{
		var bannerSwiper = new Swiper('.jq_adaptive_banner',
		{
			slidesPerView: 1,
			preloadImages: false,
			preventClicksPropagation: false,
			lazy: true,
			loop: true,

			pagination: {
				el: $('.jq_banner-pagination'),
				clickable: true
			},

			navigation: {
				nextEl: $('.jq_banner-right'),
				prevEl: $('.jq_banner-left')
			},

			autoplay: {
				delay: 5000
			}
		});
	}
	var bannerImg = $('.jq_adaptive_banner_img');
	var top = $('.i_banner').css('top');
	var bs = $('.jq_adaptive_banner')[0];

	if(top == '1px')
	{
		bannerImg.each(function(){
			// $(this).attr('src', $(this).data('src').src3);
			$(this).css({
				'background-image':'url(' + $(this).data('src').src3 + ')'
			});
		});
	}

	if(top == '2px')
	{
		bannerImg.each(function(){
			// $(this).attr('src', $(this).data('src').src2);
			$(this).css({
				'background-image':'url(' + $(this).data('src').src2 + ')'
			});
		});
	}

	if(top == '3px')
	{
		bannerImg.each(function(){
			// $(this).attr('src', $(this).data('src').src1);
			$(this).css({
				'background-image':'url(' + $(this).data('src').src1 + ')'
			});
		});
	}
	if( bs && top )
		bs.swiper.update();
	$(window).resize(function(){
		var bannerImg = $('.jq_adaptive_banner_img');
		var top = $('.i_banner').css('top');
		var bs = $('.jq_adaptive_banner')[0];

		if(top == '1px')
		{
			bannerImg.each(function(){
				// $(this).attr('src', $(this).data('src').src3);
				$(this).css({
					'background-image':'url(' + $(this).data('src').src3 + ')'
				});
			});
		}

		if(top == '2px')
		{
			bannerImg.each(function(){
				// $(this).attr('src', $(this).data('src').src2);
				$(this).css({
					'background-image':'url(' + $(this).data('src').src2 + ')'
				});
			});
		}

		if(top == '3px')
		{
			bannerImg.each(function(){
				// $(this).attr('src', $(this).data('src').src1);
				$(this).css({
					'background-image':'url(' + $(this).data('src').src1 + ')'
				});
			});
		}

		if( bs && top )
			bs.swiper.update();
	});
	$('body').on('click','.jq_show_footmenu',function() {
		var th = $(this);
		var mess = th.data('mess');
		var span = th.children('span');
		th.siblings('.i_footmenu').children('.jq_footmenu_col').slideToggle();
		if(span.hasClass('i_show')) {
			span.text(mess.hide);
			span.removeClass('i_show');
			span.addClass('i_hide');
		}
		else {
			span.text(mess.show);
			span.removeClass('i_hide');
			span.addClass('i_show');
		}
	});
	if($('.i_cat_list_right').length)
	{
		if($('.i_cat_list_right').find('.i_vmenu_catalog'))
		{
			$('body').on('click','.i_vmenu_catalog',function(){
				$(this).toggleClass('i_br5500px');
				$(this).siblings('.jq_vmenu_out').slideToggle();
			});
		}
	}
// ---------------------------------------------------------------------------------------------------- Топ меню
	var i_w = $(window).width();
	i_tm_class(i_w);
	if( i_w>639 )
		i_tm_more_restart();

	$('body').on('click', '.jq_tm_a', function(){
		return false;
	});

// -------------------------------------------------------------------------------------------- Hide Sticker on sblock
	/*i_hide_sblock_stickers();*/

	$(window).resize(function() {
		i_hide_sblock_stickers();
	});

	$('body').on('click', 'img.j_fimg', function(){
		$.fancybox.open([
				{
					src: $(this).attr('src')
				}
			]
		);
	});
// ---------------------------------------------------------------------------------------------------- Vertical menu
	/*if($(window).width()<1220 && $(window).width()>1024)
	{
		if($('.i_v_menu_sub_cont').hasClass('col_3') || $('.i_v_menu_sub_cont').hasClass('col_4')){
			$('.i_v_menu_sub_cont').removeClass('col_3').removeClass('col_4').addClass('col_2');
		}
	}
	$(window).resize(function(){
		if($(window).width()<1220 && $(window).width()>1024)
		{
			if($('.i_v_menu_sub_cont').hasClass('col_3') || $('.i_v_menu_sub_cont').hasClass('col_4')){
				$('.i_v_menu_sub_cont').removeClass('col_3').removeClass('col_4').addClass('col_2');
			}
		}
	});*/
// ---------------------------------------------------------------------------------------------------- Modal window
	// Закрытие окна
	$('body').on('click', '.j_compare_close', function(){
		$(this).parent('j_compare').fadeOut(400);
	});

	$(document).click(function(ev) {
		if ( ($(ev.target).parents().filter('.i_mo_inside, .j_v_menu_mobile_title, .jq_modal, .jq_cheap_modal, .jq_quick_order_modal, .jq_unit_quick_order_modal, .i_v_menu_sub_wrap, .i_v_menu_content').length != 1) && ($(ev.target).filter('.i_mo_inside, .j_v_menu_mobile_title, .jq_modal, .jq_cheap_modal, .jq_quick_order_modal, .jq_unit_quick_order_modal, .i_v_menu_sub_wrap, .i_v_menu_content').length != 1) )
			$('.jq_modal, .jq_cheap_modal, .jq_quick_order_modal, .jq_unit_quick_order_modal, .j_mo_inside').fadeOut(400);
			$('.i_v_menu_sub_wrap').fadeOut(400).parents().find('.jq_v_submenu').removeClass('select');
			$('.i_v_menu_mobile_content').fadeOut(400).parents().find('.j_v_menu_mobile_link').removeClass('checked');
			$('.i_mo_inside').fadeOut(400).parents().find('span').removeClass('i_mo_select');
			$('.i_mo_inside').fadeOut(400).parents().find('a').removeClass('i_mo_select');
			$('.i_v_menu_mobile').removeClass('visible');
	});
/* ------------------------------------ --------------------------------------------- Favorite */

	$('body').on('click', '.j_cs_close', function(){
		$('.j_favorite_succes').stop().fadeOut(400);// FADEOUT(очистка очереди)
	});
	$('body').on('click', '.jq_delete_item', function(){
		var m_succes	= $('.jq_buy').siblings('.jq_buy_succes');
		m_succes.find('.j_quan_miss').stop().hide(400);
		m_succes.find('.j_bask_succes').stop().hide(400);
	});

	if ($(window).width() < 640) {
		pre_text_item();
	}
	$(window).resize(function(){
		if ($(window).width() < 640) {
			pre_text_item();
			console.log($('.js_cs_cat .i_item_name').height());
		}
	});


/* ------------------------------------ --------------------------------------------- Top contacts */
	$('body').on('click', '.j_tcontact_but', function(){
		$('.j_tcontact_but').toggleClass('open');
		$('.j_tcontact_cont').fadeToggle(400);
	});

/* ------------------------------------ --------------------------------------------- Перенос нижнего меню */
	if($(window).width() <= 464)
	{
		$('.i_footer_flex_right').appendTo('.i_footer .i_wr');
	}
	else {
		$('.i_footer_flex_right').appendTo('.i_footer_flex');
	}
	$(window).resize(function(){

		if($(window).width() <= 464)
		{
			$('.i_footer_flex_right').appendTo('.i_footer .i_wr');
		}
		else {
			$('.i_footer_flex_right').appendTo('.i_footer_flex');
		}
	});
/* ------------------------------------------ [top menu] */
	$('body').on('click','.jq_i_tm_tt', function(){
		$(this).toggleClass('open');
		$(this).siblings().fadeToggle();
	});
	if($(window).width()<=639)
	{
		$('body').on('click','.jq_tm_a', function(){
			if(  $(this).siblings('.jq_sub').length > 0 )
			{
				$(this).addClass('i_tm_hover').siblings('.jq_sub').slideToggle();// Показать hover/под-меню
				$(this).toggleClass('open');
				return false;
			}
		});
	}
/* -------------------------------- mobile catalog menu ------------- */
	$('body').on('click', '.jq_h_menu_mobi', function(){
		$(this).siblings('.jq_cmapodmenu').slideToggle();
	});
	$('body').on('click','.jq_i_cmalink', function(){
		if($(this).siblings('.j_cmapod').length)
		{
			$(this).toggleClass('selected');
			$(this).find('.i_cmastr').toggleClass('i_cmastrr').toggleClass('i_cmastrd');
			$(this).siblings('.j_cmapod').slideToggle();
			return false;
		}
	});
// ------------------------------------------ [left menu] */
	$('body').on('click','.jq_lmenu_link',function(){
		$(this).toggleClass('open');
		$(this).siblings('.i_lmenu').fadeToggle();
	});
/* ------------------------------------------ [всплывающие контакты] */
	/*if( $('.i_hcontact') && $(window).width() < 480 )
	{
		var th = $('.i_hcontact');
		if( th.height() > 27 ) {
			th.find('span').wrapAll("<div class='i_hcontact_wrap jq_hcontact_wrap'></div>");
			th.find('.i_hcontact_wrap').before("<span class='i_hcontact_show jq_hcontact_show'></span>");
			$('.i_hcontact_show').text($('.i_hcontact_wrap').find("span:first").text());
		}
		$('body').on('click','.jq_hcontact_show',function(){
			$(this).toggleClass('open');
			$(this).siblings('.i_hcontact_wrap').slideToggle();
		});
		var contactShow = $('.i_hcontact_show');
		var contactWrap = $('.i_hcontact_wrap')
		contactWrap.find('span').each(function(){
			$(this).click(function(){
				contactWrap.children('span').removeClass('show');
				contactShow.text($(this).text());
				$(this).addClass('show');
				contactWrap.fadeOut(700);
				contactShow.removeClass('open');
			});
		});
	}*/
/* ------------------------------------------ [filter добавление класса] */
	if($('.bx_filter').length)
	{
		$('body').on('click', '.bx_filter_param_label', function() {
			$(this).toggleClass('fil_cheack');
		});
	}
/* ------------------------------------------ [перекидывание левой части на правую] */
	if($('.i_cat_list_left').css('display')=='none' && $(window).width() < 1024)
	{
		$('.bx_filter').insertAfter($('.i_title_catalog'));
		$('.i_cat_leftbanner').appendTo('.i_cat_list_right');
	}
	else
	{
		$('.bx_filter, .i_cat_leftbanner').prependTo($('.i_cat_list_left'));
	}
	$( window ).resize(function() {
		if($('.i_cat_list_left').css('display')=='none' && $(window).width() < 1024)
		{
			$('.bx_filter').insertAfter($('.i_title_catalog'));
			$('.i_cat_leftbanner').appendTo('.i_cat_list_right');
		}
		else
		{
			$('.bx_filter, .i_cat_leftbanner').prependTo($('.i_cat_list_left'));
		}
	});
/* ------------------------------------------ scrollTo snippet */
	if($('.bx_filter_section').length)
	{
		$('.bx_filter_parameters_box').each(function(indx){
			if(indx == 3)
			{
				$(this).prepend('<div class="hello">');
			}
			if(indx == 5)
			{
				$(this).append('</div>');
			}
		});
	}
/* ------------------------------------------ i_up */
	$(window).scroll(
		function() {
			if($(window).scrollTop() > 300 && $(window).width() > 999)
				$('.j_up').fadeIn();
			else{
				$('.j_up').fadeOut();
			}
		}
	);
	$('.j_up').on('click', function(){
		$("html, body").animate({scrollTop:0},"slow")
	});
/* ------------------------------------------ leftbanner */
	if($('.i_lbanner').length)
	{
		var src1 = $('.j_lbanner_img').data('src1');
		var src2 = $('.j_lbanner_img').data('src2');
		if(src1 && src2)
		{
			if($(window).width() > 480 && $(window).width() < 720)
			{
				$('.j_lbanner_img').css({
					'background-image':'url('+ src2+')'
				});
			}
		}
		$(window).resize(function(){
			if(src1 && src2)
			{
				if($(window).width() > 480 && $(window).width() < 720)
				{
					$('.j_lbanner_img').css({
						'background-image':'url('+ src2+')'
					});
				}
				else
				{
					$('.j_lbanner_img').css({
						'background-image':'url('+ src1+')'
					});
				}
			}
		});
	}
/* ------------------------------------------ i_menu_view */
	if($('.i_menu_view').length)
	{

		$('body').on('click','.j_show_param',function(){
			$(this).siblings('.i_menu_view_cont').toggleClass('show');
		});

		var view = $('.j_menu_view_item_title').data('view');
		var color = $('.j_menu_view_item_cont').data('color');

		if($('.j_ch_color').length)
		{
			$('body').on('click','.j_ch_color',function() {
				$('.j_ch_color').removeClass('selected');
				$(this).addClass('selected');
				color = $(this).data('color');
			});
		}

		if($('.j_menu_view_item').length)
		{
			$('body').on('click','.j_menu_view_item',function() {
				$('.j_menu_view_item').removeClass('selected');
				$(this).addClass('selected');
				view = $(this).data('menu');
			});
		}

		$('body').on('click', '.j_menu_view_apply', function() {
			$.post(
				"/local/templates/ilab_it_shop/tmpl/ajax/menuview.php",
				{
					view: view,
					color: color
				},
				onAjaxSuccess
			);
			function onAjaxSuccess(data)
			{
				// Здесь мы получаем данные, отправленные сервером и выводим их на экран.
				// $('.i_view_menu').html(data);
				location.reload();
			}
		});

		$('body').on('click', '.j_menu_view_default', function() {
			$.post(
				"/local/templates/ilab_it_shop/tmpl/ajax/menuview.php",
				{
					view: 'hor',
					color: '#f75b18'
				},
				onAjaxSuccess
			);
			function onAjaxSuccess(data)
			{
				// Здесь мы получаем данные, отправленные сервером и выводим их на экран.
				// $('.i_view_menu').html(data);
				location.reload();
			}
		});
	}

/* --------------------------------------------------------------------------------------------- Filter Hint*/
	$('body').on('click', '.jq_filter_hint', function () {
		$(this).siblings('.i_filter_hint').fadeToggle();
		setTimeout(function(){
			$('.i_filter_hint').fadeOut();
		}, 5000);
	});

/* --------------------------------------------------------------------------------------------- Footer panel*/
	if ($('.jq_bought').length){
		$(this).siblings('.jq_count').addClass('bought');
	}
	$('body').on('click', '.jq_buy', function() {
		$(this).siblings('.jq_count').addClass('bought');
	});
	$('body').on('click', '.jq_delete_item', function () {
		$(this).siblings('.jq_count').removeClass('bought');
	});
	$('body').on('click', '.j_search_footer_mobile', function() {
		$('.i_search_footer_mobile_cont').fadeToggle(400);
	});
	$('body').on('click', '.j_s_close', function() {
		$('.i_search_footer_mobile_cont').fadeOut(400);
	});

/* --------------------------------------------------------------------------------------------- catalog menu*/
	$('body').on('click', '.j_v_menu_mobile_title', function() {
		$('.i_v_menu_mobile').toggleClass('visible');
		$('.i_h_menu').toggleClass('visible');
		return false;
	});
// ---------------------------------------------------------------------------------------------------- Map Footer
	$('.jq_fmap_a').on('click', function(){
		var th = $('.jq_fmap_div[jq_id='+$(this).attr('jq_id')+']');

		$('.jq_fmap_div').removeClass('ivhid').hide();
		$('.jq_fmap_a').removeClass('i_fmap_activ');
		$(this).addClass('i_fmap_activ');

		th.fadeIn();
		//map
		return false;
	});
/*------------------------------------------------------------------------------------------------- Кнопка левого меню в Header-е*/
	if($('.i_lblock').length) {
		$('.j_show_hide_menu').show();
	}

	// ------------------------------------------------------------------------------------------------ Вертикальное меню (i_v_menu)
	if( $('.j_v_menu').length )
	{
		$('body').on('click', 'a.j_vm_sub', function () {
			var th = $(this);
			var pr = th.parent('li.j_vm_li_all');
			var sb = th.siblings('ul.j_vm_ul_all');

			var ul = $('ul.j_vm_ul');

			if (pr.is(':not(.i_vm_select)') && $('.i_vm_select').length && $(window).width() > 999)
				$('.i_vm_select').toggleClass('i_vm_select', false).children('ul.j_vm_ul').hide();

			pr.toggleClass('i_vm_select');

			if ($(window).width() > 999)
				th.siblings('.j_vm_ul ').fadeToggle();
			else
				sb.slideToggle();

			return false;
		});
		$(document).on('click', function (e) {
			if (!$(e.target).closest(".j_vm_ul").length) {
				$('.j_vm_ul ').fadeOut('callback');
				$('.i_vm_select').toggleClass('i_vm_select', false).children('.j_vm_ul ').fadeOut('callback');
			}
			e.stopPropagation();
		});

		vm_menu_status($(window).width());

		$('body').on('click', '.j_vm_toggle', function(){
			var th = $(this);
			var ul = th.siblings('.j_v_menu');
			var li = ul.children('li');

			var h_ul = ul.outerHeight(true);

			if( h_ul<=window.vm_h )
			{

				ul.animate({
						height: window.vm_hall
					},
					/*{
					 duration: 1000,
					 },*/
					{
						complete: function()
						{
							$(this).css('height','auto');
						}
					});

				$('.j_v_menu_bl').addClass('i_vmb_select').find('.j_vmt_x').addClass('i_vmt_x_open');
				th.addClass('i_vmt_select').children('.j_vm_x').addClass('i_vm_x_open');

			} else {

				if( $('.i_vm_select').length ) {
					$('.i_vm_select').toggleClass('i_vm_select', false).children('ul.j_vm_ul').fadeOut();
					$('.i_vm_arrow').toggleClass('i_vm_arrow_act', false);
				}

				ul.animate({
						height: window.vm_h
					},
					{
						complete: function()
						{
							$(this).css('height','');
						}
					});

				$('.j_v_menu_bl').removeClass('i_vmb_select').find('.j_vmt_x').removeClass('i_vmt_x_open');
				th.removeClass('i_vmt_select').children('.j_vm_x').removeClass('i_vm_x_open');

			}
			vm_menu_status($(window).width());
		});

		if( $(window).width()>920 && window.location.pathname=='/' )
			$('.j_vm_toggle').click();

		$('body').on('click', '.j_vm_title', function(){
			$('.j_vm_toggle').click();
		});

		$('body').on('click', '.j_vm_a.j_vm_sub', function () {
			var th = $(this);
			var ar = $('.i_vm_arrow');
			var li = th.parent('.j_vm_li');
			var ul = th.siblings('.j_vm_ul');
			var h  = li.position().top;
			var h_li = li.height();
			var h_ar = ar.height();

			if($('.i_vm_select').length)
				ar.css({'top': h + (h_li / 2 - h_ar / 2)}).addClass('i_vm_arrow_act');
			else
				ar.removeClass('i_vm_arrow_act');

		});

		// ---------------------------------------------------------------------------------------------------- Resize menu
		if( $(window).width()<999 ) {
			($('.j_vm_ul_all_2')).addClass('idn');
		}

		$(window).resize(function() {
			var w = $(window).width();
			if ($('.j_v_menu').length)
				vm_menu_status(w);
			if (w<1000) {
				($('.j_vm_ul_all_2')).addClass('idn');
			}
			else {
				($('.j_vm_ul_all_2')).removeClass('idn');
			}
		});
	}
	$('body').on('click', '.j_proccesing_button', function () {
		$('.j_proccesing_button').hide();
	});

});


// ---------------------------------------------------------------------------------------------------- iLaB Script
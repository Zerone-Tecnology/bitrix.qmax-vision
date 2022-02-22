// ---------------------------------------------------------------------------------------------------- iLaB Functions
//	Esc
$(document).keydown(function(e) {
	if (e.keyCode == 27)
	{
		i_hide();
		i_close();
	}
});
// ---------------------------------------------------------------------------------------------------- Добавление класса на время
/*function addClassTemporarily(cl, time)
 {
 $("#div").addClass("error").delay(1000).queue(function(){
 $(this).removeClass("error").dequeue();
 });
 }*/
// ---------------------------------------------------------------------------------------------------- Карты
function toPoint($myMap, $lat, $lng, $zoom) // ---------------------- переход к точке
{
	myAction = new ymaps.map.action.Single({
		center: [$lat, $lng],
		zoom: $zoom,
		duration: 1000,
		timingFunction: 'ease-in',
		checkZoomRange: true
	});

	$myMap.action.execute(myAction);
}
function map() { //------------------- initialization
	if($('.j_map_init').length)
	{
		var $j = $('.j_map_init');
		var $zoom = $j.data('city').zoom;
		var $lat = $j.data('city').lat;
		var $lng = $j.data('city').lng;

		myMap = new ymaps.Map(
			"yandex_map",
			{
				center: [$lat, $lng],
				zoom: $zoom,
				controls: []
			}
		);
		setPoint(myMap,$lat,$lng,16);
	}
}
function setPoint($myMap, $zoom, $lat, $lng) { // --------------------- установка всех точек на карте
	var $json_shops = $('.j_map_init').data('shops');

	$.each($json_shops, function ($i, $e) {
		var $lat = $e.lat;
		var $lng = $e.lng;

		var myPlacemark = new ymaps.Placemark(
			[$lat, $lng]
		);
		$myMap.geoObjects.add(myPlacemark);
	});

}
// ---------------------------------------------------------------------------------------------------- Resize
$(window).resize(function(){
	var w = $(window).width();

	i_tm_class(w);

	if( w>639 && w<1371 )
		i_tm_more_restart();
});
// ---------------------------------------------- i_close()
function i_close(id)
{
	if(id) $('.j_modal').not(id).hide();
	else $('.j_modal').hide();
}
// ---------------------------------------------------------------------------------------------------- Top menu
function i_tm_class(w)
{
	var tm = $('.jq_tm');

	if( tm.hasClass('jq_w_desktop') && !tm.hasClass('jq_w_mobile') && w<640 )// mobile size
		tm.removeClass('jq_w_desktop').addClass('jq_w_mobile');
	else if( tm.hasClass('jq_w_mobile') && !tm.hasClass('jq_w_desktop') && w>639 )// desktop size
		tm.removeClass('jq_w_mobile').addClass('jq_w_desktop');
	else if( tm.not('.jq_w_desktop, .jq_w_mobile').length )// first size
	{
		if( w<640 )
			tm.addClass('jq_w_mobile');
		else if( w>639 )
			tm.addClass('jq_w_desktop');
	}
}
function i_tm_more_restart()
{
	var i_tm_length	= $('.jq_tm_item').length;// Количество эл. верхнего меню
	$('.jq_tm').css('overflow','visible').find('.jq_tm_item, .jq_sub_item').show();

	// Перебор пунктов топ меню 1ур.
	$('.jq_tm_item').each(function(indx){
		var i_tm_width	= $('.jq_tm').width()-80;// Ширина меню (-минус) ширина для кнопки 'Ещё'

		var pos			= $(this).position();
		var wid			= $(this).width();
		var wil			= pos.left + wid;
//		console.log( $(this), i_tm_length, indx, wid, pos, wil, i_tm_width );
		// если топ > 0 || предыдущий эл. уже был скрыт || ширина от левой границы, вместе с шириной эл. > i_tm_width
		if( pos.top>0 || $('.jq_tm_item[key="'+(indx-1)+'"]:hidden').length>0 || wil>i_tm_width )
			$(this).hide();
		else// а это не попадёт в 'Еще'
			$('.jq_sub_item[key="'+indx+'"]').hide();
	});

	// Скрыть 'Еще' если внутри нет эл.
	if( $('.jq_sub_item').filter(function() { return $(this).css('display') !== 'none'; }).length > 0 )
		$('.jq_tm_imore').fadeIn(150);
	else
		$('.jq_tm_imore').hide();

	// Выделение кнопочки 'Еще'
	$('.jq_sub').each(function(indx){
		if( $(this).find('.i_sub_selected').parent('.jq_sub_item').css('display')=='list-item' )
			$(this).siblings('.i_more').addClass('i_tm_selected');// 'be_tm_imore_activ' - можно использовать такой вариант выделение кнопки 'Еще'.
		else
			$(this).siblings('.i_more').removeClass('i_tm_selected');
	});
}
// ---------------------------------------------------------------------------------------------------- В корзине ТП
function i_element_each(id)
{
	var basketid	= $('.jq_basket_id').data('ids');
	var basketjson	= $('.jq_basket_id').data('d');
	var result		= false;

/*console.log( $('.jq_basket_id').data('ids') );
console.log( $('.jq_basket_id').data('d') );
console.log( $('.jq_basket_id').data('l') );*/

	$.each(basketid, function(k, v){
		if( v == id )
			result = true;
	});

	$('.icard_buy .jq_buy_succes').data('quan', $('.j_sku_json').data('d')[id].quant);

	if( result )// ТП в корзине
	{

		$('.icard_buy .jq_buy').hide(0);// Уберём id для покупки с кнопки 'Купить' / Скроем кнопку 'Купить'
//			.siblings('.jq_count').hide(0);

		$('.icard_buy .jq_bought').fadeIn(500).css('display', 'flex')// Покажем кнопку 'Вкорзине'
			.attr('jqbacount', basketjson[id].quant)
			.find('.j_m_ratio').text(basketjson[id].quant);

		$('.icard_buy .jq_delete_item').fadeIn(500).data('id', basketjson[id].id).attr('jqid', basketjson[id].id);

//		$('.icard_buy .jq_buy').attr('jq_id','');// Уберём id для покупки с кнопки 'Купить'
		$('.icard_buy .jq_buy').hide(0);// Скроем кнопку 'Купить'
		$('.icard_buy .jq_bought').css('display','flex');// Покажем кнопку 'Вкорзине'
		$('.icard_buy .jq_delete_item').show();
	} else {// ТП не в корзине

		$('.icard_buy .jq_bought').hide(0)// Скроем кнонку 'Вкорзине'
			.attr('jqbacount', 1)
			.find('.j_m_ratio').text(1);

		$('.icard_buy .jq_delete_item').hide(0).data('id', '').attr('jqid', '');

		$('.icard_buy .jq_buy').fadeIn(500).css('display','inline-block');// Покажем кнопку 'Купить'
//			.siblings('.jq_count').fadeIn(500);

//		$('.icard_buy .jq_buy').css('display','inline-block');// Покажем кнопку 'Купить'
//		$('.icard_buy .jq_bought').hide(0);// Скроем кнонку 'Вкорзине'
//		$('.icard_buy .jq_delete_item').hide(0);

	}
}
/*function i_element_each(id)
{
	var basketid	= $('.jq_basket_id').val().split('↕');
	var result		= false;

	$.each(basketid, function(k, v){
		if( v == id )
			result = true;
	});

	if( result )// ТП в корзине
	{
		$('.icard_buy .jq_buy').attr('jq_id','');// Уберём id для покупки с кнопки 'Купить'
		$('.icard_buy .jq_buy').hide(0);// Скроем кнопку 'Купить'
		$('.icard_buy .jq_bought').css('display','inline-block');// Покажем кнопку 'Вкорзине'
	} else {// ТП не в корзине
		$('.icard_buy .jq_buy').css('display','inline-block');// Покажем кнопку 'Купить'
		$('.icard_buy .jq_bought').hide(0);// Скроем кнонку 'Вкорзине'
	}
}*/
// ---------------------------------------------------------------------------------------------------- Запрос картинок в карточке товара
function i_element_tp_img(idiblock)
{
	var idb		= idiblock.split('↕');
	/*
	 $('.jq_nophoto, .jq_cele_img_sw, .jq_cele_nav_img_block').hide();// Скроем nophoto/фото товара/навигацию
	 $('.jq_ele_photo').children('div').hide();
	 */
	// Картинка уже подгружалась
	if( $('.jq_ele_photo').find('.jq_cele_img_sw_'+idb[1]).length )
	{
		$('.jq_nophoto, .jq_cele_img_sw, .jq_cele_nav_img_block').hide();// Скроем nophoto/фото товара/навигацию
		$('.jq_ele_photo').children('div').hide();

		$('.jq_ele_photo').children('.jq_cele_img_sw_'+idb[1]).show();
		$('.jq_ele_photo').children('.jq_cele_nav_img_block_'+idb[1]).show();
		$('.jq_ele_photo').show();
	} else {// Если нет картинки

		var result = $.ajax({
			type: 'POST',
			async: false,
			url: '/local/templates/ilab_it_shop/ilab/ajax/tp_img.php',
			data: 'idiblock='+idiblock,
			success: function(z)
			{ return z; }
		}).responseText;

		if( result )// В массиве есть картинки
		{
			$('.jq_nophoto, .jq_cele_img_sw, .jq_cele_nav_img_block').hide();// Скроем nophoto/фото товара/навигацию
			$('.jq_ele_photo').children('div').hide();

			$('.jq_ele_photo').append( result );
			$('.jq_ele_photo').show();

			i_element_fancybox('jq_fancybox_'+idb[1]); // fancybox - детальная картинка
			i_element_swiper('jq_cele_img_sw_'+idb[1], 'jq_cele_nav_img_block_'+idb[1]);// Swiper - детальная картинка
		} else {// В массиве нету картинок
			if( $('.jq_cele_img_sw').length )
			{
				$('.jq_nophoto').hide();// Скроем nophoto
				$('.jq_ele_photo').children('div').hide();

				$('.jq_cele_img_sw, .jq_cele_nav_img_block').show();
			} else {
				$('.jq_cele_img_sw, .jq_cele_nav_img_block').hide();// Скроем фото товара/навигацию
				$('.jq_ele_photo').children('div').hide();

				$('.jq_nophoto').show();
			}
		}
	}
}
// ---------------------------------------------------------------------------------------------------- Запрос цены в карточке товара

function i_element_tp_price(idiblock)
{
	var idb		= idiblock.split('↕');

	$('.i_icard_price_block').addClass('i_icard_price_loader');
//	$('.icard_noprice, .jq_ele_price_first, .jq_ele_price').hide();// Скроем нет цены/цены/nophoto/фото товара
//	$('.jq_ele_price').children('div').hide();

	// Цена уже подгружалась
	if( $('.jq_ele_price').find('.jq_cele_price_'+idb[1]).length )
	{
		$('.jq_ele_price').children('div').hide();
		$('.icard_noprice, .jq_ele_price_first').hide();// Скроем нет цены/цена товара

		$('.jq_ele_price').children('.jq_cele_price_'+idb[1]).show();
		$('.jq_ele_price').show();
	} else {// Если нет цены
		var result = $.ajax({
			type: 'POST',
			async: false,
			url: '/local/templates/ilab_it_shop/ilab/ajax/tp_price.php',
			data: 'idiblock='+idiblock,
			success: function(z)
			{ return z; }
		}).responseText;

		if( result )// В массиве есть цена
		{
			$('.jq_ele_price').children('div').hide();
			$('.icard_noprice, .jq_ele_price_first').hide();// Скроем нет цены/цена товара

			$('.jq_ele_price').append( result ).show();
		} else {// В массиве нету цены
			$('.jq_ele_price').children('div').hide();
			$('.jq_ele_price_first, .jq_ele_price').hide();// Скроем цена товара/цены ТП

			$('.icard_noprice').show();
		}
	}
	$('.i_icard_price_block').delay(2000).removeClass('i_icard_price_loader');
}
// ---------------------------------------------------------------------------------------------------- Откликали ТП
function i_element_return()
{
	$('.icard_noprice, .jq_ele_price, .jq_ele_photo').hide();// Скрыли в корзине/цены ТП/картинки ТП

	$('.icard_buy .jq_bought').hide(0)// Скроем кнонку 'Вкорзине'
		.siblings('.jq_delete_item').hide(0).data('id', '').attr('jqid', '')
		.children('.j_m_ratio').text(1);

	$('.j_item_favorite').attr('jq_id', '');
	$('.j_item_favorite').attr('jq_bid', '');


	$('.icard_buy .jq_buy').attr('jq_id','');//.fadeIn(500);// Покажем кнопку 'Купить'
//		.siblings('.jq_count').fadeIn(500);

//	$('.icard_buy .jq_buy').attr('jq_id','').show();// Убрали id для покупки товара/Показали кнопку 'Купить'

	$('.jq_ele_price_first, .jq_buy').show();

	// Показали картинки товара
	if( $('.jq_cele_img_sw').length )
		$('.jq_cele_img_sw, .jq_cele_nav_img_block').show();
	else
		$('.jq_nophoto').show();

	//отжали кнопку избранного
	var ch = $('.j_item_favorite').data('change_text').txt_default;

	$('.j_item_favorite').removeClass('i_item_favorite_act').find('span').text(ch);
}
/*function i_element_return()
{
	$('.icard_noprice, .jq_bought, .jq_ele_price, .jq_ele_photo').hide();// Скрыли в корзине/цены ТП/картинки ТП
	$('.icard_buy .jq_buy').attr('jq_id','').show();// Убрали id для покупки товара/Показали кнопку 'Купить'

	$('.jq_ele_price_first, .jq_buy').show();

	// Показали картинки товара
	if( $('.jq_cele_img_sw').length )
		$('.jq_cele_img_sw, .jq_cele_nav_img_block').show();
	else
		$('.jq_nophoto').show();
}*/
// ---------------------------------------------------------------------------------------------------- Баннер в карточке товара
function i_element_swiper(sw, nav)
{
	var sw = $('.'+sw);// TODO
	var nav = $('.'+nav);// TODO

	var SwiperCatalogElement = new Swiper(sw, {
		slidesPerView:				1,
		loop:						true,
		grabCursor:					true,

		autoplay: {
			delay: 5432,
		},
		on: {
			slideChange: function () {
				nav.find('.i_cele_nav_act').removeClass('i_cele_nav_act');
				$(' span:eq('+this.realIndex+')', nav).addClass('i_cele_nav_act');
			}
		}
	});

	if( sw.is(':not(.jq_sw_auto)') )
		SwiperCatalogElement.autoplay.stop();

	// Навигация
	nav.on('click', 'span', function(e){
		SwiperCatalogElement.slideTo($(this).index()+1);
	});
}
// ---------------------------------------------------------------------------------------------------- Fancybox в карточке товара
function i_element_fancybox(cl)
{
	$('.'+cl).fancybox({
		// Enable infinite gallery navigation
		loop : true,
		// What buttons should appear in the toolbar
		slideShow : false,
		thumbs: {
			showOnStart : true, // Display thumbnails on opening
		}
	});
	// old version 3 beta
	/*
	 $('.'+cl).fancybox({
	 openEffect : 'elastic',
	 closeEffect : 'fade',
	 fitToView: true,

	 padding : 0,
	 helpers : {
	 thumbs : true,
	 title : {
	 type : 'float'
	 }
	 },
	 afterLoad : function() {
	 this.inner.prepend('<h1 class="fancybox_ititle">'+this.title+'</h1>');
	 this.title = 'Изображения ' + (this.index + 1) + ' из ' + this.group.length + (this.title ? ' - ' + this.title : '');
	 }
	 });
	 */
}
// ---------------------------------------------------------------------------------------------------- Принудительная загрузка img в скрытых стилях
var cache = [];
$.preLoadImages = function() {
	var args_len = arguments.length;
	for (var i = args_len; i--;)
	{
		var cacheImage = document.createElement('img');
		cacheImage.src = arguments[i];
		cache.push(cacheImage);
	}
}
// ---------------------------------------------------------------------------------------------------- Basket|Favorite
function i_addBasket(url, id, quan, type, lid, sku_code, m_succes, mbuy, m_s_quan, $name, $price)
{
	var th = $('a.jq_buy[jq_id="'+id+'"]');
	var basketid = $('.jq_basket_id');

	// favorite
	var fav = th.parents('.jq_item').find('.j_item_favorite');

	$.ajax({
		type: 'POST',
		url: url,
		data: 'id='+id+'&quan='+quan+'&type='+type+'&lid='+lid+'&sku_code='+sku_code,
		success: function(bid)
		{
			$('.jq_basket_id').data('ids').push(id);
			basketid.data('d')[id] = {id: bid, quant: m_s_quan<quan ? m_s_quan : quan, price: $price};
			basketid.data('l')[bid] = id;

			i_basket_sum(lid);

				if( mbuy.length )
					mbuy.fadeOut();

				m_succes.find('.j_quan_miss, .j_bask_succes').hide();
				if( m_s_quan<quan ) {
					m_succes.find('.j_q_m').text(m_s_quan).parents('.j_quan_miss').show();
					th.siblings('.jq_bought').attr('jqbacount', m_s_quan);
				} else
					m_succes.find('.j_bask_succes').show();

				m_succes.fadeIn(400)
					.delay(10000).fadeOut(400);


				if( fav.length )
				{
					fav.attr('jq_bid', '').removeClass('i_item_favorite_act').find('span').text( fav.data('change_text').txt_default );
					fav.siblings('.j_favorite_success').stop().fadeOut(400);
				}

				th.siblings('.jq_bought').removeClass('i_buy_loader');
				th.siblings('.jq_delete_item').attr('data-id', bid).attr('jqid', bid).data('id', bid).show();

//				$(this).parents('.jq_item').find('.jq_favorite').attr('jq_bid','').removeClass('i_item_favorite_act').find('span').text($(this).parents('.jq_item').find('.jq_favorite').data('change_text').txt_default);
//				$(this).parents('.jq_item').find('.j_favorite_succes').stop().fadeOut(400)// FADEOUT(очистка очереди)

//console.log('add_to_cart', [id], 'count='+[quan]+'&price='+[$price]);
//				netpeak_cloud.trigger('add_to_cart', [id], 'count='+[quan]+'&price='+[$price]);
//console.log('work');
				/*dataLayer.push({
					'event': 'addToCart',
					'ecommerce': {
						'currencyCode': 'KZT',
						'add': {
							'products': [{
								'name': $name,
								'id': id,
								'price': $price,
								'quantity': quan
							}]
						}
					}
				});*/
		}
	});
}
/*function i_addBasketFavorite(url, id, quan, type, lid, sku_code, m_succes, m_s_quan)
{
	var th = $('a.jq_buy[jq_id="'+id+'"]');
	var basketid = $('.jq_basket_id');

	$.ajax({
		type: 'POST',
		url: url,
		data: 'id='+id+'&quan='+quan+'&type='+type+'&lid='+lid+'&sku_code='+sku_code,
		success: function(bid)
		{
			$('.jq_basket_id').data('ids').push(id);
			basketid.data('d')[id] = {id: bid, quant: m_s_quan<quan ? m_s_quan : quan};//, price: $price
			basketid.data('l')[bid] = id;

			i_basket_sum(lid);

				m_succes.find('.j_quan_miss, .j_bask_succes').hide();
				if( m_s_quan<quan ) {
					m_succes.find('.j_q_m').text(m_s_quan).parents('.j_quan_miss').show();
					th.siblings('.jq_bought').attr('jqbacount', m_s_quan);
				} else
					m_succes.find('.j_bask_succes').show();

				m_succes.fadeIn(400)
					.delay(10000).fadeOut(400);

				th.siblings('.jq_bought').removeClass('i_buy_loader');
				th.siblings('.jq_delete_item').attr('jqid', bid).data('id', bid).fadeIn();
		}
	});
}*/
function i_addFavorite(url, id, quan, type, lid, sku_code)
{
	var result = $.ajax({
		type: 'POST',
		async: false,
		url: url,
		data: 'id='+id+'&quan='+quan+'&type='+type+'&lid='+lid+'&sku_code='+sku_code,
		success: function(z)
		{
			i_basket_sum(lid);
			$('.jq_favorite_id').data('id').push(id);
			$('.jq_favorite_id').data('bids')[id] = z;
			return z;
		}
	}).responseText;

	if( result )
		return result;

}
/*function i_addBasketFavorite(url, id, quan, type, lid, sku_code)
{
	var result = $.ajax({
		type: 'POST',
		async: false,
		url: url,
		data: 'id='+id+'&quan='+quan+'&type='+type+'&lid='+lid+'&sku_code='+sku_code,
		success: function(z)
		{ return z; }
	}).responseText;

	if( result )
	{
		i_basket_sum(lid);

		return result;
	}
}*/
// ---------------------------------------------------------------------------------------------------- Клик вне элемента
function i_outside_element(classes)
{
	$(document).click(function(ev) {
//		console.log($(ev.target));
//		console.log($(ev.target).parents().filter(classes).length);
//		console.log($(ev.target).filter(classes).length != 1);
		if ( ($(ev.target).parents().filter(classes).length < 1) && ($(ev.target).filter(classes).length < 1) )
			i_hide();
	});
}
// ---------------------------------------------------------------------------------------------------- Скрытие элементов по клику вне области || esc
function i_hide(status)
{
	$('.jq_sub, .jq_mo, .jq_teaser_i_modal, .jq_teaser_i_delta, .jq_reviews_reply_form').hide();// HIDE
	$('.jq_modal, .jq_quick_order_modal, .jq_unit_quick_order_modal').fadeOut(400);// FADEOUT
	$('.jq_buy_succes, .jq_compare_succes, .jq_select_offers, .jq_quor').stop().fadeOut(400);// FADEOUT(очистка очереди)

	$('.jq_tm_a').removeClass('i_tm_hover');// Уберём весь hover с 1ур.
	$('.jq_sub_a').removeClass('i_sub_selected');// Уберём весь selected c 2ур.

	if(status!='BUY_MENU')
	{
		$('.jq_vmenu_arrow').parent('.i_vmenu_div_1').removeClass('i_vmenu_div_1_activ');
		$('.jq_hmenu_arrow').removeClass('i_hmenu_a_1_activ');
		$('.jq_vsub_1, .jq_hsub_1').css('visibility', 'hidden');
		$('.jq_mbuy').hide();
		$('.j_compare_succes').hide();
//		console.log('jq_mbuy hide');
	}

	// Меню которое раскрывается
	$('.jqc_vmenu_catalog').children('.jq_vmenu_catarr').removeClass('i_vmenu_carrt');
	$('.jqc_vmenu_out').removeClass('i_vmenu_box jqc_open').slideUp(function(){ $('.jqc_vmenu_catalog').addClass('ibr5i'); });

	$('.jq_opacity').fadeOut(400).css('height','');// (скроем черно-прозрачный фон) (уберём стиль высоты)

	$('.bx_filter_popup_result').fadeOut();

// -------------------------------------------------- Скроем меню
	var vme = $('.jq_vmenu_catalog').siblings('.jq_vmenu_out');
	if( vme.find('.jq_vmenu_hide:hidden').length==0 )
		i_hide_vmenu( vme );
}
// ---------------------------------------------------------------------------------------------------- Скрытие главного вертикального меню
function i_hide_vmenu(vme)
{
	vme.removeClass('i_vmenu_box').animate({height:window.i_vermenu+34},500, function(){
		$('.jq_vmenu_hide').css('display','none');
		$('.jq_buttom_vmenu').removeClass('i_buttom_vmenu_activ');
	});//+34(последний пунк для плашки раскрытия)
	$('.jq_vmenu_catalog').children('.jq_vmenu_catarr').removeClass('i_vmenu_carrt');
}
// ---------------------------------------------------------------------------------------------------- Opacity
function i_opacity ()
{	$('.jq_opacity').css('height', $(document).height() ).show()	}
// ---------------------------------------------------------------------------------------------------- Modal
function i_modal(iclass, id, mode, th)
{
	$('.jq_modal_in > div').hide().removeClass('idblocki');// Скрыть все div внутри
	$('.jq_modal_tit > span').hide().removeClass('idblocki');// Скрыть все span внутри

	$('.jq_modal').attr('id','').css({'top':'','bottom':''}).removeClass('iohid');

	if(mode && th)
	{
		var offs = Math.round(th.offset().top);
		if( $('#bx-panel').length>0 )// Если есть панель битрикс -_-
			var offs = offs - Math.round( $('#bx-panel').height() );
	}

	if(mode=='bottom' && th)
		$('.jq_modal').css('bottom', Math.round($('.i_wrapper').height())-offs +'px' );

	if(mode=='top' && th)
		$('.jq_modal').css('top', offs+'px' );

	if(iclass)
		$(iclass).show().addClass('idblocki');
	if(id)
		$('.jq_modal').attr('id', id);

	i_opacity();// Показать тень
	$('.jq_modal').fadeIn(400);// Показать модальное окно

	if(mode=='center' && th)
	{
		var ff	= Math.round($('.jq_modal').height()/2);
		offc	= offs-ff;
		$('.jq_modal').css('top', offc+'px' );
	}
}
// ---------------------------------------------------------------------------------------------------- Сумма в корзине
function i_basket_sum (lid)
{
	var ps = $.ajax({
		type: 'POST',
		async: false,
		url: '/local/templates/ilab_it_shop/ilab/ajax/basket_sum.php',
		data: 'lid='+lid,
		success: function(z)
		{ return z; }
	}).responseText;
//	console.log(ps);

	var ps = ps.split('|');

	var sum = ps[0];
	var nds = ps[1];
	var cou = ps[2];

	$('.jq_basket_pr').text( sum );// Обновим общую сумму
//	$('.jq_basket_nds').text( nds );// Обновим НДС
	$('.jq_basket_co').text( cou );// Обновим кол-во
}
// ---------------------------------------------------------------------------------------------------- Кнопка сравнить Compare
/*
 function i_Compare(element, idiblock, prop)//, idib, name, img, ahref, dhref
 {
 //	console.log(element+' | '+idiblock+' | '+prop);
 var th			= $(element);// Элемент
 var href		= element.href;// Ссылка на .get
 var idiblock	= idiblock.split('|');// ID|IBLOCK

 if( th.is('.jq_item_compare_act') )// Если добавлен в сранение
 {
 //i_delToCompare(idiblock, 'one');// Удалить с сравнение
 i_сompare_buttom(th, 'remove');// Изменение кнопочки 'Сравнить'
 }else{// Если не в сравнение
 //i_addToCompare(href, idiblock[0]+'†'+prop);// Добавим в сравнение
 i_сompare_buttom(th, 'add');// Изменение кнопочки 'Сравнить'
 }
 return false;
 }
 // Добавить в сравнение
 function i_addToCompare(href, prop)
 {
 //	console.log(prop);
 var prop	= prop.split('†');
 $.get(
 href,
 $.proxy(function(data) {
 if(data){
 var co	= +$('.jq_comp_count_click').children('.jq_comp_count').text();
 var ele	= '<a href="'+prop[1]+'" class="it_comp_list_a jq_comp_list_a" id="jq_list_'+prop[0]+'"><div class="it_comp_list_img"><img alt="'+prop[3]+'" title="'+prop[3]+'" src="'+prop[2]+'"></div><div class="it_comp_list_name ifleft">'+prop[3]+'</div></a>'
 $('.jq_comp_list_item').append(ele);// Добавим в сравнение
 $('.jq_comp_count').text( co+1 );// кол-во
 }
 })
 );
 }
 // Удалить с сравнение
 function i_delToCompare(idiblock, status)
 {
 $.post(
 '/ilab/ajax/compare_onedel.php',
 { istatus: status, id: idiblock },
 function(z){
 if(z == 'one')
 {
 var co = +$('.jq_comp_count_click').children('.jq_comp_count').text();
 $('#jq_list_'+idiblock[0]).remove();
 $('.jq_comp_count').text( co-1 );// кол-во
 }else if(z == 'all'){
 $('.jq_comp_list_item').empty();
 $('.jq_comp_count').text('0');
 $('.jq_comp_ele_add').removeClass('it_comp_ele_add jq_comp_ele_add').children('span').text('Сравнить');
 }else
 alert('ошибка удаление товара с сравнения');
 });
 }
 // Что должно быть с кнопкой после добавление в сравнение
 function i_сompare_buttom(element, status)
 {
 var th = $(element);
 var iclass = 'i_item_compare_act jq_item_compare_act';
 i_hide();

 if(status == 'add')
 th.addClass(iclass).text('В сравнении')
 .siblings('.jq_compare_succes').fadeIn(400)
 .delay(10000).fadeOut(400);
 else if(status == 'remove')
 th.removeClass(iclass).text('Сравнить');
 }
 */
// Ресайз окна сравнения
function i_compare_wsize (iclass, istatus)
{
	/*-*/if(istatus == 'width'){
	var b_width = $(window).width();// width - окна браузера
	var m_width = $('.'+iclass).find('.jqcomp_pro').length*250+40;// width - элемента без margin'ов/40 это padding: 0 20px;         // DELETE $('.'+iclass).outerWidth();
//console.log(b_width+' | '+m_width);
	if( m_width>b_width )// Width элемента>браузера
	{
		var b_width = b_width - 50;// Отступы по бокам
		var imarl = Math.floor(b_width/2);// margin-left

		$('.'+iclass).css('width', b_width+'px');
		$('.'+iclass).css('margin-left', '-'+imarl+'px');
	}else{
		var imarl = Math.floor(m_width/2);// margin-left

		$('.'+iclass).css('width', '');
		$('.'+iclass).css('margin-left', '-'+imarl+'px');
		$('.jqcomp_arr').hide();
	}
	/*-*/}else if(istatus == 'height'){
	var b_height = $(window).height();// height - окна браузера
	var p_height = $('.jqprop-wrapper').outerHeight();
	var m_height = p_height+312;// height - элемента без margin'ов/265 высота до характеристик и padding: 20px 0//$('.'+iclass).outerHeight();
//console.log(b_height+' | '+m_height+' | '+$('.jqprop-wrapper').outerHeight());
	if( m_height>b_height )// Height элемента>браузера
	{
//console.log('rabota1');
		var b_height = b_height - 50;// Отступы по бокам
		var imarl = Math.floor(b_height/2);// margin-top

		$('.'+iclass).css('height', b_height+'px');
		$('.'+iclass).css('margin-top', '-'+imarl+'px');

		var swprop_height = b_height - 312;

		$('.jqprop-container').css('height', swprop_height);
	}else{
//console.log('rabota2');
		var imarl = Math.floor(m_height/2);// margin-top

		$('.'+iclass).css('height', m_height+'px');
		$('.'+iclass).css('margin-top', '-'+imarl+'px');
		$('.jqprop-container').css('height', p_height);
		$('.jqprops_arr').hide();
	}
	/*-*/}
}
// ---------------------------------------------------------------------------------------------------- Reload captcha
function i_reload_captcha (cl, th)
{
	if( th.attr('src') == '/local/templates/ilab_it_shop/ilab/img/recaptcha.gif' )
	{
		th.attr('src','/local/templates/ilab_it_shop/ilab/img/recaptcha_anim.gif');

		setTimeout(function(){
			th.attr('src','/local/templates/ilab_it_shop/ilab/img/recaptcha.gif')
		}, 1000);

		var il_succes = $.post(
			'/local/templates/ilab_it_shop/ilab/ajax/reload_captcha.php',
			function(z)
			{	$(cl).attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + z);
				$(cl).attr('jq_code', z)	}
		);
	}
//	il_succes.complete(function(){});
}
// ---------------------------------------------------------------------------------------------------- Delete Basket
function il_basket_del_item (id)
{
	var ps = $.ajax({
		type: 'POST',
		async: false,
		url: '/local/templates/ilab_it_shop/ilab/ajax/delete2basket.php',
		data: 'id='+id,
		success: function(z)
		{ return z; }
	}).responseText;

	return 'true';
}
// ---------------------------------------------------------------------------------------------------- Limit checkout
function ok_limit_order ()
{
	if( $('.jq_checkout').attr('jq_chec_act')=='Y' )
	{
		allsum		= +$('#allSum_FORMATED').text().split(/\s(?=[^0-9])/)[0].replace(/\s/g,'').replace(/,/, '.');
		jqsum		= +$('.jq_checkout').attr('jqsum');
//		console.log(allsum+' '+jqsum);

//		console.log(allsum+''+jqsum);
		if( allsum<=jqsum )
		{
			$('.jq_checkout').addClass('i_checkout_inactive').attr('onclick', '');
			$('.jq_chec_modal').fadeIn();
			/*console.log('ra1');*/
		} else {
			$('.jq_checkout').removeClass('i_checkout_inactive').attr('onclick', 'checkOut();');
			$('.jq_chec_modal').fadeOut();
			/*console.log('ra2');*/
		}
	}
}
// ---------------------------------------------------------------------------------------------------- Проверка корректности емайл адреса
function il_email(str)
{
	var regexp = /^[^@\+]+@[^@\+]+\.[^@\+]{2,4}$/;
	return regexp.test( decodeURIComponent(str) );
}
function il_aemail()
{
	$('body').find('[jqajemail="Y"]').each(function(){
		$(this).inputmask({
			mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
			greedy: false,
			definitions: {
				'*': {
					validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
					cardinality: 1,
					casing: "lower"
				}
			}
		});
	});

	$('body').find('[jqajfid="TELEPHONE_s1"], [jqajfid="MOBILE_TELEPHONE_s1"]').each(function(){
		var t = $(this);

		if( t.val().length )
			t.val( t.val().slice(1) );

		t.inputmask({mask: '+7 (999) 999-99-99' });
	});
}

// ---------------------------------------------------------------------------------------------------- substr_count
function substr_count( haystack, needle, offset, length ) {	// Count the number of substring occurrences
	// 
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

	var pos = 0, cnt = 0;

	if(isNaN(offset)) offset = 0;
	if(isNaN(length)) length = 0;
	offset--;

	while( (offset = haystack.indexOf(needle, offset+1)) != -1 ){
		if(length > 0 && (offset+needle.length) > length){
			return false;
		} else{
			cnt++;
		}
	}

	return cnt;
}

function unique(arr) {
	var obj = {};

	for(var i=0; i<arr.length; i++) {
		var str = arr[i];

		obj[str] = true; // запомнить строку в виде свойства объекта

	}

	return Object.keys(obj); // или собрать ключи перебором для IE<9
}

function in_array(what, where) {
	for(var i=0; i<where.length; i++)
		if(what == where[i])
			return true;
	return false;
}
// ---------------------------------------------------------------------------------------------------- Change price
function il_mbuy_price(th, n)
{

	var f			= th.parents('.jq_buy_count');
	var el			= th.parents('.jq_cele');
	var num			= +n;//+f.find('.jq_conumb').val();

	if( el.length )
	{
		el.find('.jq_conumb').val(num);
		f			= el.find('.jq_buy_count');
		var buy		= el.find('.jq_buy');
	} else {
		var buy		= f.find('.jq_buy');
	}

	if( buy.attr('jq_id').length )
		var buy_id		= buy.attr('jq_id');
	else
		var buy_id		= $('.jq_matrix_block .jq_matrix:first').attr('jqmpsku');

	if( f.length )
	{
		var arr		=  f.find('.jq_mtnumb').slice(0, 1).text().split(/\s(?=[^0-9])/);// [1]
		var sum		= +f.find('.jq_mtnumb').attr('jqmsum');
//		var buy		=  f.find('.jq_buy');

// расчёт суммы
		if( f.find('.jq_matrix[jqmpsku='+buy_id+']').find('.jq_mparr').length )
		{
			var cal		=  f.find('.jq_matrix[jqmpsku='+buy_id+']').find('.jq_mparr').val().split('*');
			$.each(cal, function(i,ele){
				var e = ele.split('|');
				var from	= +e[0];
				var to		= +e[1];
//			console.log(typeof(from)+'|'+typeof(to)+'|'+typeof(+e[0])+'|'+typeof(e[1])+'|'+typeof(num));
				/*
				 e[0] - FROM
				 e[1] - TO
				 e[2] - PRICE
				 */
				if( from==0 && num<=to )
					sum = e[2];//console.log(from+'==0 && '+num+'<='+to+'===');
				else if( to==0 && num>=from )
					sum = e[2];//console.log(to+'==0 && '+num+'>='+from+'===');
				else if( n>=from && num<=to )
					sum = e[2];//console.log(num+'>='+from+' && '+num+'<='+to+'===');
			});
//		console.log(cal);
		}
//		console.log(arr);
//		console.log(sum);
//		console.log(num);

		var stot	= parseFloat((sum*num).toFixed(2));

//		console.log(stot);

		var tot		= String(stot).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ').replace('.', ',');

//		console.log(tot);
		if( el.length )
			f.find('.jq_mtnumb').empty();;

		f.find('.jq_mtnumb').text(tot+' '+arr[1]);
	} else {

	}

	buy.attr('jqcount', num).siblings('.jq_bought').attr('jqbacount', num);
}
function il_cop_price(th, n)
{
	th.parents('.jq_item').find('.jq_buy').attr('jqcount', n).siblings('.jq_bought').attr('jqbacount', n);
}
function il_quan_factor(th)
{
	var val		= parseFloat( th.val() );// Количество пользователь
	var factor	= parseFloat( th.attr('jqmeasure') );// Коэффициент
	if( !val )
		val		= factor;
	// Проверка коэффицента
	/*console.log( val+'|'+factor );
	 console.log( val/factor );
	 console.log( +(val/factor) );
	 console.log( +(val/factor).toFixed(10) )
	 console.log( isInteger(+(val/factor).toFixed(10)) );
	 console.log( !isInteger(+(val/factor).toFixed(10)) );*/
	if( !isInteger(+(val/factor).toFixed(10)) )//Если кол-во не удовлетворяет коэффиценту
	{
		var fix	= 2;// Убираем дроби - toFixed
		var fa	= factor.toString().split('.');// Пилим дробь в массив
		/*
		 if(fa[1] && fa[1].length == 1)
		 var fix = 1;// Округлим до десятых - toFixed
		 else if( fa[1] )
		 var fix = 2;// Округлим до сотых - toFixed (макс. округление)
		 */
		var val = +val.toFixed(fix);// Округлённое число в val для дальнейших махинаций
	}
	return val;// Занесём значение в input
}
// Проверка целого цисла
function isInteger(num) {
	return (num ^ 0) === num;
}

function il_adap_cat() {
	if($('.i_cat_list_left').css('display')=='none' && $('.i_cat_list_left').children('.i_cat_menu').length)
	{
		$('.i_cat_menu, .bx_filter, .i_cat_leftbanner').prependTo($('.i_cat_list_right'));
	}
	else if($('.i_cat_list_left').css('display')!='none' && $('.i_cat_list_right').children('.i_cat_menu').length)
	{
		$('.i_cat_menu, .bx_filter, .i_cat_leftbanner').prependTo($('.i_cat_list_left'));
	}
}

function i_cele_property_click(th, cl, st) {
	var of = Math.round($('.jq_ai_but_top a[jq_ai_but="' + th.attr('jq_ai_but') + '"]').offset().top) - 15;

	$('.jq_ai_but').removeClass('i_ai_but_act');
	$('[jq_ai_but="' + th.attr('jq_ai_but') + '"]').addClass('i_ai_but_act');
	$('.jq_ai_content').children('div').hide();
	$('[jq_ai_content="' + th.attr('jq_ai_but') + '"]').fadeIn();

	if (th.parent('.jq_ai_bottom').length) {
		$('html, body').animate({scrollTop: of}, 'slow');
	}
	if(st === true)
		$('.j_offers_sl_mobile option[jq_ai_but="' + th.attr('jq_ai_but') + '"]').prop('selected', true).trigger('refresh');

	$('div.j_offers_sl_mobile .jq-selectbox__select').attr('data-class',cl);
}

/* ------------------------------------------------------------------------------------------------ Hide Sticker Sblock function -*/
function i_hide_sblock_stickers() {
	if( $('.i_sblock').length )
	{
		var w_sb = $('.i_sblock').width();
		var p_sb = $('.i_sblock').offset().left;

		$('.i_item_stiker').each(function (e) {

			var sp = $(this).offset().left;
			//console.log(p_sb);
			if (sp-p_sb > w_sb-20) {
				$(this).css('visibility', 'hidden');
			}
			else {
				$(this).css('visibility', 'visible');
			}
		});
	}
}

function pre_text_item() {
    $('.js_cs_cat .jq_item .i_item_name').each(function(indx, element){
       if ($(this).height() > 18)
       {
       		$(this).siblings('.i_pre_txt').css('top','60px');
	   }else
           $(this).siblings('.i_pre_txt').css('top','40px');
    });
}

function validEm(email) {
	var regexp = '^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$';
	return regexp.test( decodeURIComponent(email) );
}

// ---------------------------------------------------------------------------------------------------- Vertical menu more
function vm_menu_status(w)
{
	if(
		$('.j_vm_li.i_vm_select').length > 1 && w>640
		||
		$('.j_vm_li.i_vm_select').length && $('.j_v_menu').height()==0
	)
		$('.i_vm_select').toggleClass('i_vm_select', false).children('ul.j_vm_ul').hide();

	if( w>920 )
		window.vm_h = $('nav.j_v_menu_bl').data('height');
	else
		window.vm_h = 0;

	window.vm_hall = 0;
	$('ul.j_v_menu > li.j_vm_li').each(function(){
		window.vm_hall += $(this).outerHeight(true);
	});
}

// ---------------------------------------------------------------------------------------------------- iLaB Functions
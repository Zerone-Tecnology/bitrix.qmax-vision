// ---------------------------------------------------------------------------------------------------- iLaB Script | FUNCTIONS [local/templates/ilab_it_shop/ilab/js/functions.js]
$(document).ready(function(){

// ---------------------------------------------------------------------------------------------------- Авторизация\Регистрация
	// Открыть авторизацию
	$('body').on('click', '.jq_auth_personal', function(){
		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_auth',
				addId: 'i_pos_auth',
				position: {
					horizontal: 'right',
				}
			});

		return false;
	});

	$('body').on('click', '.jq_fp_auth_personal', function(){
		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_auth',
				addId: 'i_fp_pos_auth',
				fixed: true,
				position: {
					horizontal: 'right',
					vertical: 'outerTop'
				}
			});

		return false;
	});

	$('body').on('click', '.jq_registration', function(){
		var id = $('.j_modal').data('params') ? $('.j_modal').data('params').addId : false;

		if( id =='i_fp_pos_auth' )
		{
			$.ilab('Modal',
				{
					button: $('.jq_fp_auth_personal'),
					showClass: '.j_m_regi',
					addId: 'i_fp_pos_regi',
					fixed: true,
					position: {
						horizontal: 'right',
						vertical: 'outerTop'
					}
				});
		}
		else /*if( id =='i_pos_auth' )*/
		{
			$.ilab('Modal',
				{
					button: $('.jq_auth_personal'),
					showClass: '.j_m_regi',
					addId: 'i_pos_regi',
					position: {
						horizontal: 'right',
					}
				});
		}

		return false;
	});

	// Ошибки авторизации
	if( $('.jq_auth_error').length > 0 )
		$('.jq_auth_personal').click();

	// Ошибки регистрации
	if( $('.jq_reg_error').length > 0 )
		$('.jq_registration').click();

// ---------------------------------------------------------------------------------------------------- Delivery
	$('body').on('click', '.jq_ad_fdel', function(){
		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_del',
				addId: 'i_pos_del',
				position: {
					horizontal: 'center'
				}
			});

		return false;
	});
// ---------------------------------------------------------------------------------------------------- Payment
	$('body').on('click', '.jq_ad_fpay', function(){
		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_pay',
				addId: 'i_pos_pay',
				position: {
					horizontal: 'center'
				}
			});

		return false;
	});
// ---------------------------------------------------------------------------------------------------- Map Footer
	$('body').on('click', '.jq_fmap', function(){

		if( $('.jq_fmap_div.ivhid').length )
			$('.jq_fmap_div.ivhid').removeClass('ivhid').hide();

		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_map',
				addId: 'i_pos_map',
				position: {
					horizontal: 'left',
					vertical: 'outerTop',
					880: {
						horizontal: 'right',
						vertical: 'outerTop'
					}
				}
			});

		/*if( $(this).attr('jq_id') == 'i_pos_map' )
		 i_modal('.jqm_map', $(this).attr('jq_id'));
		 else
		 i_modal('.jqm_map', 'i_bpos_map', 'bottom', $(this));*/

		/*if( $('.jqm_map [jqmapy]').length )// если карты Яндекс, вызовим их!
		 {
		 $('.jqm_map [jqmapy]').each(function(indx){
		 var map_id = $(this).attr('jqmapy');
		 ymaps.ready(eval(map_id));
		 });
		 }
		 if( $('.jqm_map [jqmapg]').length )// если карты Google, вызовим их!
		 {
		 $('.jqm_map [jqmapg]').each(function(indx){
		 var map_id = 'init_'+$(this).attr('jqmapg');
		 var pla_id = 'BXShowMap_'+$(this).attr('jqmapg');
		 BX.ready(eval(map_id));
		 BX.ready(eval(pla_id));
		 });
		 }*/

		return false;
	});
	$('body').on('click', '.jq_bs_fmap', function(){

		if( $('.jq_fmap_div.ivhid').length )
			$('.jq_fmap_div.ivhid').removeClass('ivhid').hide();

		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_map',
				addId: 'i_bs_pos_map',
				position: {
					horizontal: 'right',
					vertical: 'outerTop'
				}
			});

		return false;
	});
	$('body').on('click', '.jq_fmap_a', function(){
		var th = $('.jq_fmap_div[jq_id='+$(this).attr('jq_id')+']');

		$('.jq_fmap_div').removeClass('ivhid').hide();
		$('.jq_fmap_a').removeClass('i_fmap_activ');
		$(this).addClass('i_fmap_activ');

		th.fadeIn();
		//map
		return false;
	});
// ---------------------------------------------------------------------------------------------------- basket modal
	$('body').on('click', '.jq_ba_fpay', function(){
		/*if( $(this).attr('jq_basket') == 'Y' )
		 var d_id = 'i_pos_bfpay';
		 else
		 var d_id = 'i_pos_fpay';
		 i_modal('.jqm_fpay', d_id, 'bottom', $(this));*/
		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_pay',
				addId: 'i_pos_ba_fpay',
				position: {
					horizontal: 'center',
					vertical: 'outerTop',
					800: {
						horizontal: 'left',
						vertical: 'outerTop'
					}
				}
			});
		return false;
	});
	$('body').on('click', '.jq_ba_dmet', function(){
		/*if( $(this).attr('jq_basket') == 'Y' )
		 var d_id = 'i_pos_bdmet';
		 else
		 var d_id = 'i_pos_dmet';
		 i_modal('.jqm_dmet', d_id, 'bottom', $(this));*/
		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_del',
				addId: 'i_pos_ba_dmet',
				position: {
					horizontal: 'right',
					vertical: 'outerTop',
					800: {
						horizontal: 'right',
						vertical: 'outerTop'
					}
				}
			});
		return false;
	});
// ---------------------------------------------------------------------------------------------------- Feedback
	$('body').on('click', '.jq_h_feedback, .jq_h_feedback_top', function(){

		$.ilab('Modal',
			{
				button: $('.jq_h_feedback'),
				showClass: '.j_m_feedback',
				addId: 'i_pos_feedback',
				position: {
					horizontal: 'center'
				}
			});

		return false;
	});//i_modal('.jqm_feedback', 'i_pos_feedback');

	/*$('body').on('click', '.j_t_feedback', function(){

	 $.ilab('Modal',
	 {
	 button: $('.jq_hfeedback'),
	 showClass: '.j_m_feedback',
	 addId: 'i_pos_feedback',
	 position: {
	 1080: {
	 horizontal: 'center'
	 },
	 950: {
	 horizontal: 'left'
	 },
	 619: {
	 horizontal: 'center'
	 }
	 }
	 });

	 return false;
	 });*/
// ---------------------------------------------------------------------------------------------------- Быстрый заказ

	$('body').on('click', '.jq_unit_quick_order', function(){
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
	});
	$('body').on('click', '.jq_quick_order', function() {
		var th		= $(this);
		var name	= th.attr('jq_item_name');
		var id		= th.attr('jq_item_id');

		if( id )
		{
			$('.j_m_quick').find('.jq_item_name').text(name);
			$('.j_m_quick').find('[name="id"]').val(id);
			$.ilab('Modal',
				{
					button: $(this),
					showClass: '.j_m_quick',
					addId: 'i_pos_quick',
					position: {
						horizontal: 'left',
						vertical: 'outerBottom'
					}
				});
		} else {
			th.siblings('.jq_quor').fadeIn().delay(10000).fadeOut(400);
		}

		return false;
	});
	// ---------------------------------------------------------------------------------------------------- Добавить отзыв
	$('body').on('click','.jq_add_review', function(){

		if($('.jq_product_ajax').val() == '')
			$('.jq_product_ajax').val($(this).attr('jq_product_ajax'));

		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_review',
				addId: 'i_pos_review',
				position: {
					horizontal: 'left',
					vertical: 'outerBottom'
				}
			});

		return false;
	});

// ---------------------------------------------------------------------------------------------------- Map Footer
	$('.i_footer_flex .j_ad_fmap').click(function(){

		if( $('.jq_fmap_div.ivhid').length )
			$('.jq_fmap_div.ivhid').removeClass('ivhid').hide();

		$.ilab('Modal',
		{
			button: $(this),
			showClass: '.j_m_map',
			addId: 'i_pos_map',
			position: {
				horizontal: 'left',
				vertical: 'outerTop',
				880: {
					horizontal: 'right',
					vertical: 'outerTop'
				}
			}
		});

		if($('ymaps').length <= 0) {
			var myMap = '';
			ymaps.ready(map);
		}

		return false;
	});

	$('.jq_bs_fmap').click(function(){

		if( $('.jq_fmap_div.ivhid').length )
			$('.jq_fmap_div.ivhid').removeClass('ivhid').hide();

		$.ilab('Modal',
		{
			button: $(this),
			showClass: '.j_m_map',
			addId: 'i_bs_pos_map',
			position: {
				horizontal: 'right',
				vertical: 'outerTop'
			}
		});

		return false;
	});

// ---------------------------------------------------------------------------------------------------- Map Footer Basket
	$('body').on('click', '.i_footer_header .j_ad_fmap', function () {

		if( $('.jq_fmap_div.ivhid').length )
			$('.jq_fmap_div.ivhid').removeClass('ivhid').hide();

		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_map',
				addId: 'i_bs_pos_map',
				position: {
					horizontal: 'right',
					vertical: 'outerTop'
				}
			});

		return false;
	});

// ---------------------------------------------------------------------------------------------------- Товар на заказ
	$('body').on('click', '.jq_order_buy', function () {
		var id = $(this).attr('jq_item_id');

		if(!$('.j_to_order_id').val())
			$('.j_to_order_id').val(id);

		$.ilab('Modal',
			{
				button: $(this),
				showClass: '.j_m_to_order',
				addId: 'i_pos_to_order',
				position: {
					horizontal: 'right',
					vertical: 'outerBottom'
				}
			});

		return false;
	});

});
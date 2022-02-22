<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$frame = $this->createFrame('jqm_quick', false)->begin();
$frame->setAnimation(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>
	<form q_order="<?=$arParams['Q_ORDER']?>" name="<?=$arResult['I_SECTION']['CODE']?>" action="/local/templates/ilab_it_shop/ilab/ajax/fast_order.php" method="POST" enctype="multipart/form-data">
		<table>
			<tr>
				<td colspan="2">
					<h4 class="jq_item_name"></h4>
					<ul class="qi_error"></ul>
				</td>
			</tr>
			  <?foreach($arResult['I_ITEMS'] as $e):
				  if( $e['TYPE'] != 'hidden' ):?>
					<tr>
						<td width="90px">
							<b>
								<?=$e['NAME']?>:<?if($e['REQUIRED']):?><font color="red">*</font><?endif?>
							</b>
						</td>
						<td><?=$e['HTML_VALUE']?></td>
					</tr>
				  <?endif;
			  endforeach?>
			<tr>
				<td><img name="loader" src="/local/templates/ilab_it_shop/ilab/img/loader.gif" class="qi_loader idnone ifleft jq_loader"></td>
				<td>
					<div class="jq_buttom_loader ifleft iprel">
						<input class="j_submit_<?=$arParams['Q_ORDER']?>" type="submit" value="<?=GetMessage('TO_ORDER')?>">
					</div>
					<a class="i_order_spec_link jq_order_spec_link ifleft" href="javascript:void(0)"><?=GetMessage('ORDER_SPECIFICATION')?></a>
					<div class="jq_again idnone">
						<font color="green"><b><?=GetMessage('SUCCESS')?></b></font>
					</div>
					<div class="iclear"></div>
				</td>
			</tr>
		</table>
		<div class="i_order_spec jq_order_spec idnone">
			  <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/order_specification.php',Array(),Array('MODE'=>'html', 'NAME'=>'Условия заказ', 'SHOW_BORDER'=>true));// Order specification?>
		</div>
			<?foreach($arResult['I_ITEMS'] as $e)
				if( $e['TYPE'] == 'hidden' )
					echo $e['HTML_VALUE']?>
		<input type="hidden" name="lid" value="<?=SITE_ID?>" jqfields="Y">
		<input type="hidden" name="params" value="<?echo $arParams['I_PERSON'].'|'.$arParams['I_PAY_SYSTEM'].'|'.$arParams['I_DELIVERY']?>" jqfields="Y">
	</form>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


	<script>
		$(document).ready(function(){
			$('body').on('click','.j_submit_<?=$arParams['Q_ORDER']?>',function(){

				var form = $(this).parents('form');

				$(form).ajaxForm({
					data: { FPRO_KEY: '45gsiLab+1qUicK' },
					beforeSubmit: function()
					{
						var required		= false;

						var ar_Field		= form.find('[jqfields="Y"]').fieldSerialize().split('&');// Заберём у input и textarea name=value&name=value&... кроме input[type='submit'], создадим массив

						form.find('.fi_empty').removeClass('fi_empty');
						form.find('.qi_error').empty();

						//form.find('.jq_loader').fadeIn();
						form.find('.jq_buttom_loader').addClass('i_buttom_loader');

						/* Создадим массив по порядку input'ов вида
						<input name="form_text_1" value="Кирилл">
						[form_text_1] = Кирилл
						[0] =>
						[0] => form_text_1
						[1] => Кирилл */

						var f = [];
						for (var i = 0; i < ar_Field.length; i++)
						{
							var val = ar_Field[i].split('=');

							if( val[0]=='telephone' && ( val[1].length < 10 || val[1].length > 12 ) )
							{
								var required = true;// Заполните обязательные поля
								form.find('[name="'+val[0]+'"]').addClass('fi_empty');
							}

							// Если пустое/обязательное поле покрасить в красный
							if( !val[1] && form.find('[name="'+val[0]+'"]').attr('jq_required') == 'Y' )
							{
								var required = true;// Заполните обязательные поля
								form.find('[name="'+val[0]+'"]').addClass('fi_empty');
							}

							if( /email/i.test(val[0]) )// Если email то в переменую email (для удобства)
								var email = val;
							else// Остальные поля в массив f
								f.push( [ val[0], val[1] ] );
						}

						if( required )// Заполните обязательные поля
							form.find('.qi_error').append('<li><?=GetMessage('I_REQUIRED_FIELDS')?></li>');
						else
							form.find('.qi_error').empty();

						if( !il_email(email[1]) )// Проверка корректности емайл адреса
						{
							form.find('.qi_error').append('<li><?=GetMessage('I_VALID_EMAIL')?></li>');
							form.find('[name="'+email[0]+'"]').addClass('fi_empty');
						}

						if( !il_email(email[1]) || required )
						{
//					form.find('.jq_loader').delay(500).fadeOut();
							form.find('.jq_buttom_loader').delay(500).queue(
								function(){
									$(this).removeClass('i_buttom_loader').dequeue();
								});
							return false;// Стоп отправки
						}
					},
					/*success: function(response, textStatus, xhr, form)
					{

						var obj = jQuery.parseJSON(response);

//							console.log(obj);

						dataLayer.push({
							'ecommerce': {
								'purchase': {
									'actionField': {
										'id':		obj.ORDER_ID,// ID заказ
										'revenue':	obj.CSaleOrder.PRICE,// Сумма заказа
										'tax':		obj.CSaleOrder.TAX_VALUE,// НДС
		//								'shipping':	''// Название доставки
									},
									'products':
									[
										{
//												'id': '25341',
//												'name': 'Толстовка Яндекс мужская',
//												'price': 1345.26,
//												'brand': 'Яндекс / Яndex',
//												'category': 'Одежда/Мужская одежда/Толстовки и свитшоты',
//												'variant': 'Оранжевый цвет'
//												'quantity': 3
											'name':		obj.CSaleBasket.NAME,
											'id':		obj.CSaleBasket.PRODUCT_ID,
											'price':	(+obj.CSaleBasket.PRICE)*(+obj.CSaleBasket.QUANTITY),
											'category':	obj.CIBlockSection.NAME,
											'quantity':	obj.CSaleBasket.QUANTITY
										},
									]
								}
							}
						});

		//				ga('require', 'ecommerce');
						ga('ecommerce:addTransaction', {
							'id':			obj.ORDER_ID,											// ID заказа
							'affiliation':	'i-store.kz',											// Название магазина
							'revenue':		(+obj.CSaleBasket.PRICE)*(+obj.CSaleBasket.QUANTITY),	// Общая стоимость заказа
		//					'shipping':		'',														// Стоимость доставки
							'tax':			obj.CSaleOrder.TAX_VALUE								// Налог
						});

						// addItem метод вызывается для каждого товара (позиции) в корзине и склеивается с addTransaction по id.
						ga('ecommerce:addItem', {
							'id':		obj.ORDER_ID,											// ID заказа
							'name':		obj.CSaleBasket.NAME,									// Название товара
							'sku':		obj.CSaleBasket.PRODUCT_ID,								// Артикул или SKU
							'category':	obj.CIBlockSection.NAME,								// Размер, модель, категория или еще какая-то информация
							'price':	(+obj.CSaleBasket.PRICE)*(+obj.CSaleBasket.QUANTITY),	// Стоимость товара
							'quantity':	obj.CSaleBasket.QUANTITY,								// Количество товара
							'currency':	'USD'//obj.CSaleBasket.CURRENCY							// Валюта
						});
						ga('ecommerce:send');

		//				console.log(dataLayer);

					},*/
					complete: function(xhr)
					{
						var form = $('form[name="<?=$arResult['I_SECTION']['CODE']?>"]');

						form.find('input[type="submit"], .jq_order_spec_link, .jq_loader').hide();
						form.find('.jq_buttom_loader').removeClass('i_buttom_loader');
						form.find('.jq_again').fadeIn();
						form.find('.jq_order_spec').slideDown();
					}
				});
			});
		});
	</script>





<?$frame->beginStub()?>
	<div class="i_get_loader"></div>
<?$frame->end()?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arParams)?></pre>
<?endif*/?>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$frame = $this->createFrame('jqm_quick', false)->begin();
$frame->setAnimation(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>
	<form name="<?=$arResult['I_SECTION']['CODE']?>" action="/local/templates/ilab_it_shop/ilab/ajax/to_order.php" method="POST" enctype="multipart/form-data">
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
							<input type="submit" value="<?=GetMessage('TO_ORDER')?>">
						</div>
						<div class="jq_again idnone">
							<font color="green"><b><?=GetMessage('SUCCESS')?></b></font>
						</div>
						<div class="iclear"></div>
					</td>
				</tr>
		</table>
		<?foreach($arResult['I_ITEMS'] as $e)
			if( $e['TYPE'] == 'hidden' )
				echo $e['HTML_VALUE']?>
		<input class="j_to_order_id" jqfields="Y" type="hidden" value="" name="id">
		<input type="hidden" name="lid" value="<?=SITE_ID?>" jqfields="Y">
		<input type="hidden" name="params" value="<?echo $arParams['I_PERSON'].'|'.$arParams['I_PAY_SYSTEM'].'|'.$arParams['I_DELIVERY']?>" jqfields="Y">
	</form>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





	<script>
	// ---------------------------------------------------------------------------------------------------- iLaB Script
	$(document).ready(function(){
	// ---------------------------------------------------------------------------------------------------- Быстрый заказ
		$('form[name="<?=$arResult['I_SECTION']['CODE']?>"]').ajaxForm({
			data: { FPRO_KEY: '45gsiLab+1qUicK' },
			beforeSubmit: function()
			{
				var form			= $('form[name="<?=$arResult['I_SECTION']['CODE']?>"]');
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

					// Если пустое/обязательное поле покрасить в красный
					if( !val[1] && form.find('[name="'+val[0]+'"]').attr('jq_required') == 'Y' )
					{
						var required = true;// Заполните обязательные поля
						form.find('[name="'+val[0]+'"]').addClass('fi_empty');
					}

					if( /email/i.test(val[0]) )// Если email то в переменую email (для удобства)
						var email	= val;
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
					form.find('.jq_buttom_loader').delay(500).queue(function(){		$(this).removeClass('i_buttom_loader').dequeue();	});;
					return false;// Стоп отправки
				}
			},
			complete: function(xhr)
			{
				var form			= $('form[name="<?=$arResult['I_SECTION']['CODE']?>"]');

				form.find('input[type="submit"], .jq_order_spec_link, .jq_loader').hide();
				form.find('.jq_buttom_loader').removeClass('i_buttom_loader');
				form.find('.jq_again').fadeIn();
				form.find('.jq_order_spec').slideDown();
			}
		});
	});
	// ---------------------------------------------------------------------------------------------------- iLaB Script
	</script>


<?$frame->beginStub()?>
	<div class="i_get_loader"></div>
<?$frame->end()?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arParams)?></pre>
<?endif*/?>
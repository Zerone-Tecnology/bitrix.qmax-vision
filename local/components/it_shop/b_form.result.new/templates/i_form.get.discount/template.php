<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame('jq_get_disc', false)->begin();
$frame->setAnimation(true);
// ---------------------------------------------------------------------------------------------------- iLaB PowereD?>

<div class="i_get_disc">

<b class="ifont125"><font color="black"><?=$arResult['FORM_TITLE']?></font></b>
<?if( $arResult['FORM_DESCRIPTION'] ):?>
	<br><br>
	<span><?=$arResult['FORM_DESCRIPTION']?></span>
<?endif?>

<?if ($arResult['isFormNote'] != 'Y'):?>
	<form enctype="multipart/form-data" method="POST" action="/local/templates/ilab_it_shop/ilab/ajax/form.php" name="<?=$arResult['WEB_FORM_NAME']?>">

<?/*
		<ul class="gd_error">
			<?if( $arResult['isFormErrors'] == 'Y' )
				echo '<li>'.$arResult['FORM_ERRORS'].'</li>'?>
		</ul>
*/?>

		<table class="gd_form">
			<?foreach ($arResult['QUESTIONS'] as $k=>$e):
				if( $e['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden' ):
					if( $k == 'code_hidden' && $arParams['I_CUPON_SINGLE']=='Y' )
						echo '<input type="hidden" value="'.$arParams['I_CUPON_SI_CODE'].'" name="form_'.$e['STRUCTURE'][0]['FIELD_TYPE'].'_'.$e['STRUCTURE'][0]['ID'].'">';
					else
						echo $e['HTML_CODE'];
				else:?>
				<tr>
<?/*
					<td width="100px">
						<?//if( is_array($arResult['FORM_ERRORS']) && array_key_exists($k, $arResult['FORM_ERRORS']) ):
//							<span class="error-fld" title="<?=$arResult['FORM_ERRORS'][$k]?>"></span>
//						endif?>
						<b><?=$e['CAPTION']?>:<?if( $e['REQUIRED'] == 'Y' )echo '<font color="red">*</font>'?></b>
						<?//if( $e['IS_INPUT_CAPTION_IMAGE'] == 'Y' )echo '<br />'.$e['IMAGE']['HTML_CODE']?>
					</td>
*/?>
					<td>
						<?//=$e['HTML_CODE'];
						if( $e['REQUIRED'] == 'Y' )
							echo substr_replace( $e['HTML_CODE'], 'jqfields="Y" jq_required="Y" ', (strpos($e['HTML_CODE'], ' ')+1), 0 );
						else
							echo substr_replace( $e['HTML_CODE'], 'jqfields="Y" ', (strpos($e['HTML_CODE'], ' ')+1), 0 )?>
					</td><?//jq_fields?>
				</tr>
				<?endif;
			endforeach?>
		<?if($arResult['isUseCaptcha'] == 'Y'):?>
				<tr>
					<td>
						<?/*<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult['CAPTCHACode'])?>" />*/?>
						<img class="jq_captcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult['CAPTCHACode'])?>" width="180" height="40" title="CAPTCHA" alt="CAPTCHA" jq_code="<?=htmlspecialcharsbx($arResult['CAPTCHACode'])?>"><img class="gd_recaptcha jq_recaptcha" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/recaptcha.gif">
						<br>
						<?=GetMessage('FORM_CAPTCHA_FIELD_TITLE')?><?=$arResult['REQUIRED_SIGN']?>
					</td>
				</tr>
				<tr>
					<td><input jq_required="Y" jqfields="Y" type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
				</tr>
		<?endif// isUseCaptcha?>
			</tbody>
			<tfoot>
				<tr>
					<td>
						<div class="jq_but_bg_loader iprel<?if( $_COOKIE['I_WEB_FORM'] && $arParams['I_SESSION']!='Y' )echo ' idnone'?>"><input class="i_but_bg" <?=(intval($arResult['F_RIGHT']) < 10 ? 'disabled=\'disabled\'' : '');?> type="submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult['arForm']['BUTTON'])) <= 0 ? GetMessage('FORM_ADD') : $arResult['arForm']['BUTTON']);?>" /></div>
						<img class="gd_loader idnone ifleft jq_loader" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/loader.gif" name="loader">
						<div class="jq_again<?if( !$_COOKIE['I_WEB_FORM'] || $arParams['I_SESSION']=='Y' )echo ' idnone'?>">
							<font color="green">
								<?if( $arParams['I_CUPON_GE']=='Y' )
									echo str_replace( '#NUMBER_DISC#', $arParams['I_CUPON_GE_NUMBER_DISC'], GetMessage('I_CUPON_SI_MESSAGE') );
								else
									echo $arParams['I_MESSAGE'];?>
							</font><?/*<br><a href="javascript:void(0)" class="i_dash jq_click_again"><?=GetMessage('I_AGAIN')?></a>*/?>
						</div>
						<?/*if ($arResult['F_RIGHT'] >= 15):?>
						&nbsp;<input type="hidden" name="web_form_apply" value="Y" /><?/*<input type="submit" name="web_form_apply" value="<?=GetMessage('FORM_APPLY')?>" />?>
						<?endif;?>
						<?&nbsp;<input type="reset" value="<?=GetMessage('FORM_RESET')?>" />*/?>
						<div class="iclear"></div>
					</td>
				</tr>
			</tfoot>
		</table>
<?/*
		<p>
		<?=$arResult['REQUIRED_SIGN']?> - <?=GetMessage('FORM_REQUIRED_FIELDS')?>
		</p>
*/?>

		<input type="hidden" name="form_id" value="<?=$arResult['arForm']['ID']?>">
	</form>
</div>
<?else:// (isFormNote)?>
	<font color="red">Веб-форма не найдена</font>
<?endif// (isFormNote)
// ---------------------------------------------------------------------------------------------------- iLaB PowereD?>













<?// Component_epilog.php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['QUESTIONS']):?>
	<script>
	$(document).ready(function(){
// ---------------------------------------------------------------------------------------------------- Написать ещё - Связаться с нами внутри
		/*$('.jq_click_again').click(
			function(){
				var form			= $('form[name="<?=$arResult['WEB_FORM_NAME']?>"]');

				$(this).parent('.jq_again').hide();
				form.find('input[type="submit"]').fadeIn();
				form.find('input[name="captcha_word"]').val('');
				form.find('.jq_recaptcha').click();
				return false;
		});*/
// ---------------------------------------------------------------------------------------------------- Relaod Captcha
		$('.jq_recaptcha').click (function(){
			i_reload_captcha( $(this).siblings('.jq_captcha'), $(this) );
		});*/
// ---------------------------------------------------------------------------------------------------- Поля
		<?foreach($arResult['arAnswers'] as $k=>$e):

			if($e[0]['FIELD_TYPE'] == 'textarea')
				$pole = 'text';
			else
				$pole = 'val';?>

			<?if( $k=='mobile_telephone' ):?>
				$('form[name="<?=$arResult['WEB_FORM_NAME']?>"] [name="form_<?echo $e[0]['FIELD_TYPE'].'_'.$e[0]['ID']?>"]').mask('+7 (999) 999-99-99', { autoclear: false });
				$('form[name="<?=$arResult['WEB_FORM_NAME']?>"] [name="form_<?echo $e[0]['FIELD_TYPE'].'_'.$e[0]['ID']?>"]').<?=$pole?>('<?=$e[0]['VALUE']?>');
				$('form[name="<?=$arResult['WEB_FORM_NAME']?>"] [name="form_<?echo $e[0]['FIELD_TYPE'].'_'.$e[0]['ID']?>"]').blur(function(){
					if ($(this).<?=$pole?>()=='') $(this).<?=$pole?>('<?=$e[0]['VALUE']?>');
				});
			<?else:?>
				$('form[name="<?=$arResult['WEB_FORM_NAME']?>"] [name="form_<?echo $e[0]['FIELD_TYPE'].'_'.$e[0]['ID']?>"]').focus(function(){
					if ($(this).<?=$pole?>()=='<?=$e[0]['VALUE']?>') $(this).<?=$pole?>('');
				});
				$('form[name="<?=$arResult['WEB_FORM_NAME']?>"] [name="form_<?echo $e[0]['FIELD_TYPE'].'_'.$e[0]['ID']?>"]').blur(function(){
					if ($(this).<?=$pole?>()=='') $(this).<?=$pole?>('<?=$e[0]['VALUE']?>');
				});
			<?endif?>

		<?endforeach?>

// ---------------------------------------------------------------------------------------------------- Веб-форма
		$('form[name="<?=$arResult['WEB_FORM_NAME']?>"]').ajaxForm({
			data: { FPRO_KEY: '45gsiLab+1S23T' },
			beforeSubmit: function()
			{
				var form			= $('form[name="<?=$arResult['WEB_FORM_NAME']?>"]');
				var captcha_user	= form.find('.jq_captcha');
				var required		= false;

				var ar_Field		= form.find('[jqfields="Y"]').fieldSerialize().split('&');// Заберём у input и textarea name=value&name=value&... кроме input[type='submit'], создадим массив

				form.find('.gd_empty').removeClass('gd_empty');
				form.find('.gd_error').empty();

				form.find('.jq_but_bg_loader').addClass('i_but_bg_loader');

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
						form.find('[name="'+val[0]+'"]').addClass('gd_empty');
					}

					if(val[0] == 'captcha_word')// Если каптча то в переменную cap (для удобства)
						var cap		= val[1];
					else if( /form_email/i.test(val[0]) )// Если email то в переменую email (для удобства)
						var email	= val;
					else// Остальные поля в массив f
						f.push( [ val[0], val[1] ] );
				}

				if( !il_email(email[1]) )// Проверка корректности емайл адреса
				{
//					form.find('.gd_error').append('<li>Введите корректный адрес эл.почты.</li>');
					form.find('[name="'+email[0]+'"]').addClass('gd_empty');
					//form.find('.jq_but_bg_loader').removeClass('i_but_bg_loader');
					form.find('.jq_but_bg_loader').delay(500).queue(function(){		$(this).removeClass('i_but_bg_loader').dequeue();	});;
					return false;// Стоп отправки
				}
//console.log(required+' | '+cap)
				if( required )
				{
//					form.find('.gd_error').append('<li>Заполните обязательные поля.</li>');
					//form.find('.jq_but_bg_loader').removeClass('i_but_bg_loader');
					form.find('.jq_but_bg_loader').delay(500).queue(function(){		$(this).removeClass('i_but_bg_loader').dequeue();	});;
					return false;// Стоп отправки
				}/*else{
					var fsuc = $.ajax({
						type: 'POST',
						url: '/local/templates/ilab_it_shop/ilab/ajax/captcha_check.php',
						data: 'captcha_user=' + cap + '&captcha_sid=' + captcha_user.attr('jq_code'),
						async: false,
						success: function(z) {
							if(z == 'false'){
								form.find('input[name="captcha_word"]').val('');
								form.find('input[name="captcha_word"]').addClass('gd_empty');
								form.find('.gd_error').append('<li>Символы с картинки введены не правильно.</li>');
								form.find('.jq_recaptcha').click();
							}else{
								form.find('.gd_error').empty();
							}
						}
					}).responseText;

					if(fsuc == 'false')
					{
						form.find('.jq_loader').delay(500).fadeOut();
						return false;// Стоп отправки
					}
				}*/
			},
			complete: function(xhr)
			{
				var form			= $('form[name="<?=$arResult['WEB_FORM_NAME']?>"]');

				form.find('.jq_but_bg_loader').hide();
				form.find('.jq_again').fadeIn();
				$.cookie('I_WEB_FORM', 'Y');// jquery.cookie.js
			}
		});
	});

	/*

// ---------------------------------------------------------------------------------------------------- Reload captcha [Этот код уже находиться в /ilab/js/function.php]
	function i_reload_captcha (cl, th) {
		th.attr('src','/local/templates/ilab_it_shop/ilab/img/recaptcha_anim.gif');

		setTimeout(function(){
			th.attr('src','/local/templates/ilab_it_shop/ilab/img/recaptcha.gif')
		}, 840);

		var il_succes = $.post(
			'/local/templates/ilab_it_shop/ilab/ajax/reload_captcha.php',
			function(z)
			{	$(cl).attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + z);
				$(cl).attr('code', z)	}
		);
		il_succes.complete(function(){});

	}
// ---------------------------------------------------------------------------------------------------- Проверка корректности емайл адреса
	function il_email(str)
	{
		var regexp = /^[^@\+]+@[^@\+]+\.[^@\+]{2,4}$/;
		return regexp.test( decodeURIComponent(str) );
	}

	*/
	</script>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


<?$frame->beginStub()?>
	<div class="i_get_loader"></div>
<?$frame->end()?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arParams);//print_r($arResult)?></pre>
<?endif*/?>
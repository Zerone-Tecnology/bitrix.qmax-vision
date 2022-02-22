<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="i_review_site" id="jq_review_site">
<?$frame = $this->createFrame('jq_review_site', false)->begin();
$frame->setAnimation(true);
// ---------------------------------------------------------------------------------------------------- iLaB

if( $USER->GetLogin() )
	$userLogin = $USER->GetLogin();
else
	$userLogin = 'Гость';?>

	<form name="reviews_site" action="/local/templates/ilab_it_shop/ilab/ajax/reviews.site_add.php" method="POST" enctype="multipart/form-data">

		<span class="i_revs_title"><?=GetMessage('RE_TITLE')?></span>

		<ul class="fi_error">
			<?if( $arResult['isFormErrors'] == 'Y' )
				echo '<li>'.$arResult['FORM_ERRORS'].'</li>'?>
		</ul>

		<div class="i_review_table">
			<div class="i_review_row">
				<div class="i_review_col">
					<b><?=GetMessage('NAME')?>:</b><font color="red">*</font>
				</div>
				<div class="i_review_col">
					<input jq_required="Y" jqfields="Y" type="text" name="name" value="<?=$userLogin?>">
				</div>
			</div>
			<div class="i_review_row">
				<div class="i_review_col">
					<b><?=GetMessage('PRODUCT')?>:</b>
				</div>
				<div class="i_review_col">
					<input jqfields="Y" type="text" name="product" value="">
				</div>
			</div>
			<div class="i_review_row">
				<div class="i_review_col">
					<b><?=GetMessage('MESSAGE')?>:</b><font color="red">*</font>
				</div>
				<div class="i_review_col">
					<textarea jq_required="Y" jqfields="Y" style="min-height: 155px; max-width: 450px; min-width: 450px" name="message"></textarea>
				</div>
			</div>
			<div class="i_review_row">
				<?$code = $APPLICATION->CaptchaGetCode()?>
				<img class="jq_captcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($code)?>" width="180" height="40" title="CAPTCHA" alt="CAPTCHA" jq_code="<?=htmlspecialcharsbx($code)?>"><img class="fi_recaptcha jq_recaptcha" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/recaptcha.gif">
				<br>
				<?=GetMessage('CHARACTERS')?><font color="red">*</font>
			</div>
			<div class="i_review_row">
				<input jq_required="Y" jqfields="Y" type="text" name="captcha_word" size="30" maxlength="50" value="" class="i_w230i" />
			</div>
			<div class="i_review_row">
				<div class="jq_buttom_loader ifleft iprel">
					<input type="submit" value="<?=GetMessage('SEND')?>">
				</div>
				<img class="fi_loader idnone ifleft jq_loader" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/loader.gif" name="loader">
				<div class="jq_again idnone">
					<font color="green"><?=GetMessage('REVIEW_SENT')?></font><br><a href="javascript:void(0)" class="i_dash jq_click_again_review"><?=GetMessage('I_AGAIN')?></a>
				</div>
			</div>
		</div>

		<input type="hidden" class="jq_product_ajax" value="" name="product_ajax">
		<input type="hidden" value="<?=$arParams['IBLOCK_ID']?>" name="review_iblock_id">
	</form>

<?
// ---------------------------------------------------------------------------------------------------- iLaB?>









<?// Component_epilog.php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB?>
	<script>
	$(document).ready(function(){
// ---------------------------------------------------------------------------------------------------- Написать ещё - Отзывы
		$('.jq_click_again_review').click(
			function(){
				var form			= $('form[name="reviews_site"]');

				$(this).parent('.jq_again').hide();
				form.find('input[type="submit"]').fadeIn();
				form.find('input[name="captcha_word"]').val('');
				form.find('.jq_recaptcha').click();
				return false;
		});
// ---------------------------------------------------------------------------------------------------- Добавить отзыв
		$('form[name="reviews_site"]').ajaxForm({
			data: { FPRO_KEY: '45gsiLab+1revSit' },
			beforeSubmit: function()
			{
				var form			= $('form[name="reviews_site"]');
				var captcha_user	= form.find('.jq_captcha');
				var required		= false;

				var ar_Field		= form.find('[jqfields="Y"]').fieldSerialize().split('&');// Заберём у input и textarea name=value&name=value&... кроме input[type='submit'], создадим массив

				form.find('.fi_empty').removeClass('fi_empty');
				form.find('.fi_error').empty();

//				form.find('.jq_loader').fadeIn();
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

					if(val[0] == 'captcha_word')// Если каптча то в переменную cap (для удобства)
						var cap		= val[1];
					else if( /form_email/i.test(val[0]) )// Если email то в переменую email (для удобства)
						var email	= val;
					else// Остальные поля в массив f
						f[val[0]] = val[1];
				}

				if( email && !il_email(email[1]) )// Проверка корректности емайл адреса
				{
					console.log('email');
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
							if(z == 'false'){
								form.find('input[name="captcha_word"]').val('');
								form.find('input[name="captcha_word"]').addClass('fi_empty');
								form.find('.fi_error').append('<li>Символы с картинки введены не правильно.</li>');
								form.find('.jq_recaptcha').click();
							}else{
								form.find('.fi_error').empty();
							}
						}
					}).responseText;

					if(fsuc == 'false')
					{
//						form.find('.jq_loader').delay(500).fadeOut();
						form.find('.jq_buttom_loader').delay(500).queue(function(){		$(this).removeClass('i_buttom_loader').dequeue();	});;
						return false;// Стоп отправки
					} else {
						if( $('.jq_re_count').length > 0 )
							$('.jq_re_count').text( +$('.jq_re_count').text()+1 );
						else
							$('.jq_reviews_count').append('<span class="i_ai_count jq_re_count">1</span>');
						$('.jq_reviews_block').append('<div class="i_reviews_ele"><div class="i_re_title"><b>'+decodeURIComponent(f['name']).replace(/\+/g, ' ')+'</b>&nbsp;&nbsp;&nbsp;&nbsp;<i><font color="green">Только что</font></i></div><div class="i_re_text">'+decodeURIComponent(f['message']).replace(/\+/g, ' ')+'</div></div>');
					}
				}
			},
			complete: function(xhr)
			{
				var form			= $('form[name="reviews_site"]');

				form.find('input[type="submit"]').hide();
//				form.find('.jq_loader').hide();
				form.find('.jq_buttom_loader').removeClass('i_buttom_loader');
				form.find('.jq_again').fadeIn();
			}
		});
// ---------------------------------------------------------------------------------------------------- Удалить отзыв
/*
		$('.jq_reviews_delete').click(function(){
			var id_ib	= $(this).attr('jq_id').split('|');

			$.post(
				'<?=SITE_TEMPLATE_PATH?>/ilab/ajax/reviews_delete.php',
				{ iblock_id: id_ib[0], id: id_ib[1] },
				function(z)
				{
					if( z=='true' )
					{
						$('.jq_re_count').text( +$('.jq_re_count').text()-1 );
						$('.jq_reviews_ele_'+id_ib[1]).slideUp('slow', function(){
							$(this).remove();
						});
					} else
						console.log('Error');
				}
			);
		});
*/
	});
	</script>
<?
// ---------------------------------------------------------------------------------------------------- iLaB?>

<?$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?$frame->end()?>

</div>
<?/*
<?if($USER->isAdmin()):?>
	<pre><?print_r($arParams)?></pre>
	<pre><?print_r($arResult)?></pre>
<?endif?>
*/?>
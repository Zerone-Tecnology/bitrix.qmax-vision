<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>

	<form name="reviews" action="/local/templates/ilab_it_shop/ilab/ajax/reviews.php" method="POST" enctype="multipart/form-data">

		<ul class="fi_error">
			<?if( $arResult['isFormErrors'] == 'Y' )
				echo '<li>'.$arResult['FORM_ERRORS'].'</li>'?>
		</ul>

		<table>
			<tr>
				<td>
					Ваше имя:
					<br>
					<input jq_required="Y" jqfields="Y" type="text" name="name">
				</td>
			</tr>
			<tr>
				<td>
					Текст сообщения:
					<br>
					<textarea jq_required="Y" jqfields="Y" style="min-height: 155px; max-width: 450px; min-width: 450px" name="message"></textarea>
				</td>
			</tr>
			<tr>
				<td>

					<img class="jq_captcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($APPLICATION->CaptchaGetCode())?>" width="180" height="40" title="CAPTCHA" alt="CAPTCHA" jq_code="<?=htmlspecialcharsbx($APPLICATION->CaptchaGetCode())?>"><img class="fi_recaptcha jq_recaptcha" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/recaptcha.gif">
					<br>
					Введите символ с картинки:
				</td>
			</tr>
			<tr>
				<td>
					<input jq_required="Y" jqfields="Y" type="text" name="captcha_word" size="30" maxlength="50" value="" class="i_w180i" />
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Отправить" class="ifleft">
					<img class="fi_loader idnone ifleft jq_loader" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/loader.gif" name="loader">
					<div class="jq_again idnone">
						<font color="green">Ваш отзыв отправлен!</font><br><a href="javascript:void(0)" class="i_dash jq_click_again"><?=GetMessage('I_AGAIN')?></a>
					</div>
				</td>
			</tr>
		</table>
	</form>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*
<?if($USER->isAdmin()):?>
	<pre><?print_r($arParams)?></pre>
	<pre><?print_r($arResult)?></pre>
<?endif?>
*/?>
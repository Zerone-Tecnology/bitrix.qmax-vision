<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame('jqm_feedback_'.$arResult['WEB_FORM_NAME'], false)->begin();
$frame->setAnimation(true);
// ---------------------------------------------------------------------------------------------------- iLaB PowereD?>

<?/*<h1><?=$arResult['FORM_TITLE']?></h1>*/?>

<?//=$arResult['FORM_NOTE']?>

<?if ($arResult['isFormNote'] != 'Y'):?>
	<form class="j_form_result_new" enctype="multipart/form-data" method="POST" action="/local/templates/ilab_it_shop/ilab/ajax/form.php" name="<?=$arResult['WEB_FORM_NAME']?>">

		<ul class="fi_error">
			<?if( $arResult['isFormErrors'] == 'Y' )
				echo '<li>'.$arResult['FORM_ERRORS'].'</li>'?>
		</ul>

		<table class="fi_form">
			<?foreach ($arResult['QUESTIONS'] as $k=>$e):
				if( $e['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden' ):
					echo $e['HTML_CODE'];
				else:?>
				<tr>
					<td width="100px">
						<?/*if( is_array($arResult['FORM_ERRORS']) && array_key_exists($k, $arResult['FORM_ERRORS']) ):?>
							<span class="error-fld" title="<?=$arResult['FORM_ERRORS'][$k]?>"></span>
						<?endif*/?>
						<b><?=$e['CAPTION']?>:<?if( $e['REQUIRED'] == 'Y' )echo '<font color="red">*</font>'?></b>
						<?/*if( $e['IS_INPUT_CAPTION_IMAGE'] == 'Y' )echo '<br />'.$e['IMAGE']['HTML_CODE']*/?>
					</td>
					<td>
						<?//=$e['HTML_CODE'];'
						if( $e['REQUIRED'] == 'Y' )
							echo substr_replace( $e['HTML_CODE'], 'placeholder="'.$e['CAPTION'].'" jqfields="Y" jq_required="Y" ', (strpos($e['HTML_CODE'], ' ')+1), 0 );
						else
							echo substr_replace( $e['HTML_CODE'], 'placeholder="'.$e['CAPTION'].'" jqfields="Y" ', (strpos($e['HTML_CODE'], ' ')+1), 0 )?>
					</td><?//jq_fields?>
				</tr>
				<?endif;
			endforeach?>
		<?if($arResult['isUseCaptcha'] == 'Y'):?>
				<tr>
					<td>&nbsp;</td>
					<td>
						<?/*<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult['CAPTCHACode'])?>" />*/?>
						<img class="jq_captcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($arResult['CAPTCHACode'])?>" width="180" height="40" title="CAPTCHA" alt="CAPTCHA" jq_code="<?=htmlspecialcharsbx($arResult['CAPTCHACode'])?>"><img class="fi_recaptcha jq_recaptcha" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/recaptcha.gif">
						<br>
						<?=GetMessage('I_FORM_CAPTCHA_FIELD_TITLE')?><?=$arResult['REQUIRED_SIGN']?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input placeholder="<?=GetMessage('I_FORM_CAPTCHA_FIELD_TITLE')?>" jq_required="Y" jqfields="Y" type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
				</tr>
		<?endif// isUseCaptcha?>
			</tbody>
			<tfoot>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div class="jq_buttom_loader ifleft iprel">
							<input class="j_form_submit_result_new" <?=(intval($arResult['F_RIGHT']) < 10 ? 'disabled=\'disabled\'' : '');?> type="submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult['arForm']['BUTTON'])) <= 0 ? GetMessage('FORM_ADD') : $arResult['arForm']['BUTTON']);?>" />
						</div>
						<img class="fi_loader idnone ifleft jq_loader" src="<?=SITE_TEMPLATE_PATH?>/ilab/img/loader.gif" name="loader">
						<div class="jq_again idnone">
							<font color="green"><?=GetMessage('I_SUCCESS')?></font><br><a href="javascript:void(0)" class="i_dash jq_click_again"><?=GetMessage('I_AGAIN')?></a>
						</div>
						<?/*if ($arResult['F_RIGHT'] >= 15):?>
						&nbsp;<input type="hidden" name="web_form_apply" value="Y" /><?/*<input type="submit" name="web_form_apply" value="<?=GetMessage('FORM_APPLY')?>" />?>
						<?endif;?>
						<?&nbsp;<input type="reset" value="<?=GetMessage('FORM_RESET')?>" />*/?>
						<div class="iclear"></div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?=$arResult['REQUIRED_SIGN']?><?=GetMessage('I_FORM_REQUIRED_FIELDS')?></td>
				</tr>
			</tfoot>
		</table>

		<input type="hidden" name="form_id" value="<?=$arResult['arForm']['ID']?>">
	</form>
<?else:// (isFormNote)?>
	<font color="red">Веб-форма не найдена</font>
<?endif// (isFormNote)
// ---------------------------------------------------------------------------------------------------- iLaB PowereD?>

<?$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?$frame->end()?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
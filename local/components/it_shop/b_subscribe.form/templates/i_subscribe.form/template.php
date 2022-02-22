<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<?/*<h2>
	<a href="personal/subscribe/"><?=GetMessage('SUBSCR_FORM_TITLE')?></a>
</h2>*/?>

<div class="i_subscribe_form j_subscribe_form subscribe-form"  id="subscribe-form">
<?
$frame = $this->createFrame("subscribe-form", false)->begin();
?>

	<form action="<?=$arResult["FORM_ACTION"]?>">

		<?/*<div class="i_sf_rubric">
			<div class="i_sf_rubric_title">
				<b><?=GetMessage('SUBSCR_FORM_RUBRIC')?>:</b>
			</div>
			<div class="i_sf_rubric_label">
				foreach($arResult["I_RUBRICS"] as $itemID => $itemValue):?>
					<label for="sf_RUB_ID_<?=$itemValue["ID"]?>">
						<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /> <?=$itemValue["NAME"]?>
					</label>
				<?endforeach;
			</div>
		</div>*/?>

		<div class="i_sf_input j_sf_input">
<?if( !$_COOKIE['I_HINT_SUBSCRIBE'] ):?>
			<div class="i_hint_subscribe j_hint_subscribe idn">
				<div class="i_word_hsubscribe j_word_hsubscribe">
					<span><?=GetMessage('SUBSCR_FORM_HINT')?></span>
				</div>
				<div class="i_close_hsubscribe j_close_hsubscribe">×</div>
			</div><div class="i_bg_hsubscribe j_bg_hsubscribe"></div>
<?endif?>
			<input type="text" name="sf_EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" placeholder="<?=GetMessage("subscr_form_email_title")?>" />
			<input type="submit" name="OK" value="<?=GetMessage("CT_BSE_BTN_ADD_SUBSCRIPTION")?>" />
		</div>

		<div class="i_sf_info">
            <p>
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_subscribe_info.php',Array(),Array('MODE'=>'html', 'NAME'=>'Информация о рассылке', 'SHOW_BORDER'=>true));// Subscribe info?>
            </p>
		</div>

	</form>
<?
$frame->beginStub();
?>
	<form action="<?=$arResult["FORM_ACTION"]?>">

		<?foreach($arResult["I_RUBRICS"] as $itemID => $itemValue):?>
			<label for="sf_RUB_ID_<?=$itemValue["ID"]?>">
				<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" /> <?=$itemValue["NAME"]?>
			</label><br />
		<?endforeach;?>

		<table border="0" cellspacing="0" cellpadding="2" align="center">
			<tr>
				<td><input type="text" name="sf_EMAIL" size="20" value="" title="<?=GetMessage("subscr_form_email_title")?>" /></td>
			</tr>
			<tr>
				<td align="right"><input type="submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" /></td>
			</tr>
		</table>
	</form>
<?
$frame->end();
?>
</div>






<?/*if($USER->isAdmin()):?>
	<pre>
		<?print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>
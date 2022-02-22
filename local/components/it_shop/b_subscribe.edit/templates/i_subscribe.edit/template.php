<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));

foreach($arResult["ERROR"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));

if($arResult["ALLOW_ANONYMOUS"]=="N" && !$USER->IsAuthorized()):
	echo ShowMessage(array("MESSAGE"=>GetMessage("CT_BSE_AUTH_ERR"), "TYPE"=>"ERROR"));
else:
?>
	<div class="i_subscription_edit subscription">
		<form class="i_se_form" action="<?=$arResult["FORM_ACTION"]?>" method="post">

			<?echo bitrix_sessid_post();?>
			<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
			<input type="hidden" name="ID" value="<?=$arResult["SUBSCRIPTION"]["ID"];?>" />
			<input type="hidden" name="RUB_ID[]" value="0" />

			<?/*<div class="subscription-title">
				<b class="r2"></b><b class="r1"></b><b class="r0"></b>
				<div class="subscription-title-inner"><?=GetMessage("CT_BSE_SUBSCRIPTION_FORM_TITLE")?></div>
			</div>*/?>

			<div class="i_se_field i_se_o">
				<div class="i_se_field_name">
					<?=GetMessage("CT_BSE_RUBRIC_LABEL")?>
				</div>
				<div class="i_se_field_form">
					<div class="i_se_rubric">
						<?foreach($arResult["I_RUBRICS"] as $itemID => $itemValue):?>
							<div class="i_se_r_item">
								<input type="checkbox" id="RUBRIC_<?=$itemID?>" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /><label for="RUBRIC_<?=$itemID?>"><b><?=$itemValue["NAME"]?></b><?/*<span><?=$itemValue["DESCRIPTION"]?></span></label>*/?>
							</div>
						<?endforeach?>
					</div>
					<?if($arResult["ID"]==0):?>
						<div class="i_se_notes"><?=GetMessage('CT_BSE_NEW_NOTE')?></div>
					<?else:?>
						<div class="i_se_notes"><?=GetMessage('CT_BSE_EXIST_NOTE')?></div>
					<?endif?>
					<div class="i_se_format">
						<b><?=GetMessage("CT_BSE_FORMAT_LABEL")?></b>
						<label for="MAIL_TYPE_TEXT">
							<input type="radio" name="FORMAT" id="MAIL_TYPE_TEXT" value="text" <?if($arResult["SUBSCRIPTION"]["FORMAT"] != "html") echo "checked"?> />
                            <label for=""><?=GetMessage("CT_BSE_FORMAT_TEXT")?></label>
						</label>
						<label for="MAIL_TYPE_HTML">
							<input type="radio" name="FORMAT" id="MAIL_TYPE_HTML" value="html" <?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo "checked"?> />
                            <label for=""><?=GetMessage("CT_BSE_FORMAT_HTML")?></label>
						</label>
					</div>
				</div>
			</div>

			<div class="i_se_field i_se_f">
				<div class="i_se_field_name">
					<?=GetMessage("CT_BSE_EMAIL_LABEL")?>
				</div>
				<div class="i_se_field_form">
					<input type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""? $arResult["SUBSCRIPTION"]["EMAIL"]: $arResult["REQUEST"]["EMAIL"];?>" class="subscription-email"  placeholder="<?=GetMessage("CT_BSE_EMAIL")?>" size="10" />
					<input type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("CT_BSE_BTN_EDIT_SUBSCRIPTION"): GetMessage("CT_BSE_BTN_ADD_SUBSCRIPTION"))?>"  placeholder="<?=GetMessage("CT_BSE_EMAIL")?>" />
				</div>
			</div>

			<?if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
				<div class="i_se_confirmed">
					<div>
						<?=GetMessage("CT_BSE_CONF_NOTE")?>
					</div>
					<div class="i_se_field i_se_f">
						<?//<div class="i_se_field_name"></div>?>
						<div class="i_se_field_form">
							<input style="max-width: 540px" name="CONFIRM_CODE" type="text" class="subscription-textbox" value="<?//=GetMessage("CT_BSE_CONFIRMATION")?>" placeholder="<?=GetMessage("CT_BSE_BTN_CONF")?>" size="10"<?/* onblur="if (this.value=='')this.value='<?=GetMessage("CT_BSE_CONFIRMATION")?>'" onclick="if (this.value=='<?=GetMessage("CT_BSE_CONFIRMATION")?>')this.value=''"*/?> /> <input type="submit" name="confirm" value="<?=GetMessage("CT_BSE_BTN_CONF")?>" />
						</div>
					</div>
				</div>
			<?endif?>

		</form>

		<?if(!CSubscription::IsAuthorized($arResult["ID"])):?>
			<form class="i_se_utility" action="<?=$arResult["FORM_ACTION"]?>" method="post">
				<?=bitrix_sessid_post();?>
				<input type="hidden" name="action" value="sendcode" />

				<div class="i_se_info">
					<?=GetMessage('CT_BSE_SEND_NOTE')?>
				</div>

				<div class="i_se_field i_se_f">
					<div class="i_se_field_name">
						<?=GetMessage("CT_BSE_EMAIL_LABEL")?>
					</div>
					<div class="i_se_field_form">
						<input name="sf_EMAIL" type="text" class="subscription-textbox" value="<?//=GetMessage("CT_BSE_EMAIL")?>" placeholder="<?=GetMessage("CT_BSE_EMAIL")?>" size="10"<?/* onblur="if (this.value=='')this.value='<?=GetMessage("CT_BSE_EMAIL")?>'" onclick="if (this.value=='<?=GetMessage("CT_BSE_EMAIL")?>')this.value=''"*/?> />
						<input type="submit" value="<?=GetMessage("CT_BSE_BTN_SEND")?>" />
					</div>
				</div>
			</form>
		<?endif?>

	</div>
<?endif?>
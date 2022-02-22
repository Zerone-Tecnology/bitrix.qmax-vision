<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>
	<?
	foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
		echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));
	foreach($arResult["ERROR"] as $itemID=>$itemValue)
		echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));

	if($arResult["ALLOW_ANONYMOUS"]=="N" && !$USER->IsAuthorized()):
		echo ShowMessage(array("MESSAGE"=>GetMessage("CT_BSE_AUTH_ERR"), "TYPE"=>"ERROR"));
	else:
		?>
		<div class="subscription">
			<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
				<?echo bitrix_sessid_post();?>
				<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
				<input type="hidden" name="ID" value="<?=$arResult["SUBSCRIPTION"]["ID"]?>" />
				<input type="hidden" name="RUB_ID[]" value="0" />

				<div class="subscription-form">

					<div class="subscription-layout">
						<div class="subscription-layout-row">
							<div class="subscription-layout-col field-name"><?=GetMessage('CT_BSE_RUBRIC_LABEL')?></div>
							<div class="subscription-layout-col field-form">
								<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
									<div class="subscription-rubric ifleft">
										<input type="checkbox" id="RUBRIC_<?echo $itemID?>" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /><label for="RUBRIC_<?echo $itemID?>"><b><?echo $itemValue["NAME"]?></b><span><?echo $itemValue["DESCRIPTION"]?></span></label>
									</div>
								<?endforeach?>


								<?if($arResult["ID"]==0):?>
									<div class="subscription-notes"><?=GetMessage("CT_BSE_NEW_NOTE")?></div>
								<?else:?>
									<div class="subscription-notes"><?=GetMessage("CT_BSE_EXIST_NOTE")?></div>
								<?endif?>

								<div class="subscription-format">
									<span><?echo GetMessage("CT_BSE_FORMAT_LABEL")?></span>&nbsp;<input type="radio" name="FORMAT" id="MAIL_TYPE_TEXT" value="text" <?if($arResult["SUBSCRIPTION"]["FORMAT"] != "html") echo "checked"?> /><label for="MAIL_TYPE_TEXT"><?echo GetMessage("CT_BSE_FORMAT_TEXT")?></label>&nbsp;<input type="radio" name="FORMAT" id="MAIL_TYPE_HTML" value="html" <?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo "checked"?> /><label for="MAIL_TYPE_HTML"><?echo GetMessage("CT_BSE_FORMAT_HTML")?></label>
								</div>
							</div>
						</div>
						<div class="subscription-layout-row">
							<div class="subscription-layout-col field-name" style="padding-top: 8px"><?=GetMessage('CT_BSE_EMAIL_LABEL')?></div>
							<div class="subscription-layout-col field-form">
								<input style="width: 275px" type="text" name="EMAIL" value="<?echo $arResult["SUBSCRIPTION"]["EMAIL"]!=""? $arResult["SUBSCRIPTION"]["EMAIL"]: $arResult["REQUEST"]["EMAIL"];?>" class="subscription-email" />
								<div class="subscription-buttons"><input type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("CT_BSE_BTN_EDIT_SUBSCRIPTION"): GetMessage("CT_BSE_BTN_ADD_SUBSCRIPTION"))?>" /></div>
							</div>
						</div>
					</div>
				</div>

				<?if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
					<div class="subscription-utility">
						<p><?=GetMessage("CT_BSE_CONF_NOTE")?></p>
						<br>
						<input name="CONFIRM_CODE" type="text" class="subscription-textbox" value="<?echo GetMessage("CT_BSE_CONFIRMATION")?>" onblur="if (this.value=='')this.value='<?echo GetMessage("CT_BSE_CONFIRMATION")?>'" onclick="if (this.value=='<?echo GetMessage("CT_BSE_CONFIRMATION")?>')this.value=''" />
						<div class="subscription-buttons">
							<input type="submit" name="confirm" value="<?echo GetMessage("CT_BSE_BTN_CONF")?>" />
						</div>
					</div>
				<?endif?>

			</form>

			<?if(!CSubscription::IsAuthorized($arResult["ID"])):?>
				<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
					<?echo bitrix_sessid_post();?>
					<input type="hidden" name="action" value="sendcode" />

					<div class="subscription-utility">
						<p><?=GetMessage("CT_BSE_SEND_NOTE")?></p>
						<br>
						<input style="width: 350px" name="sf_EMAIL" type="text" class="subscription-textbox" value="<?echo GetMessage("CT_BSE_EMAIL")?>" onblur="if (this.value=='')this.value='<?echo GetMessage("CT_BSE_EMAIL")?>'" onclick="if (this.value=='<?echo GetMessage("CT_BSE_EMAIL")?>')this.value=''" />
						<div class="subscription-buttons">
							<input type="submit" value="<?=GetMessage("CT_BSE_BTN_SEND")?>" />
						</div>
					</div>
				</form>
			<?endif?>

		</div>
	<?endif;?>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
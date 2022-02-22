<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>

	<?if(strlen($arResult["ERROR_MESSAGE"])>0)
		ShowError($arResult["ERROR_MESSAGE"]);?>
	<?if(strlen($arResult["NAV_STRING"]) > 0):?>
		<p><?=$arResult["NAV_STRING"]?></p>
	<?endif?>
	<div class="i_profile_list">
		<div class="sale_personal_profile_list data-table">
			<div class="sale_personal_profile_list_thead">
				<div class="sale_personal_profile_list_row">
					<div class="sale_personal_profile_list_col">
						<b><?=GetMessage("P_ID")?></b>
						<?/*<br /><?=SortingEx("ID")?>*/?>
					</div>
					<div class="sale_personal_profile_list_col">
						<b><?=GetMessage("P_DATE_UPDATE")?></b>
						<?/*<br /><?=SortingEx("DATE_UPDATE")?>*/?>
					</div>
					<div class="sale_personal_profile_list_col">
						<b><?=GetMessage("P_NAME")?></b>
						<?/*<br /><?=SortingEx("NAME")?>*/?>
					</div>
					<div class="sale_personal_profile_list_col">
						<b><?=GetMessage("P_PERSON_TYPE")?></b>
						<?/*<br /><?=SortingEx("PERSON_TYPE_ID")?>*/?>
					</div>
					<div class="sale_personal_profile_list_col">
						<b><?=GetMessage("SALE_ACTION")?></b>
					</div>
				</div>
			</div>
			<div class="sale_personal_profile_list_tbody">
				<?foreach($arResult["PROFILES"] as $val):?>
					<div class="sale_personal_profile_list_row">
						<div class="sale_personal_profile_list_col">№<?=$val["ID"]?></div>
						<div class="sale_personal_profile_list_col"><span><?=GetMessage('I_DATE_UPDATE');?></span><?=$val["DATE_UPDATE"]?></div>
						<div class="sale_personal_profile_list_col"><?=$val["NAME"]?></div>
						<div class="sale_personal_profile_list_col"><span><?=GetMessage('I_PERSON_TYPE');?></span><?=$val["PERSON_TYPE"]["NAME"]?></div>
						<div class="sale_personal_profile_list_col">
							<a class="i_pro_edit" title="<?= GetMessage("SALE_DETAIL_DESCR") ?>" href="<?=$val["URL_TO_DETAIL"]?>"><?//= GetMessage("SALE_DETAIL") ?></a>
							<a class="i_pro_delete" title="<?= GetMessage("SALE_DELETE_DESCR") ?>" href="javascript:if(confirm('<?= GetMessage("STPPL_DELETE_CONFIRM") ?>')) window.location='<?=$val["URL_TO_DETELE"]?>'"><?//= GetMessage("SALE_DELETE")?></a>
						</div>
					</div>
				<?endforeach?>
			</div>
		</div>
	</div>
	<?if(strlen($arResult["NAV_STRING"]) > 0):?>
		<p><?=$arResult["NAV_STRING"]?></p>
	<?endif?>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
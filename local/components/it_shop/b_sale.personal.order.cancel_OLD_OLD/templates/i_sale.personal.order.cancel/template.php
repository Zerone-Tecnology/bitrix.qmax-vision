<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB?>

	<a class="i_but_ou" href="<?=$arResult["URL_TO_LIST"]?>"><?=GetMessage("SALE_RECORDS_LIST")?></a>
	<div class="bx_my_order_cancel">
		<?if(strlen($arResult["ERROR_MESSAGE"])<=0):?>
			<form method="post" action="<?=POST_FORM_ACTION_URI?>">

				<input type="hidden" name="CANCEL" value="Y">
				<?=bitrix_sessid_post()?>
				<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
				<?=GetMessage("SALE_CANCEL_ORDER1") ?>
				<div class="bx_my_order_cancel_back">
					<a class="i_but_ou" href="<?=$arResult["URL_TO_DETAIL"]?>"><?=GetMessage("SALE_CANCEL_ORDER2")?> №<?=$arResult["ACCOUNT_NUMBER"]?></a> ?
				</div>
				<div class="bx_my_order_cancel_mess1"><?= GetMessage("SALE_CANCEL_ORDER3") ?></div>
				<div class="bx_my_order_cancel_mess2">
					<p class="bx_my_order_cancel_mess2_quest"><?= GetMessage("SALE_CANCEL_ORDER4") ?>:</p>
					<textarea name="REASON_CANCELED"></textarea>
				</div>
				<div class="bx_my_order_cancel_but">
					<input class="i_but_ac" type="submit" name="action" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
				</div>
			</form>
		<?else:?>
			<?=ShowError($arResult["ERROR_MESSAGE"])?>
		<?endif?>

	</div>
<?
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
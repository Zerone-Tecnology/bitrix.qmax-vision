<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/functions.php");?>

<div class="i_bs_title">
	<span class="i_bs_title_icon"></span><h2><?$APPLICATION->ShowTitle()?></h2>
</div>

<?if (strlen($arResult["ERROR_MESSAGE"]) <= 0):?>
	<div id="warning_message">
		<?if(is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"])):?>
			<div class="i_b_warning_message">
				<?foreach ($arResult["WARNING_MESSAGE"] as $v)
					echo ShowError($v);?>
			</div>
		<?endif?>
	</div>
	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? "style=\"display:none\"" : "";

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? "style=\"display:none\"" : "";

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? "style=\"display:none\"" : "";

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? "style=\"display:none\"" : "";

	?>
	<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
		<div id="basket_form_container">
			<div class="bx_ordercart">
                <div class="bx_sort_container">
					<span><?=GetMessage("SALE_ITEMS")?></span>
<!--                    to-->
                    <div class="i_bascet_spisok">
                        <a href="javascript:void(0)" id="basket_toolbar_button" class="current" onclick="showBasketItemsList()"><?=GetMessage("SALE_BASKET_ITEMS")?><div id="normal_count" class="flat" style="display:none">&nbsp;(<?=$normalCount?>)</div></a>
                        <a href="javascript:void(0)" id="basket_toolbar_button_delayed" onclick="showBasketItemsList(2)" <?=$delayHidden?>><?=GetMessage("SALE_BASKET_ITEMS_DELAYED")?><span id="delay_count" class="flat">&nbsp;(<?=$delayCount?>)</span></a>
                        <a href="javascript:void(0)" id="basket_toolbar_button_subscribed" onclick="showBasketItemsList(3)" <?=$subscribeHidden?>><?=GetMessage("SALE_BASKET_ITEMS_SUBSCRIBED")?><span id="subscribe_count" class="flat">&nbsp;(<?=$subscribeCount?>)</span></a>
                        <a href="javascript:void(0)" id="basket_toolbar_button_not_available" onclick="showBasketItemsList(4)" <?=$naHidden?>><?=GetMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE")?><span id="not_available_count" class="flat">&nbsp;(<?=$naCount?>)</span></a>
				    </div>
                </div>
				<?
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
				?>
			</div>
		</div>
		<input type="hidden" name="BasketOrder" value="BasketOrder" />
		<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
	</form>
<?else:?>
	<div class="i_empty_basket">
		<?//ShowError($arResult["ERROR_MESSAGE"])?>
		<?=GetMessage('EMPTY_BASKET')?>&nbsp;<a href="<?=SITE_DIR?>" class="i_but_ac"><?=GetMessage('START_BUY')?></a>
	</div>
<?endif?>
<script>
	// iLaB
	<?if( $_GET['wlist']==true ):?>
	showBasketItemsList(2);
	<?endif?>
	// iLaB
</script>
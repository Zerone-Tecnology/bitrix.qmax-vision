<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?><?$APPLICATION->IncludeComponent(
	"it_shop:b_sale.basket.basket", 
	"i_basket", 
	array(
		"ACTION_VARIABLE" => "action",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "PRICE",
			5 => "QUANTITY",
			6 => "SUM",
		),
		"COMPONENT_TEMPLATE" => "i_basket",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"HIDE_COUPON" => "N",
		"I_MIN_PUTCHASE_AMOUNT" => "",
		"OFFERS_PROPS" => array(
			0 => "COLOR_REF",
			1 => "MEMORY",
			2 => "BODY_TYPE",
		),
		"PATH_TO_ORDER" => "/personal/order.php",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"TERMS_OF_USE" => "N",
		"USE_PREPAYMENT" => "N",
		"STEAKER_STATUS" => "Y",
		"COMPOSITE_FRAME_MODE" => "N"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
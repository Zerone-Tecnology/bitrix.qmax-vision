<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?><?$APPLICATION->IncludeComponent(
	"it_shop:b_sale.personal.order", 
	"i_sale.personal.order", 
	array(
		"SEF_MODE" => "N",
		"ORDERS_PER_PAGE" => "20",
		"PATH_TO_PAYMENT" => "/personal/payment.php",
		"PATH_TO_BASKET" => "/personal/basket.php",
		"SET_TITLE" => "Y",
		"SAVE_IN_SESSION" => "Y",
		"NAV_TEMPLATE" => "i_visual",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => "Y",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CUSTOM_SELECT_PROPS" => array(
			0 => "PREVIEW_PICTURE",
			1 => "",
		),
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"SEF_FOLDER" => "/personal/orders/",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_F" => "green",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"COMPONENT_TEMPLATE" => "i_sale.personal.order",
		"PROP_3" => array(
		),
		"PROP_4" => array(
		),
		"STATUS_COLOR_P" => "yellow",
		"STATUS_COLOR_D" => "gray",
		"DETAIL_HIDE_USER_INFO" => array(
			0 => "0",
		),
		"PATH_TO_CATALOG" => "/catalog/",
		"RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "D",
			1 => "F",
		),
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ALLOW_INNER" => "N",
		"ONLY_INNER_FULL" => "N",
		"STATUS_COLOR_Z" => "gray",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
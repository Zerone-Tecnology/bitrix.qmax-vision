<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профили");
?><?$APPLICATION->IncludeComponent(
	"it_shop:b_sale.personal.profile",
	"i_sale.personal.profile",
	array(
		"COMPONENT_TEMPLATE" => "i_sale.personal.profile",
		"PER_PAGE" => "20",
		"SEF_MODE" => "N",
		"SET_TITLE" => "Y",
		"USE_AJAX_LOCATIONS" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
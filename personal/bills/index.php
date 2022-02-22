<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мои счета");
?><?$APPLICATION->IncludeComponent(
	"it_shop:b_sale.personal.account", 
	"ilab", 
	array(
		"SET_TITLE" => "Y",
		"COMPONENT_TEMPLATE" => "ilab"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
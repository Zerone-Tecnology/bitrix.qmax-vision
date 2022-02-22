<?$APPLICATION->IncludeComponent(
	"it_shop:b_sale.basket.basket.small",
	"i_hbasket", 
	array(
		"PATH_TO_BASKET" => "/personal/basket.php",
		"PATH_TO_ORDER" => "/personal/order.php",
		"SHOW_DELAY" => "Y",
		"SHOW_NOTAVAIL" => "Y",
		"SHOW_SUBSCRIBE" => "Y",
		"COMPONENT_TEMPLATE" => "i_hbasket",
		"I_CURRENCY" => "KZT",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "KZT"
	),
	false
);?>
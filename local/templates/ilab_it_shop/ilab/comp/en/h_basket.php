<?$APPLICATION->IncludeComponent(
	"it_shop:b_sale.basket.basket.small", 
	"i_hbasket", 
	array(
		"PATH_TO_BASKET" => "/en/personal/basket.php",
		"PATH_TO_ORDER" => "/en/personal/order.php",
		"SHOW_DELAY" => "Y",
		"SHOW_NOTAVAIL" => "Y",
		"SHOW_SUBSCRIBE" => "Y",
		"COMPONENT_TEMPLATE" => "i_hbasket",
		"I_CURRENCY" => "USD",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "USD"
	),
	false
);?>
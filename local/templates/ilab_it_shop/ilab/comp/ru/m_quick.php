<?$APPLICATION->IncludeComponent(
	"it_shop:i_quick_v1.0", 
	".default", 
	array(
		"IBLOCK_TYPE" => "form",
		"IBLOCK_ID" => "12",
		"FORM_ID" => "861",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"COMPONENT_TEMPLATE" => ".default",
		"I_PERSON" => "1",
		"I_PAY_SYSTEM" => "1",
		"I_DELIVERY" => "1",
		"Q_ORDER" => $arParams['Q_ORDER']
	),
	false
);?>
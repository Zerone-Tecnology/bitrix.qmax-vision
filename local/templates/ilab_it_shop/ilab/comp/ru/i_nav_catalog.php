<?$APPLICATION->IncludeComponent("it_shop:i_catalog_menu_v1.0", "i_v_menu", array(
	"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "3",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"I_DEPTH_LEVEL" => "4",
		"I_PRICE_CODE" => array(
			0 => "ROZN_s1",
			1 => "ESHOP_s1",
			2 => "DEALER_s1",
		),
		"I_STICKER" => array(
			0 => "GIFT",
			1 => "CREDIT",
			2 => "ACTION",
			3 => "BEST_PRICE",
			4 => "NEW",
		),
		"I_DIR" => $APPLICATION->GetCurDir(),
		"I_HIDE_MENU" => "Y",
		"I_NUMBER_ELEMENT" => "Y",
		"I_NUMBER_ELEMENT_1LVL" => "Y",
		"I_NUMBER_ELEMENT_NLVL" => "Y"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
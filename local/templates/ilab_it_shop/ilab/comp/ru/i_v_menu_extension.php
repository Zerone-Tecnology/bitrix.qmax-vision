<?$APPLICATION->IncludeComponent(
	"it_shop:i_catalog_menu_v1.0", 
	"i_v_menu_adaptive", 
	array(
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
		"I_HIDE_MENU" => "N",
		"I_NUMBER_ELEMENT" => "Y",
		"I_NUMBER_ELEMENT_1LVL" => "Y",
		"I_NUMBER_ELEMENT_NLVL" => "Y",
		"I_MENU_EXTENSION" => "Y",
		"COMPONENT_TEMPLATE" => "i_v_menu_adaptive",
		"I_MENU_ICON_TOP" => "N",
		"I_MENU_LINE" => "N",
		"I_COLOR_SCHEME" => "N",
		"I_REVERSE_IMAGE" => "N",
		"I_SHOW_SECT_MENU" => array(
		),
		"I_REMOVE_ICON" => "N",
		"I_MAX_PROP_PRICE" => "N",
		"I_COUNT_COL" => "3",
		"CONVERT_CURRENCY" => "N",
		"SHOW_PRICE_COUNT" => "1"
	),
	false
);?>
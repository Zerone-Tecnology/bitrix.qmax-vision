<?$APPLICATION->IncludeComponent(
	"it_shop:i_catalog_menu_v1.0", 
	"i_h_menu", 
	array(
		"IBLOCK_TYPE" => "catalog_en",
		"IBLOCK_ID" => "25",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
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
			3 => "I_VIDEO",
		),
		"I_DIR" => $APPLICATION->GetCurDir(),
		"I_HIDE_MENU" => "N",
		"I_NUMBER_ELEMENT" => "Y",
		"I_NUMBER_ELEMENT_1LVL" => "Y",
		"I_NUMBER_ELEMENT_NLVL" => "Y",
		"I_MENU_EXTENSION" => "N",
		"I_MENU_ICON_TOP" => "N",
		"I_MENU_LINE" => "Y",
		"I_COLOR_SCHEME" => "N",
		"I_DEL_SECT_MENU" => array(
			0 => "48",
			1 => "13",
			2 => "10",
			3 => "1",
			4 => "11",
			5 => "46",
		),
		"I_SHOW_SECT_MENU" => array(
			0 => "889",
			1 => "890",
			2 => "891",
			3 => "892",
			4 => "893",
			5 => "894",
			6 => "896",
			7 => "897",
			8 => "898",
		),
		"I_REMOVE_ICON" => "N",
		"COMPONENT_TEMPLATE" => "i_h_menu",
		"I_REVERSE_IMAGE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "USD"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
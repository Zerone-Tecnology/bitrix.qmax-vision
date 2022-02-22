<?$APPLICATION->IncludeComponent(
	"it_shop:i_catalog_menu_v2.0", 
	"i_h_menu", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "3",
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
			0 => "I_VIDEO",
		),
		"I_DIR" => $APPLICATION->GetCurDir(),
		"I_HIDE_MENU" => "N",
		"I_NUMBER_ELEMENT" => "Y",
		"I_NUMBER_ELEMENT_1LVL" => "N",
		"I_NUMBER_ELEMENT_NLVL" => "N",
		"I_MENU_EXTENSION" => "N",
		"I_MENU_ICON_TOP" => "N",
		"I_MENU_LINE" => "Y",
		"I_COLOR_SCHEME" => "Y",
		"I_DEL_SECT_MENU" => array(
			0 => "48",
			1 => "13",
			2 => "10",
			3 => "1",
			4 => "11",
			5 => "46",
		),
		"I_SHOW_SECT_MENU" => array(
		),
		"I_REMOVE_ICON" => "N",
		"COMPONENT_TEMPLATE" => "i_h_menu",
		"I_REVERSE_IMAGE" => "Y",
		"CONVERT_CURRENCY" => "Y",
		"I_MAX_PROP_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"I_COUNT_COL" => "3",
		"I_MOBILE_ICON" => "I_WHITE",
		"I_VIEW" => "i_v_menu_half",
		"I_MORE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CURRENCY_ID" => "KZT"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>

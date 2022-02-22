<?$APPLICATION->IncludeComponent(
	"it_shop:i_catalog_menu_v1.0", 
	"i_vp_menu", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "3",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"I_DEPTH_LEVEL" => "4",
		"I_PRICE_CODE" => array(
			0 => "ESHOP_s1",
			1 => "DEALER_s1",
			2 => "ROZN_s1",
		),
		"I_STICKER" => array(
		),
		"I_DIR" => $APPLICATION->GetCurDir(),
		"I_HIDE_MENU" => "N",
		"I_NUMBER_ELEMENT" => "Y",
		"I_NUMBER_ELEMENT_1LVL" => "N",
		"I_NUMBER_ELEMENT_NLVL" => "N",
		"I_MENU_EXTENSION" => "N",
		"COMPONENT_TEMPLATE" => "i_vp_menu",
		"I_MENU_ICON_TOP" => "N",
		"I_MENU_LINE" => "N",
		"I_COLOR_SCHEME" => "N",
		"I_REVERSE_IMAGE" => "N",
		"I_SHOW_SECT_MENU" => array(
		),
		"I_REMOVE_ICON" => "N",
		"CONVERT_CURRENCY" => "N",
		"I_MAX_PROP_PRICE" => "N",
		"I_COUNT_COL" => "3",
		"SHOW_PRICE_COUNT" => "1",
		"I_MOBILE_ICON" => "I_IMG",
		"I_VIEW" => "i_v_menu_half",
		"I_MORE" => "N"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
	<?global $i_arrFilter_spec;
		$i_arrFilter_spec = array( '!PROPERTY_S_SPECIAL_OFFERS'=>false ); //Фильтр по свойству инфоблока (поставлено ! т.к. при строгом сравнение не работает!)?>
	<?$APPLICATION->IncludeComponent(
	"it_shop:b_catalog.section", 
	"i_catalog_section", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "3",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "PROPERTY_S_SPECIAL_OFFERS",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "i_arrFilter_spec",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "7",
		"LINE_ELEMENT_COUNT" => "1",
		"PROPERTY_CODE" => array(
			0 => "SIZE",
			1 => "MANUFACTURER",
			2 => "COLOR",
			3 => "COUNTRY",
			4 => "MEMORY",
			5 => "DIMENSIONS",
			6 => "DIAGONAL_SCREEN",
			7 => "DIAGONAL_SCREEN1",
			8 => "SCEEN_SIZE",
			9 => "NUMBER_SIM_CARDS",
			10 => "DISPLAY_RESOLUTION",
			11 => "",
		),
		"OFFERS_LIMIT" => "5",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SET_META_KEYWORDS" => "N",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "N",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"CACHE_FILTER" => "Y",
		"PRICE_CODE" => array(
			0 => "DEALER_s1",
			1 => "ROZN_s1",
			2 => "ESHOP_s1",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"PAGER_TEMPLATE" => "i_visual",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"I_SWIPE" => "bw_rec",
		"I_TITLE" => "Мы рекомендуем",
		"I_TITLE_LINK" => "/recommended/",
		"I_STICKER" => array(
			0 => "S_GIFT",
			1 => "S_CREDIT",
			2 => "S_ACTION",
			3 => "I_SYSTEM_IN_STOCK",
			4 => "S_BEST_PRICE",
			5 => "S_SPECIAL_OFFERS",
			6 => "I_SYSTEM_TO_ORDER",
			7 => "S_NEW",
			8 => "I_SYSTEM_EXPECTED",
			9 => "I_DISCOUNT",
		),
		"I_DEALER_PRICE" => "DEALER_s1",
		"I_ROZN_PRICE" => "ROZN_s1",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "COLOR_REF",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"SET_BROWSER_TITLE" => "N",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "COLOR_REF",
		),
		"COMPONENT_TEMPLATE" => "i_catalog_section",
		"I_IWIDE_BLOCK" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"I_SHOW_NUMBER" => "N",
		"I_PRICE_MATRIX" => "N",
		"I_WATER_MARK" => "N",
		"I_MAX_PROP_PRICE" => "Y",
		"I_PROP_PRICE_NAME" => "N",
		"CURRENCY_ID" => "KZT"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
<?$APPLICATION->IncludeComponent(
	"it_shop:i_element_v1.0", 
	"i_banner_adaptive", 
	array(
		"IBLOCK_TYPE" => "imarket",
		"IBLOCK_ID" => "43",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"SECTION_ID" => "",
		"PROPERTY_CODE" => array(
			0 => "I_LINK_RU",
			1 => "I_LG_BANNER_RU",
			2 => "I_MD_BANNER_RU",
			3 => "I_SM_BANNER_RU",
			4 => "",
		),
		"I_LIMIT_TEASER" => "",
		"I_POINT" => "",
		"I_SECTION_ID" => $arParams["SECTION_ID"],
		"COMPONENT_TEMPLATE" => "i_banner_adaptive",
		"I_HEIGHT" => "",
		"I_RAND_ONE" => "N",
		"I_TITLE" => "Специальные предложения",
		"I_TITLE_LINK" => "/"
	),
	false
);?>
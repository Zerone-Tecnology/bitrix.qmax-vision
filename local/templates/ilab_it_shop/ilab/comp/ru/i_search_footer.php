<?$APPLICATION->IncludeComponent(
	"it_shop:b_search.title", 
	"i_search_title_footer",
	array(
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "5",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "Y",
		"PAGE" => "/search/index.php",
		"CATEGORY_OTHERS_TITLE" => "Прочее",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "main",
			1 => "iblock_catalog",
		),
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "3",
		),
		"CATEGORY_0_main" => array(
		),
		"COMPONENT_TEMPLATE" => "i_search_title_footer"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
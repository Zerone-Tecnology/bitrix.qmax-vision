<?$APPLICATION->IncludeComponent(
	"it_shop:i_news_actions", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"IBLOCK_TYPE" => "imarket",
		"IBLOCK_ID_1" => "7",
		"IBLOCK_ID_2" => "6",
		"I_COUNT_NEWS" => "2",
		"I_COUNT_ACTIONS" => "3",
		"I_NAME_NEWS_RU" => "",
		"I_NAME_NEWS_KZ" => "",
		"I_NAME_NEWS_EN" => "",
		"I_NAME_ACTIONS_RU" => "",
		"I_NAME_ACTIONS_KZ" => "",
		"I_NAME_ACTIONS_EN" => ""
	),
	Array(),
	array(
		"MODE" => "html",
		"NAME" => "Новости",
		"SHOW_BORDER" => true
	)
);?>
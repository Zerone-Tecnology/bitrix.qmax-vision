<?$APPLICATION->IncludeComponent(
	"it_shop:b_menu", 
	"i_tophidemenu", 
	array(
		"ROOT_MENU_TYPE" => "topmenu",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "i_tophidemenu"
	),
	false
);?>
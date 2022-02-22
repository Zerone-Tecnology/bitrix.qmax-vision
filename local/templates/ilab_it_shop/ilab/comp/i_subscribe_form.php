<?$APPLICATION->IncludeComponent(
	"it_shop:b_subscribe.form", 
	"i_subscribe.form", 
	array(
		"COMPONENT_TEMPLATE" => "i_subscribe.form",
		"USE_PERSONALIZATION" => "Y",
		"SHOW_HIDDEN" => "N",
		"PAGE" => "/personal/subscription/",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"I_HINT_SUBSCRIBE" => $_COOKIE["I_HINT_SUBSCRIBE"],
		"I_GET_SITE" => Bitrix\Main\Context::getCurrent()->getSite(),
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
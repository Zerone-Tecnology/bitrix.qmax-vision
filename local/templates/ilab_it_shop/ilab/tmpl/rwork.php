<?
if( CSite::InDir(SITE_DIR.'personal/') )
	$type = 'left';
else
	$type = 'topmenu';?>
<?$APPLICATION->IncludeComponent(
	"it_shop:b_menu", 
	"i_leftmenu", 
	array(
		"ROOT_MENU_TYPE" => $type,
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "i_leftmenu"
	),
	false
);?>
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_catalog_banner.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner slider?>
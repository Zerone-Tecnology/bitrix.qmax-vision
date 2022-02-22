<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Page as BMPage;
if( false )
{
	$APPLICATION->ShowHead();
	$APPLICATION->IncludeFile('/local/templates/ilab_it_shop/ilab/tmpl/head.php',Array(),Array('SHOW_BORDER'=>false));
	// CSS
	BMPage\Asset::getInstance()->addCss('/local/templates/ilab_it_shop/ilab/modules/compare/css/iCompareModal.css');
	$APPLICATION->ShowPanel();
}
// ---------------------------------------------------------------------------------------------------- iLaB
if( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['KEY']=='CompareModal_v0.0.1' )
{

	if( false )// debugging - true to view params
		print_r($_POST);

	if( false )
		echo '<div class="ilab_compare j_ilab_compare" style="display:none"><div class="ilab_compare_close j_ilab_compare_close"></div><div class="ilab_compare_result j_ilab_compare_result">';

	require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/modules/compare/php/functions.php');// p_ilab
	require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');
	?><?$APPLICATION->IncludeComponent(
	"it_shop:b_catalog.compare.result",
	"iCompare",
	array(
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "KZT",
		"DETAIL_URL" => "",
		"DISPLAY_ELEMENT_SELECT_BOX" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD_BOX" => "name",
		"ELEMENT_SORT_FIELD_BOX2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER_BOX" => "asc",
		"ELEMENT_SORT_ORDER_BOX2" => "desc",
		"FIELD_CODE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
		),
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => 3,// $_SESSION["I_CITY_IBLOCK_ID"],
		"IBLOCK_TYPE" => 'catalog_it',// $_SESSION["I_CITY_IBLOCK_TYPE"],
		"NAME" => "CATALOG_COMPARE_LIST",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PRICE_CODE" => array(
			0 => "ROZN_s1",
			1 => "ESHOP_s1",
			2 => "DEALER_s1",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PROPERTY_CODE" => array(
			0 => "I_",
			1 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_PRICE_COUNT" => "N",
		"COMPONENT_TEMPLATE" => "iCompare",
		// ilab
		"I_PROPERTY_CODE" => array(
			0 => "CML2_LINK",
			1 => "CML2_TRAITS",
			2 => "CML2_BASE_UNIT",
			3 => "CML2_TAXES",
			4 => "CML2_BAR_CODE",
			5 => "S_NEW",
			6 => "S_RECOMENDED",
			7 => "S_SPECIAL_OFFERS",
			8 => "S_ACTION",
			9 => "S_BSET_PRICE",
			10 => "S_CREDIT",
			11 => "S_GIFT",
			12 => "S_SUPER_PRICE",
		),
		'I_LANGUAGE' => $_POST['i_language'],
		"CH_IBLOCK_TYPE" => "catalog",
		"CH_IBLOCK_ID" => "3",
		"CH_IBLOCK" => "Y",
		"V_IBLOCK_TYPE" => "I_CITY_IBLOCK_TYPE",
		"V_IBLOCK_ID" => "I_CITY_IBLOCK_ID"
	),
	false
);?><?

	if( false )
		echo '</div></div>';

	if( false )// debugging - true to view params
	{
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
	}

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
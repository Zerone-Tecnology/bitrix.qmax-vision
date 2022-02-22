<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>

<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_center.php',Array(),Array('MODE'=>'html', 'NAME'=>'Центр блок', 'SHOW_BORDER'=>false));// Center block
$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_breadcrumb.php',Array(),Array('MODE'=>'html', 'NAME'=>'Хлебные-крошки', 'SHOW_BORDER'=>false));// Breadcrumb?>

<?if( $arParams['I_CHECK_OFFERS'] == 'Y')
	$tEle = 'offers';
else
	$tEle = '.default';

?>

<?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	$tEle,
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
		"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
		"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
		"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],

		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],

		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'SHOW_MAX_QUANTITY' => $arParams['DETAIL_SHOW_MAX_QUANTITY'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
		'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
		'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
		'USE_COMMENTS' => $arParams['DETAIL_USE_COMMENTS'],
		'BLOG_USE' => (isset($arParams['DETAIL_BLOG_USE']) ? $arParams['DETAIL_BLOG_USE'] : ''),
		'BLOG_URL' => (isset($arParams['DETAIL_BLOG_URL']) ? $arParams['DETAIL_BLOG_URL'] : ''),
		'VK_USE' => (isset($arParams['DETAIL_VK_USE']) ? $arParams['DETAIL_VK_USE'] : ''),
		'VK_API_ID' => (isset($arParams['DETAIL_VK_API_ID']) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
		'FB_USE' => (isset($arParams['DETAIL_FB_USE']) ? $arParams['DETAIL_FB_USE'] : ''),
		'FB_APP_ID' => (isset($arParams['DETAIL_FB_APP_ID']) ? $arParams['DETAIL_FB_APP_ID'] : ''),
		'BRAND_USE' => (isset($arParams['DETAIL_BRAND_USE']) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
		'BRAND_PROP_CODE' => (isset($arParams['DETAIL_BRAND_PROP_CODE']) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
		'DISPLAY_NAME' => (isset($arParams['DETAIL_DISPLAY_NAME']) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
		'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
		"DISPLAY_PREVIEW_TEXT_MODE" => (isset($arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE']) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
		"DETAIL_PICTURE_MODE" => (isset($arParams['DETAIL_DETAIL_PICTURE_MODE']) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : ''),
		"SHOW_DEACTIVATED" => $arParams["SHOW_DEACTIVATED"],// Показать деактивированные товары

		// iLaB
		'I_STICKER'				=> $arParams['I_STICKER'],
		'I_DEALER_PRICE'		=> $arParams['I_DEALER_PRICE'],
		'I_COUNT_PRO'			=> $arParams['I_COUNT_PRO'],
		'I_PAGEN'				=> $_GET['PAGEN'],
		'I_OFFER_TREE_PROPS'	=> $arParams['I_OFFER_TREE_PROPS'],
		'I_IBLOCK_OFFERS'		=> $arParams['I_IBLOCK_OFFERS'],
		'I_CHECK_QUANTITY'		=> $arParams['I_CHECK_QUANTITY'],
		'I_QUAN_VERY_LITTLE'	=> $arParams['I_QUAN_VERY_LITTLE'],
		'I_QUAN_LITTLE'			=> $arParams['I_QUAN_LITTLE'],
		'I_QUAN_AVERAGE'		=> $arParams['I_QUAN_AVERAGE'],
		'I_OFFER_TREE_IMG'		=> $arParams['I_OFFER_TREE_IMG'],
		'I_INSTRUCTION'			=> $arParams['I_INSTRUCTION'],
		'I_RELATED'				=> $arParams['I_RELATED'],
		'I_SWIPER_AUTOPLAY'		=> $arParams['I_SWIPER_AUTOPLAY'],
		'I_OFFERS_MORE'			=> $arParams['I_OFFERS_MORE'],
		'I_CHECK_SIMILAR'		=> $arParams['I_CHECK_SIMILAR'],
		'I_CHECK_RELATED'		=> $arParams['I_CHECK_RELATED'],
		'I_SHOW_NUMBER'			=> $arParams['I_SHOW_NUMBER'],
		'I_MIN_PUTCHASE_AMOUNT'	=> $arParams['I_MIN_PUTCHASE_AMOUNT'],
		'I_PRICE_MATRIX'		=> $arParams['I_PRICE_MATRIX'],
		'I_BREDCRUMBS_HEADER'	=> $arParams['I_BREDCRUMBS_HEADER'],
		'I_WATER_MARK_ELEMENT'	=> $arParams['I_WATER_MARK_ELEMENT'],
		'I_APPROVAL_REVIEWS'	=> $arParams['I_APPROVAL_REVIEWS'],
		'I_MAX_PROP_PRICE'		=> $arParams['I_MAX_PROP_PRICE'],
		'I_TO_ORDER'			=> $arParams['I_TO_ORDER'],
		'I_CB_ATTENTION'		=> $arParams['I_CB_ATTENTION'],
		'I_CB_PREVIEW'			=> $arParams['I_CB_PREVIEW'],
		'I_CB_CHARACTERISTICS'  => $arParams['I_CB_CHARACTERISTICS'],
		'I_CI_DESCRIPTION'	    => $arParams['I_CI_DESCRIPTION'],
		'I_CI_CHARACTERISTICS'	=> $arParams['I_CI_CHARACTERISTICS'],
		'I_CI_VIDEO'			=> $arParams['I_CI_VIDEO'],
		'I_CI_REVIEWS'			=> $arParams['I_CI_REVIEWS'],
		// iLaB
	),
	$component
);?>

<?/*
if ( !CModule::IncludeModule('catalog') )
	return;
$productID		= $ElementID;
$quantity		= 1;
$renewal		= 'N';

$arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
if (!$arPrice || count($arPrice) <= 0)
{
	if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($productID, $quantity, $USER->GetUserGroupArray()))
	{
		$quantity = $nearestQuantity;
		$arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
	}
}*/?>

<?if( $_SESSION['I_RELATED'] && ($arParams['I_CHECK_RELATED']=='Y') ):
	global $if_product_line;
	$if_product_line['ID']						= $_SESSION['I_RELATED'];?>

	<div class="i_mt25 i_element_items">
		<?$APPLICATION->IncludeComponent(
		"it_shop:b_catalog.section",
		"i_catalog_section",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			// iLab
			"ELEMENT_SORT_FIELD" => "PROPERTY_MINIMUM_PRICE",//$arParams['ELEMENT_SORT_FIELD'],
			"ELEMENT_SORT_ORDER" => "asc",//$arParams['ELEMENT_SORT_ORDER'],
			"ELEMENT_SORT_FIELD2" => "id",//$arParams['ELEMENT_SORT_FIELD2'],
			"ELEMENT_SORT_ORDER2" => "desc",//$arParams['ELEMENT_SORT_ORDER2'],
			"FILTER_NAME" => "if_product_line",
			"SHOW_ALL_WO_SECTION"=> "Y",
			//"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			//"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			// iLab
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => 9,//$arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => 1,//$arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"ADD_SECTIONS_CHAIN" => "N",
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
			// ilab
			'I_SWIPE'		=> 'sw_pr',
			'I_TITLE'		=> $arParams['I_TITLE_RELATED'],
			'I_SHOW_NUMBER'			=> $arParams['I_SHOW_NUMBER'],
			'I_PRICE_MATRIX'		=> $arParams['I_PRICE_MATRIX'],
			'I_WATER_MARK_SECTION'	=> $arParams['I_WATER_MARK_SECTION'],
			'I_MAX_PROP_PRICE'		=> $arParams['I_MAX_PROP_PRICE'],
			// ilab
			//bitrix
			'SET_BROWSER_TITLE'		=> 'N',
			//bitrix
		),
		$component
		);?>
	</div>
<?endif?>

<?if( $_SESSION['I_PRICE_SIMILAR'] && ($arParams['I_CHECK_SIMILAR']=='Y') ):
	global $if_similar;
	$if_similar['!ID']						= $ElementID;
	$if_similar['>PROPERTY_MINIMUM_PRICE']	= $_SESSION['I_PRICE_SIMILAR'];?>

	<div class="i_mt25 i_element_items">
		<?$APPLICATION->IncludeComponent(
		"it_shop:b_catalog.section",
		"i_catalog_section",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			// iLab
			"ELEMENT_SORT_FIELD" => "PROPERTY_MINIMUM_PRICE",//$arParams['ELEMENT_SORT_FIELD'],
			"ELEMENT_SORT_ORDER" => "asc",//$arParams['ELEMENT_SORT_ORDER'],
			"ELEMENT_SORT_FIELD2" => "id",//$arParams['ELEMENT_SORT_FIELD2'],
			"ELEMENT_SORT_ORDER2" => "desc",//$arParams['ELEMENT_SORT_ORDER2'],
			"FILTER_NAME" => "if_similar",
			// iLab
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => 9,//$arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => 1,//$arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"ADD_SECTIONS_CHAIN" => "N",
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
			// ilab
			'I_SWIPE'		=> 'sw_si',
			'I_TITLE'		=> $arParams['I_TITLE_SIMILAR'],
			'I_SHOW_NUMBER'			=> $arParams['I_SHOW_NUMBER'],
			'I_PRICE_MATRIX'		=> $arParams['I_PRICE_MATRIX'],
			'I_WATER_MARK_SECTION'	=> $arParams['I_WATER_MARK_SECTION'],
			'I_MAX_PROP_PRICE'		=> $arParams['I_MAX_PROP_PRICE'],
			// ilab
			//bitrix
			'SET_BROWSER_TITLE'		=> 'N',
			//bitrix
		),
		$component
		);?>
	</div>
<?endif?>

<?
if($arParams["USE_REVIEW"]=="Y" && IsModuleInstalled("forum") && $ElementID['ID']):?>
	<?// ---------------------------------------------------------------------------------------------------- SetViewTarget
	/*$this->SetViewTarget('forum_topic_reviews');?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:forum.topic.reviews",
			"",
			Array(
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
				"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
				"PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
				"FORUM_ID" => $arParams["FORUM_ID"],
				"URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
				"SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
				"ELEMENT_ID" => $ElementID['ID'],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
				"POST_FIRST_MESSAGE" => $arParams["POST_FIRST_MESSAGE"],
				"URL_TEMPLATES_DETAIL" => $arParams["POST_FIRST_MESSAGE"]==="Y"? $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"] :"",
			),
			$component
		);?>
	<?$this->EndViewTarget();*/
	// ---------------------------------------------------------------------------------------------------- EndViewTarget?>
<?endif
?>

<?
if (0 < $ElementID)
{
	$arRecomData = array();
	$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($recomCacheID), "/catalog/recommended"))
	{
		$arRecomData = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		if (\Bitrix\Main\Loader::includeModule("catalog"))
		{
			$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
			$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
			$arRecomData['IBLOCK_LINK'] = '';
			$arRecomData['ALL_LINK'] = '';
			$rsProps = CIBlockProperty::GetList(
				array('SORT' => 'ASC', 'ID' => 'ASC'),
				array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_TYPE' => 'E', 'ACTIVE' => 'Y')
			);
			$found = false;
			while ($arProp = $rsProps->Fetch())
			{
				if ($found)
				{
					break;
				}
				if ($arProp['CODE'] == '')
				{
					$arProp['CODE'] = $arProp['ID'];
				}
				$arProp['LINK_IBLOCK_ID'] = intval($arProp['LINK_IBLOCK_ID']);
				if ($arProp['LINK_IBLOCK_ID'] != 0 && $arProp['LINK_IBLOCK_ID'] != $arParams['IBLOCK_ID'])
				{
					continue;
				}
				if ($arProp['LINK_IBLOCK_ID'] > 0)
				{
					if ($arRecomData['IBLOCK_LINK'] == '')
					{
						$arRecomData['IBLOCK_LINK'] = $arProp['CODE'];
						$found = true;
					}
				}
				else
				{
					if ($arRecomData['ALL_LINK'] == '')
					{
						$arRecomData['ALL_LINK'] = $arProp['CODE'];
					}
				}
			}
			if ($found)
			{
				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache("/catalog/recommended");
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
					$CACHE_MANAGER->EndTagCache();
				}
			}
		}
		$obCache->EndDataCache($arRecomData);
	}
	/*if (!empty($arRecomData) && ($arRecomData['IBLOCK_LINK'] != '' || $arRecomData['ALL_LINK'] != '')):?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.recommended.products",
			"",
			array(
				"LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
				"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
				"ID" => $ElementID,
				"PROPERTY_LINK" => ($arRecomData['IBLOCK_LINK'] != '' ? $arRecomData['IBLOCK_LINK'] : $arRecomData['ALL_LINK']),
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
				"PAGE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
				"SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
				"SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRODUCT_SUBSCRIPTION" => 'N',
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
				"SHOW_NAME" => "Y",
				"SHOW_IMAGE" => "Y",
				"MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
				"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
				"MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
				"MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
				"SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
				"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
				"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
				"PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => array(),
				"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY']
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?>
	<?endif*/?>

	<?/*if($arParams["USE_ALSO_BUY"] == "Y" && \Bitrix\Main\ModuleManager::isModuleInstalled("sale") && !empty($arRecomData)):?>
		<?$APPLICATION->IncludeComponent("bitrix:sale.recommended.products", ".default", array(
			"ID" => $ElementID,
			"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"MIN_BUYES" => $arParams["ALSO_BUY_MIN_BUYES"],
			"ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
			"DETAIL_URL" => $arParams["DETAIL_URL"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PAGE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
			"SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
			"PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => array(   ),
			"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"]
			),
			$component
		);?>
	<?endif*/?>

	<?
		if($arParams["USE_ALSO_BUY"] == "Y"):
			?>
			<div class="i_mt25 i_element_items">
			<?	$APPLICATION->IncludeComponent("it_shop:b_sale.recommended.products","",
			Array(
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "3",
				"ID" => $ElementID,
				"MIN_BUYES" => "1",
				"HIDE_NOT_AVAILABLE" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"PRODUCT_SUBSCRIPTION" => "N",
				"SHOW_NAME" => "Y",
				"SHOW_IMAGE" => "Y",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"PAGE_ELEMENT_COUNT" => "30",
				"LINE_ELEMENT_COUNT" => "3",
				"TEMPLATE_THEME" => "blue",
				"DETAIL_URL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "86400",
				"SHOW_OLD_PRICE" => "N",
				"PRICE_CODE" => array("ROZN_s1", "ESHOP_s1", "DEALER_s1"),
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"BASKET_URL" => "/personal/basket.php",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"USE_PRODUCT_QUANTITY" => "Y",
				"I_TITLE" => "SRP_HREF_TITLE",
				"I_SWIPE" => "sr"
			)
		);?>
			</div>
		<? endif;
	?>

	<?if($arParams["USE_STORE"] == "Y" && \Bitrix\Main\ModuleManager::isModuleInstalled("catalog")):?>
		<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", ".default", array(
			"PER_PAGE" => "10",
			"USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
			"SCHEDULE" => $arParams["USE_STORE_SCHEDULE"],
			"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
			"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
			"ELEMENT_ID" => $ElementID,
			"STORE_PATH"  =>  $arParams["STORE_PATH"],
			"MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
		),
		$component
		);?>
	<?endif;
}
?>

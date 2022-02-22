<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB
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
$this->setFrameMode(true);
$l = strtoupper(LANGUAGE_ID);

// количество товаров на странице - cookie
if( $_COOKIE['I_COO_PAGES'] )
	$count = $_COOKIE['I_COO_PAGES'];

if( $arResult['CURRENT_SECTION']['DEPTH_LEVEL']==1 && ($arResult['CURRENT_SECTION']['RIGHT_MARGIN']-$arResult['CURRENT_SECTION']['LEFT_MARGIN'])>1 && $arParams['I_PAGE_SECTION_LIST']=='Y' ):?>

	<div class="i_h_menu">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_h_menu.php',Array(),Array('SHOW_BORDER'=>false))// horizontal?>
	</div>

	<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_breadcrumb.php',Array(),Array('MODE'=>'html', 'NAME'=>'Хлебные-крошки', 'SHOW_BORDER'=>false));// Breadcrumb?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"i_catalog.section.list.level2",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
			'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
			"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
			"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
		),
		$component
	);
	?>

	<?return;
endif;

if (!$arParams['FILTER_VIEW_MODE'])
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$verticalGrid = ('Y' == $arParams['USE_FILTER'] && $arParams['FILTER_VIEW_MODE'] == 'VERTICAL');

if ($verticalGrid):?>
	<?//<div class="workarea grid2x1">?>
	<div class="i_h_menu">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_h_menu.php',Array(),Array('SHOW_BORDER'=>false))// horizontal?>
	</div>
	<div class="i_cat_list_flex">
<?endif;

if ($arParams['USE_FILTER'] == 'Y')
{
	$arFilter = array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'ACTIVE' => 'Y',
		'GLOBAL_ACTIVE' => 'Y',
	);
	if (0 < intval($arResult['VARIABLES']['SECTION_ID']))
	{
		$arFilter['ID'] = $arResult['VARIABLES']['SECTION_ID'];
	}
	elseif ('' != $arResult['VARIABLES']['SECTION_CODE'])
	{
		$arFilter['=CODE'] = $arResult['VARIABLES']['SECTION_CODE'];
	}

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), '/iblock/catalog'))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (\Bitrix\Main\Loader::includeModule('iblock'))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array('ID'));

			if(defined('BX_COMP_MANAGED_CACHE'))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache('/iblock/catalog');

				if ($arCurSection = $dbRes->Fetch())
				{
					$CACHE_MANAGER->RegisterTag('iblock_id_'.$arParams['IBLOCK_ID']);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
	{
		$arCurSection = array();
	}
	if ($verticalGrid):?>
		<div class="i_cat_list_left">
	<?endif?>
	<?/*
	<div class="i_cat_menu">
	<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_v_menu_extension.php',Array(),Array('MODE'=>'html', 'NAME'=>'Вертикальное меню каталога', 'SHOW_BORDER'=>false));// Vertical catalog menu?>
	</div>
	*/?>
	<?$APPLICATION->IncludeComponent(
	'it_shop:b_catalog.smart.filter',
	'visual_'.($arParams['FILTER_VIEW_MODE'] == 'HORIZONTAL' ? 'horizontal' : 'vertical'),
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arCurSection['ID'],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SAVE_IN_SESSION" => "N",
		"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		"SEF_MODE" => $arParams["SEF_MODE"],
		"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
		"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
		'POPUP_POSITION' => 'right',
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);?>
	<div class="i_cat_leftbanner">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_catalog_banner.php',Array('SECTION_ID'=>$arCurSection['ID']),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner slider?>

    </div>
	<?if ($verticalGrid):?>
	</div>
<?endif;
}
if ($verticalGrid):?>
	<div class="i_cat_list_right">

		<div class="i_cat_search">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search?>
		</div>

	<div class="i_cat_banner">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_banner_catalog.php',Array('SECTION_ID'=>$arCurSection['ID']),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner?>
	</div>

	<div class="i_tc_top">
        <div class="i_cat_breadcrumb">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_breadcrumb.php',Array(),Array('MODE'=>'html', 'NAME'=>'Хлебные-крошки', 'SHOW_BORDER'=>false));// Breadcrumb?>
        </div>


        <div class="i_cat_view js_cat_view">
			<svg viewBox="0 0 200 220" data-class="i_c_view1" data-view='{"class":"i_cs_block"}'<?if( !$_COOKIE['I_VIEW_CATALOG'] || $_COOKIE['I_VIEW_CATALOG']=='i_cs_block' )echo 'class="i_c_view_act"'?>>
				<path d="M110,220V120h90v100H110L110,220z M110,0h90v100h-90V0L110,0z M0,120h90v100H0V120L0,120z M0,0h90v100H0V0L0,0z">
			</svg>
			<svg viewBox="0 0 200 220" data-class="i_c_view2" data-view='{"class":"i_cs_list_bg"}'<?if( $_COOKIE['I_VIEW_CATALOG']=='i_cs_list_bg' )echo 'class="i_c_view_act"'?>>
				<path d="M0,220V120h200v100H0L0,220z M0,0h200v100H0V0L0,0z">
			</svg>
			<svg viewBox="0 0 200 220" data-class="i_c_view3" data-view='{"class":"i_cs_list_sm"}'<?if( $_COOKIE['I_VIEW_CATALOG']=='i_cs_list_sm' )echo 'class="i_c_view_act"'?>>
				<path d="M0,60V0h200v60H0L0,60z M0,140V80h200v60H0L0,140z M0,220v-60h200v60H0L0,220z">
			</svg>
		</div>

	</div>
    <h1 class="i_title_catalog"><?=$arResult['CURRENT_SECTION']['NAME']//$APPLICATION->ShowTitle()?></h1>
	<div class="i_sc ifont110 aclear">
		<div class="ifleft">
			<?// ---------------------------------------------------------------------------------------------------- SORT
			/*if( $arParams['I_SORT_NAME']=='Y' )
				$arSort['name']		= Array('PROPERTY_I_NAME_'.$l, 'asc');
			else
				$arSort['name']		= Array('name', 'asc');*/
			if ($arParams['I_SORT_PRICE'] == 'Y')
			{
				$arGroups = $USER->GetUserGroupArray();
				$sort_b = '';

				if ($USER->IsAuthorized()) {
					foreach ($arGroups as $group) {
						if ($group == 5) {
							$arSort['price'] = Array('catalog_PRICE_'.$arParams['I_SORT_PRICE_TYPE_'.$group], 'asc');
							$sort_b = 'catalog_PRICE_'.$arParams['I_SORT_PRICE_TYPE_'.$group];
						} elseif ($group == 1) {
							$arSort['price'] = Array('PROPERTY_MINIMUM_PRICE', 'asc');
							$sort_b = $arParams['ELEMENT_SORT_FIELD'];
							//echo $sort_b;
						} elseif ( $group != 5 && $group != 1 ) {
							$arSort['price'] = Array('catalog_PRICE_'.$arParams['I_SORT_PRICE_TYPE_2'], "asc");
							$sort_b = 'catalog_PRICE_'.$arParams['I_SORT_PRICE_TYPE_2'];
						}
						//echo $group;
					}
				} else {
					$arSort['price'] = Array('catalog_PRICE_'.$arParams['I_SORT_PRICE_TYPE_2'], "asc");
					$sort_b = 'catalog_PRICE_'.$arParams['I_SORT_PRICE_TYPE_2'];
				}
			}else {
				$arSort['price'] = Array('PROPERTY_MINIMUM_PRICE', 'asc');
				$sort_b = $arParams['ELEMENT_SORT_FIELD'];
			}

			//				$arSort['quantity']		= Array('catalog_quantity', 'asc');
			$arSort['shows']		= Array('shows', 'asc');

			$sort		= array_key_exists('sort', $_REQUEST)	&& array_key_exists(ToLower($_REQUEST['sort']), $arSort)		? $arSort[ToLower($_REQUEST['sort'])][0] : $sort_b;//'name';
			$sort_order	= array_key_exists('order', $_REQUEST)	&& in_array(ToLower($_REQUEST['order']), Array('asc', 'desc'))	? ToLower($_REQUEST['order']) : $arParams['ELEMENT_SORT_ORDER'];//$arSort[$sort][1];?>
			<div class="i_sort">
				<span class="i_sort_t"><?=GetMessage('SORT')?>:</span>

				<?foreach ($arSort as $key => $val):
					$className = ($sort == $val[0]) ? ' current' : '';
					if ($className)
						$className .= ($sort_order == 'asc') ? ' asc' : ' desc';
					$newSort = ($sort == $val[0]) ? ($sort_order == 'desc' ? 'asc' : 'desc') : $arSort[$key][1];?>
					<a href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'))?>" class="i_sort_b<?=$className?>" rel="nofollow">
						<span><?=GetMessage('SORT_'.$key)?></span>
						<?//if( $sort == $val[0] )echo '<span></span>'?>
					</a>
				<?endforeach?>
			</div>
			<?// ---------------------------------------------------------------------------------------------------- SORT?>
		</div>

		<div class="ifright iprel">
			<?if($arParams['USE_COMPARE']=='Y'):?>
				<?$APPLICATION->IncludeComponent(
					'bitrix:catalog.compare.list',
					'',
					array(
						'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
						'IBLOCK_ID' => $arParams['IBLOCK_ID'],
						'NAME' => $arParams['COMPARE_NAME'],
						'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
						'COMPARE_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
					),
					$component
				);?>
			<?endif;// if($arParams['USE_COMPARE']=='Y')?>
		</div>

	</div>

<?endif// if ($verticalGrid)?>

	<div class="idnone">
		<?if($arParams['I_BREDCRUMBS_HEADER']!='Y'):?>
			<?$APPLICATION->IncludeComponent(
				'bitrix:catalog.section.list',
				'',
				array(
					'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
					'IBLOCK_ID' => $arParams['IBLOCK_ID'],
					'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
					'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
					'CACHE_TYPE' => $arParams['CACHE_TYPE'],
					'CACHE_TIME' => $arParams['CACHE_TIME'],
					'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
					'COUNT_ELEMENTS' => $arParams['SECTION_COUNT_ELEMENTS'],
					'TOP_DEPTH' => $arParams['SECTION_TOP_DEPTH'],
					'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
					'VIEW_MODE' => $arParams['SECTIONS_VIEW_MODE'],
					'SHOW_PARENT_NAME' => $arParams['SECTIONS_SHOW_PARENT_NAME'],
					'HIDE_SECTION_NAME' => (isset($arParams['SECTIONS_HIDE_SECTION_NAME']) ? $arParams['SECTIONS_HIDE_SECTION_NAME'] : 'N'),
					'ADD_SECTIONS_CHAIN' => (isset($arParams['ADD_SECTIONS_CHAIN']) ? $arParams['ADD_SECTIONS_CHAIN'] : ''),
					'I_BREDCRUMBS_HEADER' => $arParams['I_BREDCRUMBS_HEADER'],
				),
				$component
			);?>
		<?endif?>
	</div>

<?$intSectionID = 0;?>
<div class="i_catalog_section_order">
<?$intSectionID = $APPLICATION->IncludeComponent(
	'bitrix:catalog.section',
	'',
	array(
		'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		//SORT
		'ELEMENT_SORT_FIELD' => $sort,//$arParams['ELEMENT_SORT_FIELD'],
		'ELEMENT_SORT_ORDER' => $sort_order,//$arParams['ELEMENT_SORT_ORDER'],
		//SORT
		'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
		'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
		'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
		'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
		'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
		'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
		'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
		'BASKET_URL' => $arParams['BASKET_URL'],
		'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
		'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
		'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
		'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
		'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
		'FILTER_NAME' => $arParams['FILTER_NAME'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'CACHE_FILTER' => $arParams['CACHE_FILTER'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
		'SET_TITLE' => $arParams['SET_TITLE'],
		'SET_STATUS_404' => $arParams['SET_STATUS_404'],
		'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
		'PAGE_ELEMENT_COUNT' => $count ?? $arParams['PAGE_ELEMENT_COUNT'],
		'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
		'PRICE_CODE' => $arParams['PRICE_CODE'],
		'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
		'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

		'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
		'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
		'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
		'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
		'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],

		'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
		'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
		'PAGER_TITLE' => $arParams['PAGER_TITLE'],
		'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
		'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
		'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
		'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
		'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],

		'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
		'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
		'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
		'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
		'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
		'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
		'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
		'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],

		'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
		'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
		'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
		'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],

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
		'ADD_SECTIONS_CHAIN' => 'N',

		// iLaB
		'I_STICKER'				=> $arParams['I_STICKER'],
		'I_DEALER_PRICE'		=> $arParams['I_DEALER_PRICE'],
		'I_SHOW_NUMBER'			=> $arParams['I_SHOW_NUMBER'],
		'I_PRICE_MATRIX'		=> $arParams['I_PRICE_MATRIX'],
		'I_WATER_MARK_SECTION'	=> $arParams['I_WATER_MARK_SECTION'],
		'I_MAX_PROP_PRICE'		=> $arParams['I_MAX_PROP_PRICE'],
		'I_CHECK_QUANTITY'		=> $arParams['I_CHECK_QUANTITY'],
		'I_QUAN_VERY_LITTLE'	=> $arParams['I_QUAN_VERY_LITTLE'],
		'I_QUAN_LITTLE'			=> $arParams['I_QUAN_LITTLE'],
		'I_QUAN_AVERAGE'		=> $arParams['I_QUAN_AVERAGE'],
		'I_VIEW_CATALOG'		=> ( $_COOKIE['I_VIEW_CATALOG'] ) ? ' '.$_COOKIE['I_VIEW_CATALOG'] : ' i_cs_block',
		// iLaB
	),
	$component
);?>
</div>
		<div class="i_cata_pp">
			<span class="i_pp_name"><?=GetMessage('PRODUCTS_PAGE')?>:</span>
			<select class="i_pp_select j_pp_select">
				<option <?if( $count==$arParams['PAGE_ELEMENT_COUNT'] )echo 'selected '?>value="<?=$arParams['PAGE_ELEMENT_COUNT']?>"><?=$arParams['PAGE_ELEMENT_COUNT']?></option>
				<option <?if( $count==($arParams['PAGE_ELEMENT_COUNT']*2) )echo 'selected '?>value="<?=($arParams['PAGE_ELEMENT_COUNT']*2)?>"><?=($arParams['PAGE_ELEMENT_COUNT']*2)?></option>
				<option <?if( $count==($arParams['PAGE_ELEMENT_COUNT']*3) )echo 'selected '?>value="<?=($arParams['PAGE_ELEMENT_COUNT']*3)?>"><?=($arParams['PAGE_ELEMENT_COUNT']*3)?></option>
			</select>
		</div>

<?if ($verticalGrid):?>
	</div>
	</div>
<?endif?>
<?/*
if (\Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
{
	$arRecomData = array();
	$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($recomCacheID), '/sale/bestsellers'))
	{
		$arRecomData = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		if (\Bitrix\Main\Loader::includeModule('catalog'))
		{
			$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
			$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
		}
		$obCache->EndDataCache($arRecomData);
	}
	if (!empty($arRecomData))
	{
		?><?$APPLICATION->IncludeComponent('bitrix:sale.bestsellers', '.default', array(
			'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
			'PAGE_ELEMENT_COUNT' => '4',
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_NAME' => 'Y',
			'SHOW_IMAGE' => 'Y',
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'LINE_ELEMENT_COUNT' => 4,
			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
			'CACHE_TYPE' => $arParams['CACHE_TYPE'],
			'CACHE_TIME' => $arParams['CACHE_TIME'],
			'BY' => array(
				0 => 'AMOUNT',
			),
			'PERIOD' => array(
				0 => '15',
			),
			'FILTER' => array(
				0 => 'CANCELED',
				1 => 'ALLOW_DELIVERY',
				2 => 'PAYED',
				3 => 'DEDUCTED',
				4 => 'N',
				5 => 'P',
				6 => 'F',
			),
			'FILTER_NAME' => $arParams['FILTER_NAME'],
			'ORDER_FILTER_NAME' => 'arOrderFilter',
			'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'PRICE_CODE' => $arParams['PRICE_CODE'],
			'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
			'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
			'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
			'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
			'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
			'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
			'OFFER_TREE_PROPS_'.$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_TREE_PROPS']
		),
		$component
	);
	}
}
*/?>
<?// ---------------------------------------------------------------------------------------------------- iLaB?>
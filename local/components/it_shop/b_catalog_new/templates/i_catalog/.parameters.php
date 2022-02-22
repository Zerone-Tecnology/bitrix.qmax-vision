<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB

use Bitrix\Main\Loader;


if (!Loader::includeModule('iblock'))
	return;

	// Тип инфоблока
$arIBlockType = CIBlockParameters::GetIBlockTypes();
	// Инфоблок
$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array('sort'=>'asc'), Array('TYPE' => $arCurrentValues['REVIEW_IBLOCK_TYPE'], 'ACTIVE'=>'Y'));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];


// Выборка свойст инфоблока каталога товаров
$res = CIBlockProperty::GetList(Array('SORT'=>'ASC', 'NAME'=>'ASC'), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID']));
while ($ob = $res->GetNext())
{
	$pro[$ob['CODE']]	= '['.$ob['ID'].'] '.$ob['NAME'];
	$acco[$ob['CODE']]	= '['.$ob['CODE'].'] '.$ob['NAME'];
}

$arTemplateParameters = array(
	'I_STICKER'					=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_STICKER_NAME'),
		'TYPE'					=> 'LIST',
		'MULTIPLE'				=> 'Y',
		'VALUES'				=> $pro,
		'SIZE'					=> 10
	),
	'I_DEALER_PRICE'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_DEALER_PRICE_NAME'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> 'DEALER_s1'
	),
	'I_COUNT_PRO'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_COUNT_PRO_NAME'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> '5'
	),
	'REVIEW_IBLOCK_TYPE'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('REVIEW_IBLOCK_TYPE'),
		'TYPE'					=> 'LIST',
		'VALUES'				=> $arIBlockType,
		'REFRESH'				=> 'Y'
	),
	'REVIEW_IBLOCK_ID'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('REVIEW_IBLOCK_ID'),
		'TYPE'					=> 'LIST',
		'ADDITIONAL_VALUES'		=> 'Y',
		'VALUES'				=> $arIBlock,
		'REFRESH'				=> 'Y'
	),
	'I_APPROVAL_REVIEWS'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_APPROVAL_REVIEWS'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CHECK_QUANTITY'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_CHECK_QUANTITY'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'Y',
	),
	'I_INSTRUCTION'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_INSTRUCTION'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'Y',
	),
	'I_SWIPER_AUTOPLAY'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_SWIPER_AUTOPLAY'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'Y',
	),
	'I_OFFERS_MORE'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_OFFERS_MORE'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'Y',
	),
	'I_MIN_PUTCHASE_AMOUNT'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_MIN_PUTCHASE_AMOUNT'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> '',
	),
	'I_SHOW_NUMBER'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_SHOW_NUMBER'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_PRICE_MATRIX'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_PRICE_MATRIX'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_SORT_NAME'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_SORT_NAME'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_BREDCRUMBS_HEADER'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_BREDCRUMBS_HEADER'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_PAGE_SECTION_LIST'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_PAGE_SECTION_LIST'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_WATER_MARK_SECTION'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_WATER_MARK_SECTION'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_WATER_MARK_ELEMENT'		=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_WATER_MARK_ELEMENT'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_MAX_PROP_PRICE'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_MAX_PROP_PRICE'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_PROP_PRICE_NAME'			=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_PROP_PRICE_NAME'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_TO_ORDER'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_TO_ORDER'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CB_ATTENTION'			=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CB_ATTENTION'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CB_PREVIEW'				=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CB_PREVIEW'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CB_CHARACTERISTICS'		=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CB_CHARACTERISTICS'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CI_DESCRIPTION'				=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CI_DESCRIPTION'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CI_CHARACTERISTICS'		=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CI_CHARACTERISTICS'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CI_VIDEO'				=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CI_VIDEO'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
	'I_CI_REVIEWS'				=> array(
		'PARENT'				=> 'ILAB_SHOP_CLEAN',
		'NAME'					=> GetMessage('I_CI_REVIEWS'),
		'TYPE'					=> 'CHECKBOX',
		'DEFAULT'				=> 'N',
		'REFRESH'				=> 'N',
	),
);

// ---------------------------------------------------------------------------------------------------- Сортировка типа цены к группе пользователя
$arTemplateParameters['I_SORT_PRICE'] = array(
	'PARENT' => 'ILAB_SHOP_SORT_PRICE',
	'NAME' => GetMessage('I_SORT_PRICE'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y',
);
if( $arCurrentValues['I_SORT_PRICE'] == 'Y' )
{

	if (!Loader::includeModule('catalog'))
		return;

	// Типы цен
	$res = CCatalogGroup::GetList(array('SORT' => 'ASC'));
	$arPriceType = array();
	while ($ob = $res->Fetch())
		$arPriceType[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];
	unset($res,$ob);

	// Группы пользователей
	$res = CGroup::GetList($by = 'c_sort', $order = 'asc', array());
	while($ob = $res->Fetch())
		$arUsersGroups[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];;
	unset($res,$ob);

	$arTemplateParameters['I_SORT_PRICE_DEALER'] = array(
		'PARENT' => 'ILAB_SHOP_SORT_PRICE',
		'NAME' => GetMessage('I_SORT_PRICE_DEALER'),
		'TYPE' => 'LIST',
		'VALUES' => $arUsersGroups,
		'ADDITIONAL_VALUES' => 'Y',
	);

	foreach ($arUsersGroups as $k=>$e)
	{
		$arTemplateParameters['I_SORT_PRICE_TYPE_'.$k] = array(
			'PARENT' => 'ILAB_SHOP_SORT_PRICE',
			'NAME' => GetMessage('I_SORT_PRICE_TYPE').' - '.$e,
			'TYPE' => 'LIST',
			'VALUES' => $arPriceType,
			'ADDITIONAL_VALUES' => 'Y',
		);
	}
}
// ---------------------------------------------------------------------------------------------------- Похожие товары
$arTemplateParameters['I_CHECK_SIMILAR'] = array(
	'PARENT'				=> 'ILAB_SHOP',
	'NAME'					=> GetMessage('I_CHECK_SIMILAR'),
	'TYPE'					=> 'CHECKBOX',
	'DEFAULT'				=> 'N',
	'REFRESH'				=> 'Y',
);
if( $arCurrentValues['I_CHECK_SIMILAR'] == 'Y' )
{
	$arTemplateParameters['I_TITLE_SIMILAR'] = array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_TITLE_SIMILAR'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> 'Похожие товары'
	);
}
// ---------------------------------------------------------------------------------------------------- Сопутствующие товары
$arTemplateParameters['I_CHECK_RELATED']	= array(
	'PARENT'				=> 'ILAB_SHOP',
	'NAME'					=> GetMessage('I_CHECK_RELATED'),
	'TYPE'					=> 'CHECKBOX',
	'DEFAULT'				=> 'N',
	'REFRESH'				=> 'Y',
);
if( $arCurrentValues['I_CHECK_RELATED'] == 'Y' )
{
	$arTemplateParameters['I_TITLE_RELATED'] = array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_TITLE_RELATED'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> 'Сопутствующие товары'
	);
	$arTemplateParameters['I_RELATED'] = array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_RELATED'),
		'TYPE'					=> 'LIST',
		'REFRESH'				=> 'Y',
		'VALUES'				=> $acco,
	);
}
// ---------------------------------------------------------------------------------------------------- QUANTITY
if( $arCurrentValues['I_CHECK_QUANTITY'] == 'Y' )
{
	$arTemplateParameters['I_QUAN_VERY_LITTLE']	= array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_QUAN_VERY_LITTLE'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> '5',
	);
	$arTemplateParameters['I_QUAN_LITTLE']	= array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_QUAN_LITTLE'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> '20',
	);
	$arTemplateParameters['I_QUAN_AVERAGE']	= array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_QUAN_AVERAGE'),
		'TYPE'					=> 'STRING',
		'DEFAULT'				=> '50',
	);
}
// ---------------------------------------------------------------------------------------------------- iLaB/Bitrix SKU
if (!CModule::IncludeModule('iblock'))
	return;
$boolCatalog = CModule::IncludeModule('catalog');

$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
}

if ($boolSKU && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])) )
{
//		$arAllOfferPropList['-'] = GetMessage('CP_BCE_TPL_PROP_EMPTY');
		$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
		);
		while ($arProp = $rsProps->Fetch())
		{
			if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;

			$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];

			$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];

			if ('' == $arProp['CODE'])
				$arProp['CODE'] = $arProp['ID'];

			$arAllOfferPropList[$arProp['CODE']] = $strPropName;
		}
		$arTemplateParameters['I_CHECK_OFFERS']		= array(
			'PARENT'				=> 'ILAB_SHOP',
			'NAME'					=> GetMessage('I_CHECK_OFFERS'),
			'TYPE'					=> 'CHECKBOX',
			'DEFAULT'				=> 'N',
		);
		$arTemplateParameters['I_OFFER_TREE_PROPS'] = array(
			'PARENT'				=> 'ILAB_SHOP',
			'NAME'					=> GetMessage('CP_BCE_TPL_OFFER_TREE_PROPS'),
			'TYPE'					=> 'LIST',
			'MULTIPLE'				=> 'Y',
			'VALUES'				=> $arAllOfferPropList
		);
		$arTemplateParameters['I_IBLOCK_OFFERS'] = array(
			'PARENT'				=> 'ILAB_SHOP',
			'NAME'					=> GetMessage('I_IBLOCK_OFFERS'),
			'TYPE'					=> 'STRING',
			'DEFAULT'				=> $arSKU['IBLOCK_ID']
		);
		$arTemplateParameters['I_OFFER_TREE_IMG'] = array(
			'PARENT'				=> 'ILAB_SHOP',
			'NAME'					=> GetMessage('I_OFFER_TREE_IMG'),
			'TYPE'					=> 'LIST',
			'VALUES'				=> $arAllOfferPropList
		);
}
// ---------------------------------------------------------------------------------------------------- iLaB/Bitrix SKU?>
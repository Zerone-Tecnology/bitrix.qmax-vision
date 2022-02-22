<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( !\Bitrix\Main\Loader::includeModule('iblock') || !$boolCatalog = \Bitrix\Main\Loader::includeModule('catalog') )
	return;

	// Тип инфоблока
$arIBlockType = CIBlockParameters::GetIBlockTypes();
	// Инфоблок
$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array('sort'=>'asc'), Array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE'=>'Y'));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];

// Тип цены
$res = CCatalogGroup::GetList(array('SORT'=>'ASC'));
while ($ob = $res->Fetch())
	$arPrice[$ob['NAME']] = '['.$ob['NAME'].'] '.$ob['NAME_LANG'];

$pro = array();// Выборка свойст инфоблока каталога товаров
$res = CIBlockProperty::GetList(Array('SORT'=>'ASC', 'NAME'=>'ASC'), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID']));
while ($ob = $res->GetNext())
	$pro[$ob['CODE']] = '['.$ob['ID'].'] '.$ob['NAME'];

$sec = array();// Исключить разделы из меню
$res = CIBlockSection::GetList(Array('SORT'=>'ASC', 'NAME'=>'ASC'), Array('ACTIVE'=>'Y', 'DEPTH_LEVEL'=>1, 'IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID']));
while ($ob = $res->GetNext())
	$sec[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];

$arComponentParameters['GROUPS'] = array(
	'ILAB_SHOP' => array(
		'NAME' => GetMessage('ILAB_SHOP'),
	)
);

$arComponentParameters = array(
	'GROUPS' => array(
		'ILAB_SHOP' => array(
			'NAME' => GetMessage('ILAB_SHOP'),
		)
	),
	'PARAMETERS' => array(
		'IBLOCK_TYPE'			=> array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('IBLOCK_TYPE'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> $arIBlockType,
			'REFRESH'			=> 'Y'
		),
		'IBLOCK_ID'				=> array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('IBLOCK_ID'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arIBlock,
			'REFRESH'			=> 'Y'
		),
		'I_DEPTH_LEVEL'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_DEPTH_LEVEL'),
			'TYPE'				=> 'STRING',
			'DEFAULT'			=> '3'
		),
		'I_PRICE_CODE'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_PRICE_CODE'),
			'TYPE'				=> 'LIST',
			'MULTIPLE'			=> 'Y',
			'VALUES'			=> $arPrice
		),
		'I_STICKER'				=>array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_STICKER_NAME'),
			'TYPE'				=> 'LIST',
			'MULTIPLE'			=> 'Y',
			'VALUES'			=> $pro,
			'SIZE'				=> 10
		),
		'I_DIR'					=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_DIR'),
			'TYPE'				=> 'TRING',
			'DEFAULT'			=> '={$APPLICATION->GetCurDir()}',
		),
		'I_HIDE_MENU'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_HIDE_MENU'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_NUMBER_ELEMENT_1LVL'	=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NUMBER_ELEMENT_1LVL'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_NUMBER_ELEMENT_NLVL'	=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NUMBER_ELEMENT_NLVL'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_MENU_EXTENSION'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_MENU_EXTENSION'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_MENU_ICON_TOP'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_MENU_ICON_TOP'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_MENU_LINE'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_MENU_LINE'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_COLOR_SCHEME'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_COLOR_SCHEME'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_REVERSE_IMAGE'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_REVERSE_IMAGE'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_SHOW_SECT_MENU'		=>array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_SHOW_SECT_MENU'),
			'TYPE'				=> 'LIST',
			'REFRESH'			=> 'Y',
			'MULTIPLE'			=> 'Y',
			'VALUES'			=> $sec,
			'SIZE'				=> 10
		),
		'I_REMOVE_ICON'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_REMOVE_ICON'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_MAX_PROP_PRICE'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_MAX_PROP_PRICE'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
			'REFRESH'			=> 'N',
		),
		'I_COUNT_COL'           => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_COUNT_COL'),
			'TYPE'				=> 'STRING',
			'DEFAULT'			=> 3,
		),
		'I_MOBILE_ICON'         => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_MOBILE_ICON'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> array(
									'I_IMG' => 'Картина по умолчанию',
									'I_WHITE' => 'Белая картина',
								),
		),
		'I_VIEW'				=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_VIEW'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'N',
			'MULTIPLE'			=> 'N',
			'VALUES'			=> array(
									'i_v_menu_half'			=> 'Полускрытое меню(главная)',
									'i_v_menu_open'			=> 'Раскрытое меню(каталог)',
									'i_v_menu_hidden'		=> 'Скрытое меню(остальные разделы)',
								),
			'DEFAULT'			=> 'i_v_menu_half',
		),
		'CACHE_TIME' 			=> array()// Cache
	)
);

if ($boolCatalog)
{

	$arComponentParameters['PARAMETERS']['CONVERT_CURRENCY'] = array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('CP_BCS_CONVERT_CURRENCY'),
		'TYPE'		=> 'CHECKBOX',
		'DEFAULT'	=> 'N',
		'REFRESH'	=> 'Y'
	);
	$arComponentParameters['PARAMETERS']['SHOW_PRICE_COUNT'] = array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('IBLOCK_SHOW_PRICE_COUNT'),
		'TYPE'		=> 'STRING',
		'DEFAULT'	=> '1',
	);

	if (isset($arCurrentValues['CONVERT_CURRENCY']) && 'Y' == $arCurrentValues['CONVERT_CURRENCY'])
	{
		$arCurrencyList	= array();
		$by				= 'SORT';
		$order			= 'ASC';

		$rsCurrencies = CCurrency::GetList($by, $order);
		while ($arCurrency = $rsCurrencies->Fetch())
			$arCurrencyList[$arCurrency['CURRENCY']] = $arCurrency['CURRENCY'];

		$arComponentParameters['PARAMETERS']['CURRENCY_ID'] = array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('CP_BCS_CURRENCY_ID'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> $arCurrencyList,
			'DEFAULT'			=> CCurrency::GetBaseCurrency(),
			'ADDITIONAL_VALUES'	=> 'Y'
		);
	}
}
// ---------------------------------------------------------------------------------------------------- iLaB?>
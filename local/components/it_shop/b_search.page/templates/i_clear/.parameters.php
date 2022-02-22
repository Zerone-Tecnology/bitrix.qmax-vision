<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arTemplateParameters = array(
	"USE_SUGGEST" => Array(
		"NAME" => GetMessage("TP_BSP_USE_SUGGEST"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"SHOW_ITEM_TAGS" => array(
		"NAME" => GetMessage("TP_BSP_SHOW_ITEM_TAGS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"REFRESH" => "Y",
	),
	"TAGS_INHERIT" => array(
		"NAME" => GetMessage("TP_BSP_TAGS_INHERIT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SHOW_ITEM_DATE_CHANGE" => array(
		"NAME" => GetMessage("TP_BSP_SHOW_ITEM_DATE_CHANGE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SHOW_ORDER_BY" => array(
		"NAME" => GetMessage("TP_BSP_SHOW_ORDER_BY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SHOW_TAGS_CLOUD" => array(
		"NAME" => GetMessage("TP_BSP_SHOW_TAGS_CLOUD"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	),
);

if($arCurrentValues["SHOW_ITEM_TAGS"] == "N")
	unset($arTemplateParameters["TAGS_INHERIT"]);

if($arCurrentValues["SHOW_TAGS_CLOUD"] == "Y")
{
	$arTemplateParameters = array_merge($arTemplateParameters, array(
		"SHOW_TAGS_CLOUD" => array(
			"NAME" => GetMessage("TP_BSP_SHOW_TAGS_CLOUD"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"TAGS_SORT" => array(
			"NAME" => GetMessage("TP_BSP_SORT"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => array("NAME"=>GetMessage("TP_BSP_NAME"), "CNT"=>GetMessage("TP_BSP_CNT")),
			"DEFAULT" => "NAME",
		),
		"TAGS_PAGE_ELEMENTS" => array(
			"NAME" => GetMessage("TP_BSP_PAGE_ELEMENTS"),
			"TYPE" => "STRING",
			"DEFAULT" => "150",
		),
		"TAGS_PERIOD" => array(
			"NAME" => GetMessage("TP_BSP_PERIOD"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"TAGS_URL_SEARCH" => array(
			"NAME" => GetMessage("TP_BSP_URL_SEARCH"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"TAGS_INHERIT" => array(
			"NAME" => GetMessage("TP_BSP_TAGS_INHERIT"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"DEFAULT" => "Y",
		),
		"FONT_MAX" => array(
			"NAME" => GetMessage("TP_BSP_FONT_MAX"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "50",
		),
		"FONT_MIN" => array(
			"NAME" => GetMessage("TP_BSP_FONT_MIN"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "10",
		),
		"COLOR_NEW" => array(
			"NAME" => GetMessage("TP_BSP_COLOR_NEW"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "000000",
		),
		"COLOR_OLD" => array(
			"NAME" => GetMessage("TP_BSP_COLOR_OLD"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "C8C8C8",
		),
		"PERIOD_NEW_TAGS" => array(
			"NAME" => GetMessage("TP_BSP_PERIOD_NEW_TAGS"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "",
		),
		"SHOW_CHAIN" => array(
			"NAME" => GetMessage("TP_BSP_SHOW_CHAIN"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"DEFAULT" => "Y",
		),
		"COLOR_TYPE" => array(
			"NAME" => GetMessage("TP_BSP_COLOR_TYPE"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"DEFAULT" => "Y",
		),
		"WIDTH" => array(
			"NAME" => GetMessage("TP_BSP_WIDTH"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "100%",
		),
	));
}

if(COption::GetOptionString("search", "use_social_rating") == "Y")
{
	$arTemplateParameters["SHOW_RATING"] = Array(
		"NAME" => GetMessage("TP_BSP_SHOW_RATING"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"" => GetMessage("TP_BSP_SHOW_RATING_CONFIG"),
			"Y" => GetMessage("MAIN_YES"),
			"N" => GetMessage("MAIN_NO"),
		),
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	);
	$arTemplateParameters["RATING_TYPE"] = Array(
		"NAME" => GetMessage("TP_BSP_RATING_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"" => GetMessage("TP_BSP_RATING_TYPE_CONFIG"),
			"like" => GetMessage("TP_BSP_RATING_TYPE_LIKE_TEXT"),
			"like_graphic" => GetMessage("TP_BSP_RATING_TYPE_LIKE_GRAPHIC"),
			"standart_text" => GetMessage("TP_BSP_RATING_TYPE_STANDART_TEXT"),
			"standart" => GetMessage("TP_BSP_RATING_TYPE_STANDART_GRAPHIC"),
		),
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	);
	$arTemplateParameters["PATH_TO_USER_PROFILE"] = Array(
		"NAME" => GetMessage("TP_BSP_PATH_TO_USER_PROFILE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

// ---------------------------------------------------------------------------------------------------- iLaB
if( !\Bitrix\Main\Loader::includeModule('iblock') || !$boolCatalog = \Bitrix\Main\Loader::includeModule('catalog') )
	return;

if ($boolCatalog)
{

	$arTemplateParameters['CONVERT_CURRENCY'] = array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('CP_BCS_CONVERT_CURRENCY'),
		'TYPE'		=> 'CHECKBOX',
		'DEFAULT'	=> 'N',
		'REFRESH'	=> 'Y'
	);

	// Тип цены
	$res = CCatalogGroup::GetList(array('SORT'=>'ASC'));
	while ($ob = $res->Fetch())
		$arPrice[$ob['NAME']] = '['.$ob['NAME'].'] '.$ob['NAME_LANG'];

	$arTemplateParameters['I_PRICE_CODE'] = array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_PRICE_CODE'),
			'TYPE'				=> 'LIST',
			'MULTIPLE'			=> 'Y',
			'VALUES'			=> $arPrice
	);

	if (isset($arCurrentValues['CONVERT_CURRENCY']) && 'Y' == $arCurrentValues['CONVERT_CURRENCY'])
	{
		$arCurrencyList	= array();
		$by				= 'SORT';
		$order			= 'ASC';

		$rsCurrencies = CCurrency::GetList($by, $order);
		while ($arCurrency = $rsCurrencies->Fetch())
			$arCurrencyList[$arCurrency['CURRENCY']] = $arCurrency['CURRENCY'];

		$arTemplateParameters['CURRENCY_ID'] = array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('CP_BCS_CURRENCY_ID'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> $arCurrencyList,
			'DEFAULT'			=> CCurrency::GetBaseCurrency(),
			'ADDITIONAL_VALUES'	=> 'Y'
		);
	}
}
?>

<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
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

	$arTemplateParameters['I_UNITS'] = array(
		'PARENT'			=> 'ILAB_SHOP',
		'NAME'				=> GetMessage('I_UNITS'),
		'TYPE'				=> 'STRING',
		'DEFAULT'			=> ''
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
// ---------------------------------------------------------------------------------------------------- iLaB?>
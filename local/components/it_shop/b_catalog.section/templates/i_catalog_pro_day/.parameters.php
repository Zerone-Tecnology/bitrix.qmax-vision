<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB
use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
	return;

// Выборка свойст инфоблока каталога товаров
$res = CIBlockProperty::GetList(Array('SORT'=>'ASC', 'NAME'=>'ASC'), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID']));
while ($ob = $res->GetNext())
	$pro[$ob['CODE']]	= '['.$ob['CODE'].'] '.$ob['NAME'];

$arTemplateParameters = array(
	'I_PICK'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_PICK'),
		'TYPE'					=> 'LIST',
		'ADDITIONAL_VALUES'		=> 'N',
		'MULTIPLE'				=> 'N',
		'VALUES'				=> $pro,
	),
	'I_WATER_MARK'				=> array(
		'PARENT'				=> 'ILAB_SHOP',
		'NAME'					=> GetMessage('I_WATER_MARK'),
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
	)
);
// ---------------------------------------------------------------------------------------------------- iLaB?>
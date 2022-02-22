<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB

if( !CModule::IncludeModule('iblock') )
	return;

// Выборка свойст инфоблока каталога товаров
$res = CIBlockProperty::GetList(Array('SORT'=>'ASC', 'NAME'=>'ASC'), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID']));
while ($ob = $res->GetNext())
	$pro[$ob['CODE']] = '['.$ob['ID'].'] '.$ob['NAME'];

$arTemplateParameters = array(
	'I_STICKER'		=> array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('I_STICKER_NAME'),
		'TYPE'		=> 'LIST',
		'MULTIPLE'	=> 'Y',
		'VALUES'	=> $pro,
		'SIZE'		=> 10
	),
	'I_DEALER_PRICE'=> array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('I_DEALER_PRICE_NAME'),
		'TYPE'		=> 'STRING',
		'DEFAULT'	=> 'DEALER_s1'
	),
	'I_COUNT_PRO'	=> array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('I_COUNT_PRO_NAME'),
		'TYPE'		=> 'STRING',
		'DEFAULT'	=> '5'
	),
	'I_SHOW_NUMBER'	=> array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('I_SHOW_NUMBER'),
		'TYPE'		=> 'CHECKBOX',
		'DEFAULT'	=> 'N',
		'REFRESH'	=> 'N',
	),
	'I_PRICE_MATRIX'=> array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('I_PRICE_MATRIX'),
		'TYPE'		=> 'CHECKBOX',
		'DEFAULT'	=> 'N',
		'REFRESH'	=> 'N',
	),
	'I_WATER_MARK'	=> array(
		'PARENT'	=> 'ILAB_SHOP',
		'NAME'		=> GetMessage('I_WATER_MARK'),
		'TYPE'		=> 'CHECKBOX',
		'DEFAULT'	=> 'N',
		'REFRESH'	=> 'N',
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
<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( !CModule::IncludeModule('iblock') )
	return;

	// Тип инфоблока
$arIBlockType = CIBlockParameters::GetIBlockTypes();
	// Инфоблок
$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array('sort'=>'asc'), Array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE'=>'Y'));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
/*
	// Свойства
$arProperty = array();
if (0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$rsProp = CIBlockProperty::GetList(array('sort'=>'asc', 'name'=>'asc'), array('IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID'], 'ACTIVE'=>'Y'));
	while ($arr=$rsProp->Fetch())
		if($arr['PROPERTY_TYPE'] != 'F')
			$arProperty[$arr['CODE']] = '['.$arr['CODE'].'] '.$arr['NAME'];

	$rsSect = CIBlockSection::GetList(Array('SORT'=>'ASC'), array('IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID'], 'ACTIVE'=>'Y'));
	while($ob = $rsSect->Fetch())
		$arSection[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];
}*/
$arComponentParameters = array(
	'GROUPS' => array(
		'ILAB_SHOP' => array(
			'NAME' => GetMessage('ILAB_SHOP'),
		)
	),
	// Parameters
	'PARAMETERS' => array(
		'IBLOCK_TYPE'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('IBLOCK_TYPE'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> $arIBlockType,
			'REFRESH'			=> 'Y'
		),
		'IBLOCK_ID_1'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('IBLOCK_ID_1'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arIBlock,
			'REFRESH'			=> 'Y'
		),
		'IBLOCK_ID_2'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('IBLOCK_ID_2'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arIBlock,
			'REFRESH'			=> 'Y'
		),
		'I_COUNT_NEWS'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_COUNT_NEWS'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_COUNT_ACTIONS'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_COUNT_ACTIONS'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_NAME_NEWS_RU'        => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NAME_NEWS_RU'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_NAME_NEWS_KZ'        => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NAME_NEWS_KZ'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_NAME_NEWS_EN'        => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NAME_NEWS_EN'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_NAME_ACTIONS_RU'        => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NAME_ACTIONS_RU'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_NAME_ACTIONS_KZ'        => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NAME_ACTIONS_KZ'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'I_NAME_ACTIONS_EN'        => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_NAME_ACTIONS_EN'),
			'TYPE'				=> 'STRING',
			'VALUES'			=> ''
		),
		'CACHE_TIME' => array(),// Cache
	)
);
// ---------------------------------------------------------------------------------------------------- iLaB?>
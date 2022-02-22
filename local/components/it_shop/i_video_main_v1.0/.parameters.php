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

$arComponentParameters = array(
	// Parameters
	'PARAMETERS' => array(
		'IBLOCK_TYPE'		=> array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('IBLOCK_TYPE'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> $arIBlockType,
			'REFRESH'			=> 'Y'
		),
		'IBLOCK_ID'			=> array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('IBLOCK_ID'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arIBlock,
			'REFRESH'			=> 'Y'
		),
		'ACTIVE_DATE_FORMAT'	=> CIBlockParameters::GetDateFormat(GetMessage('T_IBLOCK_DESC_ACTIVE_DATE_FORMAT'), 'BASE'),
		'CACHE_TIME' => array()// Cache
	)
);
// ---------------------------------------------------------------------------------------------------- iLaB?>
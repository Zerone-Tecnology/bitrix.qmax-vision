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
}
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
		'IBLOCK_ID'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('IBLOCK_ID'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arIBlock,
			'REFRESH'			=> 'Y'
		),
		'SECTION_ID'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('SECTION_ID'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arSection,
			'REFRESH'			=> 'Y'
		),
		'PROPERTY_CODE'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('IBLOCK_PROPERTY'),
			'TYPE'				=> 'LIST',
			'MULTIPLE'			=> 'Y',
			'VALUES'			=> $arProperty,
			'ADDITIONAL_VALUES'	=> 'Y',
		),
		'I_LIMIT_TEASER'	=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_LIMIT_TEASER'),
			'TYPE'				=> 'STRING',
			'DEFAULT'			=> ''
		),
		'I_POINT'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_POINT'),
			'TYPE'				=> 'STRING',
			'DEFAULT'			=> ''
		),
		'I_RAND_ONE'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_RAND_ONE'),
			'TYPE'				=> 'CHECKBOX',
			'DEFAULT'			=> 'N',
		),
		'I_TITLE'			=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_TITLE'),
			'TYPE'				=> 'STRING',
			'DEFAULT'			=> 'Специальные предложения'
		),
		'I_TITLE_LINK'		=> array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_TITLE_LINK'),
			'TYPE'				=> 'STRING',
			'DEFAULT'			=> '/'
		),
		'CACHE_TIME' => array(),// Cache
	)
);
// ---------------------------------------------------------------------------------------------------- iLaB?>
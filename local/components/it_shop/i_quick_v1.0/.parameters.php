<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( !CModule::IncludeModule('iblock') || !CModule::IncludeModule('catalog') || !CModule::IncludeModule('sale') )
	return;

// Типы плательщиков
$res = CSalePersonType::GetList(Array('SORT'=>'ASC'), Array('ACTIVE'=>'Y'));
while($ob = $res->GetNext())
{
//	$arResult[] = $ob;
	$arPerson[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];
}

// Платёжные системы
$res = CSalePaySystemAction::GetList(
	array('SORT'=>'ASC'),
	array('PS_ACTIVE'=>'Y'),
	false,
	false,
	array('ID', 'PAY_SYSTEM_ID', 'PERSON_TYPE_ID', 'NAME', 'ACTION_FILE', 'RESULT_FILE', 'NEW_WINDOW', 'PARAMS', 'ENCODING', 'LOGOTIP')
);
while($ob = $res->Fetch())
{
//	$arResult[] = $ob;
	$arPaySystem[$ob['PAY_SYSTEM_ID']] = '['.$ob['PAY_SYSTEM_ID'].'] '.$ob['NAME'];
}

// Настраиваемые Службы доставки
$res = CSaleDelivery::GetList(
	array('SORT' => 'ASC'),
	array('ACTIVE' => 'Y'),
	false,
	false,
	array()
);
while ($ob = $res->GetNext())
{
//	$arResult[] = $ob;
	$arDelivery[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];
}

	// Тип инфоблока
$arIBlockType = CIBlockParameters::GetIBlockTypes();
	// Инфоблок
$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array('sort'=>'asc'), Array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE'=>'Y'));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
	// Элементы
$arSections = array();
if (0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$res = CIBlockSection::GetList(Array('SORT'=>'ASC', 'NAME'=>'ASC'), array('IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID'], 'ACTIVE'=>'Y'));
	while($ob = $res->Fetch())
		$arSections[$ob['ID']] = '['.$ob['ID'].'] '.$ob['NAME'];
}

$arComponentParameters = array(
	'GROUPS'	=> array(
		'ILAB_SHOP' => array(
			'NAME' => GetMessage('ILAB_SHOP'),
		)
	),
	// Parameters
	'PARAMETERS' => array(
		'IBLOCK_TYPE' => array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('F_IBLOCK_TYPE'),
			'TYPE'				=> 'LIST',
			'VALUES'			=> $arIBlockType,
			'REFRESH'			=> 'Y'
		),
		'IBLOCK_ID' => array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('F_IBLOCK_ID'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arIBlock,
			'REFRESH'			=> 'Y'
		),
		'FORM_ID'				=> array(
			'PARENT'			=> 'BASE',
			'NAME'				=> GetMessage('FORM'),
			'TYPE'				=> 'LIST',
			'MULTIPLE'			=> 'N',
			'VALUES'			=> $arSections,
			'ADDITIONAL_VALUES'	=> 'Y',
		),
		'I_PERSON' => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_PERSON'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arPerson,
			'REFRESH'			=> 'Y',
			'DEFAULT'			=> 1,
		),
		'I_PAY_SYSTEM' => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_PAY_SYSTEM'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arPaySystem,
			'REFRESH'			=> 'Y',
			'DEFAULT'			=> 1,
		),
		'I_DELIVERY' => array(
			'PARENT'			=> 'ILAB_SHOP',
			'NAME'				=> GetMessage('I_DELIVERY'),
			'TYPE'				=> 'LIST',
			'ADDITIONAL_VALUES'	=> 'Y',
			'VALUES'			=> $arDelivery,
			'REFRESH'			=> 'Y',
			'DEFAULT'			=> 1,
		),
		'CACHE_TIME' => array(),// Cache
	),
);
// ---------------------------------------------------------------------------------------------------- iLaB?>
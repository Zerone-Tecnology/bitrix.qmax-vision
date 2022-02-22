<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB

use Bitrix\Iblock;
if( !Bitrix\Main\Loader::includeModule('iblock') )
	return;

$arProperty = array();

$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

if ($iblockExists)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=PROPERTY_TYPE' => Iblock\PropertyTable::TYPE_FILE),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];
		if ($propertyCode == '')
			$propertyCode = $property['ID'];
		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		$arProperty[$propertyCode] = $propertyName;
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);
}

$arTemplateParameters = array(
	'I_PROPERTY_CODE'	=> array(
		'PARENT'			=> 'ILAB_SHOP',
		'NAME'				=> GetMessage('I_PROPERTY_CODE'),
		'TYPE'				=> 'LIST',
		'MULTIPLE'			=> 'Y',
		'VALUES'			=> $arProperty,
		'ADDITIONAL_VALUES'	=> 'Y',
		'REFRESH'			=> 'Y',
	)
);
$arTemplateParameters['PROPERTY_CODE'] = false;// unset PROPERTY_CODE
// ---------------------------------------------------------------------------------------------------- iLaB?>

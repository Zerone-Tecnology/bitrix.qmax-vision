<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/* О нет... там прямые запросы в базу.. Бегите глупцы... © ilab */
// ---------------------------------------------------------------------------------------------------- iLaB
if ($this->StartResultCache(false, false))
{
	if( !CModule::IncludeModule('iblock') )
		return;

	$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'PROPERTY_SHOW_MAIN_VALUE'=>'Y', 'ACTIVE'=>'Y');

	if( $arParams['SECTION_ID'] )
		$arFilter['SECTION_ID'] = $arParams['SECTION_ID'];

	$res = CIBlockElement::GetList(Array('RAND'=>'ASC'), $arFilter, false);
	while($obj = $res->GetNextElement())
	{
		$ob = $obj->GetFields();
		$ob['PRO'] = $obj->GetProperties();
		$ob['PREVIEW_PICTURE'] = CFile::GetPath($ob['PREVIEW_PICTURE']);

		$arButtons = CIBlock::GetPanelButtons(
			$ob['IBLOCK_ID'],
			$ob['ID'],
			$arResult['ID'],
			array('SECTION_BUTTONS'=>false, 'SESSID'=>false, 'CATALOG'=>true)
		);
		$ob['EDIT_LINK'] = $arButtons['edit']['edit_element']['ACTION_URL'];
		$ob['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];

		// Дата
		if(strlen($ob['ACTIVE_FROM'])>0)
			$ob['DISPLAY_ACTIVE_FROM'] = CIBlockFormatProperties::DateFormat($arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($ob['ACTIVE_FROM'], CSite::GetDateFormat()));
		else
			$ob['DISPLAY_ACTIVE_FROM'] = '';

		$arResult['ITEMS'][] = $ob;
	}

	$this->IncludeComponentTemplate();
}
// ---------------------------------------------------------------------------------------------------- iLaB
/*
	$arSelect = Array('ID', 'NAME', 'IBLOCK_SECTION_ID');
	$arFilter = Array('IBLOCK_ID'=>$arParams[''], 'ACTIVE'=>'Y');
	$res = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, false, $arSelect);
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{

		$obj = $ob->GetFields();
		$obj['PRO'] = $ob->GetProperties();

		$arButtons = CIBlock::GetPanelButtons(
			$obj['IBLOCK_ID'],
			$obj['ID'],
			$arResult['ID'],
			array('SECTION_BUTTONS'=>false, 'SESSID'=>false, 'CATALOG'=>true)
		);
		$obj['EDIT_LINK'] = $arButtons['edit']['edit_element']['ACTION_URL'];
		$obj['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];
	}

	$arParams['']
	$arResult['']
*/
// ---------------------------------------------------------------------------------------------------- iLaB?>
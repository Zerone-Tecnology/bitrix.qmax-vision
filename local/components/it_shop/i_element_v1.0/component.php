<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/* О нет... там прямые запросы в базу.. Бегите глупцы... © ilab */
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arParams['I_RAND_ONE']=='Y' )
	$arParams['CACHE_TIME'] = 180;

if ($this->StartResultCache(false, $arParams['CACHE_GROUPS']==='N'? false: $USER->GetGroups()))
{
	if( !CModule::IncludeModule('iblock') )
		return;

	$arSort		= Array('SORT'=>'ASC');
	$arFilter	= Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ACTIVE'=>'Y');
	$arNav		= Array();

	if( $arParams['SECTION_ID'] )
		$arFilter['SECTION_ID'] = $arParams['SECTION_ID'];

	if( $arParams['I_RAND_ONE']=='Y' )
	{
		$arSort					= Array('RAND'=>'ASC');
		$arNav['nTopCount']		= 1;
	}

	$res = CIBlockElement::GetList($arSort, $arFilter, false, $arNav);
	while($ob = $res->GetNextElement())
	{
		$ob_do = $ob->GetFields();
		$ob_do['PRO'] = $ob->GetProperties();
		$ob_do['PREVIEW_PICTURE'] = CFile::GetPath($ob_do['PREVIEW_PICTURE']);
		$ob_do['DETAIL_PICTURE'] = CFile::GetPath($ob_do['DETAIL_PICTURE']);

		if( $arParams['PROPERTY_CODE'] )
			foreach($arParams['PROPERTY_CODE'] as $pid)// PROPERTY
			{
				if (!isset($ob_do['PRO'][$pid]))
					continue;
				$prop = $ob_do['PRO'][$pid];
				$boolArr = is_array($prop['VALUE']);
				if(
					($boolArr && !empty($prop['VALUE']))
					|| (!$boolArr && strlen($prop['VALUE']) > 0)
				)
				{
					$ob_do['D_PRO'][$pid] = CIBlockFormatProperties::GetDisplayValue($ob, $prop, 'i_element_v1.0_out');
				}
			}

		$arButtons = CIBlock::GetPanelButtons(
			$ob_do['IBLOCK_ID'],
			$ob_do['ID'],
			$arResult['ID'],
			array('SECTION_BUTTONS'=>false, 'SESSID'=>false, 'CATALOG'=>true)
		);
		$ob_do['EDIT_LINK']		= $arButtons['edit']['edit_element']['ACTION_URL'];
		$ob_do['DELETE_LINK']	= $arButtons['edit']['delete_element']['ACTION_URL'];

		$arResult['ITEMS'][]	= $ob_do;
	}

	
	$this->IncludeComponentTemplate();
	return $arResult;
}
// ---------------------------------------------------------------------------------------------------- iLaB
/*
	$arSelect = Array('ID', 'NAME', 'IBLOCK_SECTION_ID');
	$arFilter = Array('IBLOCK_ID'=>$arParams[''], 'ACTIVE'=>'Y');
	$res = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, false, $arSelect);
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{

		$ob_do = $ob->GetFields();
		$ob_do['PRO'] = $ob->GetProperties();

		$arButtons = CIBlock::GetPanelButtons(
			$ob_do['IBLOCK_ID'],
			$ob_do['ID'],
			$arResult['ID'],
			array('SECTION_BUTTONS'=>false, 'SESSID'=>false, 'CATALOG'=>true)
		);
		$ob_do['EDIT_LINK'] = $arButtons['edit']['edit_element']['ACTION_URL'];
		$ob_do['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];
	}

	$arParams['']
	$arResult['']
*/
// ---------------------------------------------------------------------------------------------------- iLaB?>
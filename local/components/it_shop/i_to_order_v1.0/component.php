<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/* О нет... там прямые запросы в базу © ilab */
// ---------------------------------------------------------------------------------------------------- iLaB
if ($this->StartResultCache(false, $arParams['CACHE_GROUPS']==='N'? false: $USER->GetGroups()))
{
	$res = CIBlockSection::GetByID($arParams['FORM_ID']);
	if($ob = $res->GetNext())
		$arResult['I_SECTION'] = $ob;

	$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'SECTION_ID'=>$arParams['FORM_ID'], 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
	while($ob = $res->GetNextElement())
	{
		$ob_do = $ob->GetFields();
		$ob_do['PRO'] = $ob->GetProperties();
		unset($option);
		unset($required);

		$arResult['I_ITEMS'][$ob_do['ID']] = array(
			'NAME'				=> $ob_do['NAME'],
			'REQUIRED'			=> $ob_do['PRO']['REQUIRED']['VALUE'],
			'ATTRIBUTE_NAME'	=> $ob_do['PRO']['ATTRIBUTE_NAME']['VALUE'],
			'FIELDS'			=> $ob_do['PRO']['FIELDS']['VALUE'],
			'TYPE'				=> $ob_do['PRO']['TYPE']['VALUE']
		);

		if($ob_do['PRO']['REQUIRED']['VALUE'])
			$required = ' jq_required="Y"';

		if( $ob_do['PRO']['TYPE']['VALUE'] == ('text' || 'radio' || 'checkbox' || 'file' || 'email' || 'url' || 'password' || 'hidden') )// == input'ы
			$arResult['I_ITEMS'][$ob_do['ID']]['HTML_VALUE'] = '<input'.$required.' jqfields="Y" type="'.$ob_do['PRO']['TYPE']['VALUE'].'" value="" name="'.$ob_do['PRO']['ATTRIBUTE_NAME']['VALUE'].'">';
		elseif( $ob_do['PRO']['TYPE']['VALUE'] == 'textarea' )// == textarea
			$arResult['I_ITEMS'][$ob_do['ID']]['HTML_VALUE'] = '<textarea'.$required.' jqfields="Y" name="'.$ob_do['PRO']['ATTRIBUTE_NAME']['VALUE'].'"></textarea>';
		elseif( $ob_do['PRO']['TYPE']['VALUE'] == 'dropdown' && $ob_do['PRO']['FIELDS']['VALUE'] ){// == dropdown
			foreach($ob_do['PRO']['FIELDS']['VALUE'] as $e)
				$option .= '<option value="'.$e.'">'.$e.'</option>';
			$arResult['I_ITEMS'][$ob_do['ID']]['HTML_VALUE'] = '<select'.$required.' jqfields="Y" name="'.$ob_do['PRO']['ATTRIBUTE_NAME']['VALUE'].'">'.$option.'</select>';
		}elseif( $ob_do['PRO']['TYPE']['VALUE'] == 'multiselect' ){// == multiselect
			foreach($ob_do['PRO']['FIELDS']['VALUE'] as $e)
				$option .= '<option value="'.$e.'">'.$e.'</option>';
			$arResult['I_ITEMS'][$ob_do['ID']]['HTML_VALUE'] = '<select'.$required.' jqfields="Y" name="'.$ob_do['PRO']['ATTRIBUTE_NAME']['VALUE'].'"></select>';
		}

		$arResult['ITEMS'][$ob_do['ID']] = $ob_do;
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
<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/* О нет... там прямые запросы в базу.. Бегите глупцы... © ilab */
// ---------------------------------------------------------------------------------------------------- iLaB

if ($this->StartResultCache(false, $arParams['CACHE_GROUPS']==='N'? false: $USER->GetGroups()))
{
	if( !CModule::IncludeModule('iblock') )
		return;

	$arOrder = Array(
		'ACTIVE_FROM' => 'DESC',
		'SORT' => 'ASC'
	);
	$arFilter1 = Array(
		'ACTIVE'    => 'Y',
		'ACTIVE_DATE' => 'Y',
		'IBLOCK_ID' => $arParams['IBLOCK_ID_1'], // Obligatorily, if you need custom properties
	);
	$arFilter2 = Array(
		'ACTIVE'    => 'Y',
		'ACTIVE_DATE' => 'Y',
		'IBLOCK_ID' => $arParams['IBLOCK_ID_2'], // Obligatorily, if you need custom properties
	);

	$arSelect = Array(
		'NAME',
		'PROPERTY_*'
	);

	// Code validation
	$count1 = (int) $arParams['I_COUNT_NEWS'];
	if(!is_int($count1) || $count1 > 5)
	{
		$arParams['I_COUNT_NEWS'] = 5;
	}
	$count2 = (int) $arParams['I_COUNT_ACTIONS'];
	if(!is_int($count2) || $count2 > 5)
	{
		$arParams['I_COUNT_ACTIONS'] = 5;
	}
	if($count1 + $count2 > 5)
	{
		$arParams['I_COUNT_ACTIONS'] = $count2;
		$arParams['I_COUNT_NEWS'] = 5 - $count2;
	}

	// The first block
	if($arFilter1['IBLOCK_ID'] == 6)
	{
		$arNavigation1 = array(
			'nPageSize' => $arParams['I_COUNT_ACTIONS']
		);
	}
	elseif($arFilter1['IBLOCK_ID'] == 7)
	{
		$arNavigation1 = array(
			'nPageSize' => $arParams['I_COUNT_NEWS']
		);
	}
	if($arNavigation1['nPageSize'] > 0)
	{
		$res = CIBlockElement::GetList($arOrder, $arFilter1, false, $arNavigation1);
		while($ob = $res->GetNextElement())
		{
			$obj			= $ob->GetFields();
			$obj['PRO']		= $ob->GetProperties();
			$arResult['ITEMS'][$arFilter1['IBLOCK_ID']][]	= $obj;
		}
	}

	// The second block
	if($arFilter2['IBLOCK_ID'] == 6)
	{
		$arNavigation2 = array(
			'nPageSize' => $arParams['I_COUNT_ACTIONS']
		);
	}
	elseif($arFilter2['IBLOCK_ID'] == 7)
	{
		$arNavigation2 = array(
			'nPageSize' => $arParams['I_COUNT_NEWS']
		);
	}
	if($arNavigation2['nPageSize'] > 0)
	{
		$res = CIBlockElement::GetList($arOrder, $arFilter2, false, $arNavigation2);
		while($ob = $res->GetNextElement())
		{
			$obj			= $ob->GetFields();
			$obj['PRO']		= $ob->GetProperties();
			$arResult['ITEMS'][$arFilter2['IBLOCK_ID']][]	= $obj;
		}
	}

	$arResult['COUNT'] = 'ratio'.count($arResult['ITEMS'][$arFilter1['IBLOCK_ID']]).'to'.
		count($arResult['ITEMS'][$arFilter2['IBLOCK_ID']]);

	$this->IncludeComponentTemplate();
	return $arResult;
}
// ---------------------------------------------------------------------------------------------------- iLaB?>
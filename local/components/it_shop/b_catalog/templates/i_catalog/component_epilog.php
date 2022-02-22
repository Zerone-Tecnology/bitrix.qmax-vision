<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	if( $arResult['VARIABLES']['SECTION_ID'] && $arParams['I_BREDCRUMBS_HEADER']=='Y' )
	{
		$nav = CIBlockSection::GetNavChain($arParams['IBLOCK_ID'], $arResult['VARIABLES']['SECTION_ID'], array('ID', 'NAME', 'SECTION_PAGE_URL'));
		while($ob = $nav->GetNext()){
			$arResult['I_TITLE'][$ob['ID']]		= $ob;
			$s_id[]								= $ob['ID'];
		}

		$arSelect = Array('UF_I_NAME_'.$l);
		$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ID'=>$s_id, 'ACTIVE'=>'Y');
		$res = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, false, $arSelect);
		while($ob = $res->GetNext())
			$arResult['I_TITLE'][$ob['ID']]['NAME']	= $ob['UF_I_NAME_'.$l];

		// Title lang
		if( $arResult['I_TITLE'][$arResult['VARIABLES']['SECTION_ID']] )
			$APPLICATION->SetPageProperty('title', $arResult['I_TITLE'][$arResult['VARIABLES']['SECTION_ID']]['NAME']);
		foreach($arResult['I_TITLE'] as $e)
			$APPLICATION->AddChainItem($e['NAME'], $e['~SECTION_PAGE_URL']);
	}
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
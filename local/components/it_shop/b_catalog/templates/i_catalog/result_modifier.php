<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	if( $arResult['VARIABLES']['SECTION_ID']>0 )
		$arFilter['ID'] = $arResult['VARIABLES']['SECTION_ID'];
	elseif( $arResult['VARIABLES']['SECTION_CODE']!='' )
		$arFilter['=CODE'] = $arResult['VARIABLES']['SECTION_CODE'];

	$res = CIBlockSection::GetList(array(), $arFilter);
		$arResult['CURRENT_SECTION'] = $res->GetNext();
// ---------------------------------------------------------------------------------------------------- iLaB
endif?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] ):
	foreach($arResult['ITEMS'] as $k=>$e)
	{
		// NAME
		if( $e['PRO']['I_IMG']['VALUE'] )
			$arResult['ITEMS'][$k]['PREVIEW_PICTURE'] = CFile::GetPath($e['PRO']['I_IMG']['VALUE']);
	}
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] ):
	$l = strtoupper(LANGUAGE_ID);

	// Языковые версии
	foreach($arResult['ITEMS'] as $k=>$e)
	{
		// NAME
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
		// PREVIEW
		if( $e['PRO']['I_PREVIEW_TEXT_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['PREVIEW_TEXT'] = $e['PRO']['I_PREVIEW_TEXT_'.$l]['~VALUE']['TEXT'];
		// PREVIEW IMG
		if( $e['PRO']['I_PREVIEW_IMG']['VALUE'] )
			$arResult['ITEMS'][$k]['PREVIEW_PICTURE'] = CFile::GetPath($e['PRO']['I_PREVIEW_IMG']['VALUE']);
		// CLASS NAME
		if( $e['PRO']['I_CLASS_IMG']['VALUE_XML_ID'] )
			$arResult['ITEMS'][$k]['I_CLASS_IMG'] = $e['PRO']['I_CLASS_IMG']['VALUE_XML_ID'];
	}
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>
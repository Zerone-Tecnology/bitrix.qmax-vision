<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	// Языковые версии
	foreach($arResult['ITEMS'] as $k=>$e)
	{
		// NAME
		if( $e['PROPERTIES']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PROPERTIES']['I_NAME_'.$l]['VALUE'];
		// PREVIEW
		if( $e['PROPERTIES']['I_PREVIEW_TEXT_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['PREVIEW_TEXT'] = $e['PROPERTIES']['I_PREVIEW_TEXT_'.$l]['~VALUE']['TEXT'];
	}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
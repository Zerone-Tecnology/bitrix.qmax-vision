<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] ):
	$l = strtoupper(LANGUAGE_ID);
	if( $arParams['I_LIMIT_TEASER'] && (count($arResult['ITEMS']) > $arParams['I_LIMIT_TEASER']) )
		array_splice($arResult['ITEMS'], $arParams['I_LIMIT_TEASER']);

	// Языковые версии
	foreach($arResult['ITEMS'] as $k=>$e)
	{
		// NAME
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
	}
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
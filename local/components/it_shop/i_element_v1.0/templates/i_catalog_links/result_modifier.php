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
		if( $e['PRO']['I_LINK_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['I_LINK'] = $e['PRO']['I_LINK_'.$l]['VALUE'];
	}
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>
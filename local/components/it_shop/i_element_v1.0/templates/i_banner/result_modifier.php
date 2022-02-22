<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// Нельзя просто так взять и подключить карты :)
// Не включать КЭШ компоненты!
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] )
{
	$l = strtoupper(LANGUAGE_ID);
	if( CSite::InDir(SITE_DIR.'catalog/') && $arParams['I_SECTION_ID'] )
		foreach($arResult['ITEMS'] as $k=>$e)
		{
			// Языковые версии
			if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
				$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
			if( !in_array($arParams['I_SECTION_ID'], $e['PRO']['LINK_TO_SECTION']['VALUE']) )
				unset($arResult['ITEMS'][$k]);
		}
	foreach($arResult['ITEMS'] as $k=>$e)
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )// Языковые версии
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
}
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
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
			if ($e['PRO']['LINK_TO_SECTION']['VALUE'])
			{
				if( !in_array($arParams['I_SECTION_ID'], $e['PRO']['LINK_TO_SECTION']['VALUE']) )
					unset($arResult['ITEMS'][$k]);
			}
		}
	foreach($arResult['ITEMS'] as $k=>$e)
	{
		// Языковые версии
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )// Языковые версии
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
		// Position banner
		if( $e['PRO']['I_POSITION']['VALUE'] )
			$arResult['ITEMS'][$k]['I_POS'] = $e['PRO']['I_POSITION']['VALUE_XML_ID'];
	}
}
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>
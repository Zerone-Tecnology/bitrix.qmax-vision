<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] && CSite::InDir(SITE_DIR.'catalog/') ):

	foreach($arResult['ITEMS'] as $k=>$e)
	{
		// Языковые версии
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
		// Показ баннера по разделам
		if ($e['PRO']['LINK_TO_SECTION']['VALUE'])
		{
			if( !in_array($arParams['I_SECTION_ID'], $e['PRO']['LINK_TO_SECTION']['VALUE']) )
				unset($arResult['ITEMS'][$k]);
		}
	}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
$l = strtoupper(LANGUAGE_ID);
if($arResult['ITEMS']):

	// Language versions and other modifiers
	foreach( $arResult['ITEMS'] as $k=>$e )
	{
		// NAME
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
		// PREVIEW TEXT
		if( $e['PRO']['I_PREVIEW_TEXT_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['PREVIEW_TEXT'] = $e['PRO']['I_PREVIEW_TEXT_'.$l]['~VALUE']['TEXT'];
		// PREVIEW_PICTURE
		if( $e['PRO']['I_IMG_'.$l]['VALUE'] )
		{
			$arResult['ITEMS'][$k]['PREVIEW_PICTURE_SRC'] = CFile::GetPath($e['PRO']['I_IMG_'.$l]['VALUE']);
		}
		else
			$arResult['ITEMS'][$k]['DISPLAY_ACTIVE_FROM'] = '';
	}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre">
		<?print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>
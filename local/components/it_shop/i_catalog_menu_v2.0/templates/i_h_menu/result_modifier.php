<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):

endif;
if ($arResult['I_PRODUCT_MENU']) {
// PRICE MATRIX
	if ($arParams['I_PRICE_MATRIX'] == 'Y')
		foreach ($arResult['I_PRODUCT_MENU'] as $k => $e) {
			$arResult['I_PRODUCT_MENU'][$k]['PRICE_MATRIX'] = CatalogGetPriceTableEx($e['ID'], 0, [], 'Y');
			$arResult['I_PRODUCT_MENU'][$k]['PRICE_MATRIX']['I_MULTI_PRICE'] = $e['PROPERTIES']['I_MULTI_PRICE']['VALUE'];
			if (isset($arResult['I_PRODUCT_MENU'][$k]['PRICE_MATRIX']['COLS']) && is_array($arResult['I_PRODUCT_MENU'][$k]['PRICE_MATRIX']['COLS'])) {
				foreach ($arResult['I_PRODUCT_MENU'][$k]['PRICE_MATRIX']['COLS'] as $keyColumn => $arColumn)
					$arResult['I_PRODUCT_MENU'][$k]['PRICE_MATRIX']['COLS'][$keyColumn]['NAME_LANG'] = htmlspecialcharsbx($arColumn['NAME_LANG']);
			}
		}
}
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre">
		<?print_r($arResult)?>
	</pre>
<?endif*/?>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB
if ($arResult['ITEMS'])
{
	foreach($arResult['ITEMS'] as $e)
	{
		if ($e['DELAY']=='N' && $e['CAN_BUY']=='Y')
		{
			$arResult['ILAB']['JSON']['BASKET'][$e['PRODUCT_ID']]['id'] = $e['ID'];
			$arResult['ILAB']['JSON']['BASKET'][$e['PRODUCT_ID']]['quant'] = +$e['QUANTITY'];
			$arResult['ILAB']['JSON']['BASKET'][$e['PRODUCT_ID']]['price'] = $e['PRICE'];
			$arResult['ILAB']['JSON']['LINK_ID'][$e['ID']] = $e['PRODUCT_ID'];
			$arResult['ILAB']['JSON']['IDS'][] = $e['PRODUCT_ID'];
		}

		if ($e['DELAY'] == 'Y') {
			$arResult['ILAB']['JSON']['FAVORITE']['B_IDS'][$e['PRODUCT_ID']] = $e['ID'];
			$arResult['ILAB']['JSON']['FAVORITE']['IDS'][] = $e['PRODUCT_ID'];
		}
	}
}
// ---------------------------------------------------------------------------------------------------- iLab?>





<?/*if($USER->isAdmin()):?>
	<pre>
		<?print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>
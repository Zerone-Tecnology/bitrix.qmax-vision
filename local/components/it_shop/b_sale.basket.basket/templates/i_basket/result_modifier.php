<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( CSite::InDir(SITE_DIR.'personal/basket.php') )
{
	global $APPLICATION;
	$APPLICATION->AddChainItem($APPLICATION->GetTitle(), SITE_DIR.'personal/basket.php');
}

if($arResult['GRID']['ROWS'])
{
	// ед.измерение т.к. свои почему то работают не коррекстно
	foreach ($arResult['GRID']['ROWS'] as $k=>$ele)
	{
		$item_id[] = $ele['PRODUCT_ID'];

		$mxResult = CCatalogSku::GetProductInfo($ele['PRODUCT_ID']);
		if( is_array($mxResult) )
		{
			$item_id[] = $mxResult['ID'];
			$arResult['GRID']['ROWS'][$k]['I_SKU_LINK_ID'] = $mxResult['ID'];
		}
		else{
			$arResult['GRID']['ROWS'][$k]['I_SKU_LINK_ID'] = $ele['PRODUCT_ID'];
		}
	}

	if( is_array($item_id) )// Выташить картинки/цены для поиска/ссылки на детально товар(торговое предложение)/упаковки
	{
		$item_id = array_unique($item_id);// Удалим повторяющиеся элементы
		$arResult['I_FINAL_STATUS'] = array();

		$arFilter = Array('ID'=>$item_id, 'ACTIVE'=>'Y');
		$arSelect = array('ID', 'IBLOCK_ID', 'PROPERTY_I_SYSTEM_TO_ORDER', 'PROPERTY_I_SYSTEM_IN_STOCK', 'PROPERTY_I_SYSTEM_EXPECTED');
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNext())
		{
			$arResult['I_PRODUCT'][$ob['ID']] = $ob;

			/*if($ob['PROPERTY_I_SYSTEM_IN_STOCK_VALUE'])
			{
				$arResult['I_STATUS'][$ob['ID']][] = 'I_SYSTEM_IN_STOCK';
				if( !in_array('I_SYSTEM_IN_STOCK', $arResult['I_FINAL_STATUS']) )
					$arResult['I_FINAL_STATUS'][] = 'I_SYSTEM_IN_STOCK';
			}*/
			if($ob['PROPERTY_I_SYSTEM_EXPECTED_VALUE'])
			{
				$arResult['I_STATUS'][$ob['ID']][] = 'I_SYSTEM_EXPECTED';
				if( !in_array('I_SYSTEM_EXPECTED', $arResult['I_FINAL_STATUS']) )
					$arResult['I_FINAL_STATUS'][] = 'I_SYSTEM_EXPECTED';
			}
			if($ob['PROPERTY_I_SYSTEM_TO_ORDER_VALUE'])
			{
				$arResult['I_STATUS'][$ob['ID']][] = 'I_SYSTEM_TO_ORDER';
				if( !in_array('I_SYSTEM_TO_ORDER', $arResult['I_FINAL_STATUS']) )
					$arResult['I_FINAL_STATUS'][] = 'I_SYSTEM_TO_ORDER';
			}
		}
	}
}
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
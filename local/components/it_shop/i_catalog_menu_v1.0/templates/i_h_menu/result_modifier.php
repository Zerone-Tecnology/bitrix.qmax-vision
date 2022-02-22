<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['I_PRODUCT']):

	// Проверка на торговые предложения
	$offersExist = CCatalogSKU::getExistOffers($arResult['I_PRODUCT_ID']);
	foreach ($arResult['I_PRODUCT'] as $k=>$e)
		if( $offersExist[$e['ID']] )
			$arResult['I_PRODUCT'][$k]['I_TRADE_OFFERS'] = 'Y';

	// MIN_OFFERS_PRICE
	foreach($arResult['I_PRODUCT'] as $cell=>$arElement)
	{
		if(is_array($arElement['OFFERS']) && !empty($arElement['OFFERS'])) //Product has offers
		{
			$minItemPrice = 0;
			$minItemPriceFormat = '';
			foreach($arElement['OFFERS'] as $keyOffer=>$arOffer)
			{
				// MAX_OFFERS_PRICE
				if( $pr_max = i_price($arOffer['PRICES'], $arOffer['MIN_PRICE']['DISCOUNT_VALUE']) )
					$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE'] = $arOffer['PRICES'][$pr_max];
				else
					$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE'] = $arOffer['MIN_PRICE'];
				/*
				if($USER->isAdmin()):
				// echo functionaL MAX_OFFERS_PRICE
				if( $arElement['PROPERTIES']['MAXIMUM_PRICE']['VALUE']==$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'] )
					echo $arElement['NAME'].':   '.$arElement['PROPERTIES']['MAXIMUM_PRICE']['VALUE'].'=='.$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'] .' && ( '.count($arOffer['PRICES']).'==1 || '.$arOffer['MIN_PRICE']['DISCOUNT_VALUE'].'=='.$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'].')<br>-----------------------------------------<br>';
				endif;
				*/
				// delete MAX_OFFERS_PRICE if
				if(
					$arElement['PROPERTIES']['MAXIMUM_PRICE']['VALUE']==$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE']
					&& ( count($arOffer['PRICES'])==1 || $arOffer['MIN_PRICE']['DISCOUNT_VALUE']==$arResult['I_PRODUCT'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'] )
				)
					$arResult['I_PRODUCT'][$cell]['HIDE_MAX_OFFERS_PRICE'] = 'N';

				foreach($arOffer['PRICES'] as $code=>$arPrice)
				{
					if($arPrice['CAN_ACCESS'])
					{
						if ($arPrice['DISCOUNT_VALUE'] < $arPrice['VALUE'])
						{
							$minOfferPrice = $arPrice['DISCOUNT_VALUE'];
							$minOfferPriceFormat = $arPrice['PRINT_DISCOUNT_VALUE'];
						}
						else
						{
							$minOfferPrice = $arPrice['VALUE'];
							$minOfferPriceFormat = $arPrice['PRINT_VALUE'];
						}

						if ($minItemPrice > 0 && $minOfferPrice < $minItemPrice)
						{
							$minItemPrice = $minOfferPrice;
							$minItemPriceFormat = $minOfferPriceFormat;
						}
						elseif ($minItemPrice == 0)
						{
							$minItemPrice = $minOfferPrice;
							$minItemPriceFormat = $minOfferPriceFormat;
						}
					}
				}
			}
			if ($minItemPrice > 0)
			{
				$arResult['I_PRODUCT'][$cell]['MIN_OFFER_PRICE'] = $minItemPrice;
				$arResult['I_PRODUCT'][$cell]['PRINT_MIN_OFFER_PRICE'] = $minItemPriceFormat;
			}
		}
	}

	// PRICE MATRIX
	if( $arParams['I_PRICE_MATRIX']=='Y' )
		foreach($arResult['I_PRODUCT'] as $k=>$e)
		{
			$arResult['I_PRODUCT'][$k]['PRICE_MATRIX']					= CatalogGetPriceTableEx($e['ID'], 0, $arResult['PRICES_ALLOW'], 'Y', $arResult['CONVERT_CURRENCY']);
			$arResult['I_PRODUCT'][$k]['PRICE_MATRIX']['I_MULTI_PRICE']	= $e['PROPERTIES']['I_MULTI_PRICE']['VALUE'];
			if (isset($arResult['I_PRODUCT'][$k]['PRICE_MATRIX']['COLS']) && is_array($arResult['I_PRODUCT'][$k]['PRICE_MATRIX']['COLS']))
			{
				foreach($arResult['I_PRODUCT'][$k]['PRICE_MATRIX']['COLS'] as $keyColumn=>$arColumn)
					$arResult['I_PRODUCT'][$k]['PRICE_MATRIX']['COLS'][$keyColumn]['NAME_LANG'] = htmlspecialcharsbx($arColumn['NAME_LANG']);
			}
		}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
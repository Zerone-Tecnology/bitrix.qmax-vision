<?	use Bitrix\Main\Type\Collection;
	use Bitrix\Currency\CurrencyTable;
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	$arResult['I_BASE_CURRENCY'] = CCurrency::GetBaseCurrency();// Код базовой валюты.

	// Есть ли торговые предложения у товара?
	foreach($arResult['ITEMS'] as $k=>$e)
	{
		$productList[] = $e['ID'];
		// Языковые версии
		if( $e['PROPERTIES']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PROPERTIES']['I_NAME_'.$l]['VALUE'];
	}
	$offersExist = CCatalogSKU::getExistOffers($productList);
	foreach ($arResult['ITEMS'] as $k=>$e)
		if( $offersExist[$e['ID']] )
			$arResult['ITEMS'][$k]['I_TRADE_OFFERS'] = 'Y';

	// MIN_OFFERS_PRICE
	foreach($arResult['ITEMS'] as $cell=>$arElement)
	{
		if(is_array($arElement['OFFERS']) && !empty($arElement['OFFERS'])) //Product has offers
		{
			$minItemPrice = 0;
			$minItemPriceFormat = '';
			$arResult['ITEMS'][$cell]['CATALOG_QUANTITY'] = 0;// Колличество

			foreach($arElement['OFFERS'] as $arOffer)
			{
				// MAX_OFFERS_PRICE
				if( $pr_max = i_price($arOffer['PRICES'], $arOffer['MIN_PRICE']['DISCOUNT_VALUE']) )
					$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE'] = $arOffer['PRICES'][$pr_max];
				else
					$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE'] = $arOffer['MIN_PRICE'];
/*
if($USER->isAdmin()):
// echo functionaL MAX_OFFERS_PRICE
if( $arElement['PROPERTIES']['MAXIMUM_PRICE']['VALUE']==$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'] )
	echo $arElement['NAME'].':   '.$arElement['PROPERTIES']['MAXIMUM_PRICE']['VALUE'].'=='.$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'] .' && ( '.count($arOffer['PRICES']).'==1 || '.$arOffer['MIN_PRICE']['DISCOUNT_VALUE'].'=='.$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'].')<br>-----------------------------------------<br>';
endif;
*/
				// delete MAX_OFFERS_PRICE if
				if(
					$arElement['PROPERTIES']['MAXIMUM_PRICE']['VALUE']==$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE']
					&& ( count($arOffer['PRICES'])==1 || $arOffer['MIN_PRICE']['DISCOUNT_VALUE']==$arResult['ITEMS'][$cell]['OFFERS'][$keyOffer]['MAX_OFFERS_PRICE']['DISCOUNT_VALUE'] )
				)
					$arResult['ITEMS'][$cell]['HIDE_MAX_OFFERS_PRICE'] = 'N';

				$arResult['ITEMS'][$cell]['CATALOG_QUANTITY'] += $arOffer['CATALOG_QUANTITY'];// Колличество
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
				$arResult['ITEMS'][$cell]['MIN_OFFER_PRICE'] = $minItemPrice;
				$arResult['ITEMS'][$cell]['PRINT_MIN_OFFER_PRICE'] = $minItemPriceFormat;
			}
		}
	}

	// Количество
	if( $arParams['I_CHECK_QUANTITY']=='Y' && $arParams['I_QUAN_VERY_LITTLE'] && $arParams['I_QUAN_LITTLE'] && $arParams['I_QUAN_AVERAGE'] )
	{
		?><style><?
		foreach($arResult['ITEMS'] as $k=>$e)
		{		
			if( $e['CATALOG_QUANTITY']>0 && $e['CATALOG_QUANTITY']<($arParams['I_QUAN_VERY_LITTLE']+1) ) {
				$arResult['ITEMS'][$k]['I_QUAN_PERC'] = '7';
				$arResult['ITEMS'][$k]['I_QUAN_TEXT'] = GetMessage('QUAN_VERY_LITTLE');
			} elseif( $e['CATALOG_QUANTITY']>$arParams['I_QUAN_VERY_LITTLE'] && $e['CATALOG_QUANTITY']<($arParams['I_QUAN_LITTLE']+1) ) {
				$arResult['ITEMS'][$k]['I_QUAN_PERC'] = '14';
				$arResult['ITEMS'][$k]['I_QUAN_TEXT'] = GetMessage('QUAN_LITTLE');
			} elseif( $e['CATALOG_QUANTITY']>$arParams['I_QUAN_LITTLE'] && $e['CATALOG_QUANTITY']<($arParams['I_QUAN_AVERAGE']+1) ) {
				$arResult['ITEMS'][$k]['I_QUAN_PERC'] = '21';
				$arResult['ITEMS'][$k]['I_QUAN_TEXT'] = GetMessage('QUAN_AVERAGE');
			} elseif( $e['CATALOG_QUANTITY']>$arParams['I_QUAN_AVERAGE'] ) {
				$arResult['ITEMS'][$k]['I_QUAN_PERC'] = '28';
				$arResult['ITEMS'][$k]['I_QUAN_TEXT'] = GetMessage('QUAN_MANY');
			} else {
				$arResult['ITEMS'][$k]['I_QUAN_PERC'] = '0';
				$arResult['ITEMS'][$k]['I_QUAN_TEXT'] = GetMessage('QUAN_NOT');
			}?>
			.i_quan_sl_<?=$e['ID']?>:before { width: <?=$arResult['ITEMS'][$k]['I_QUAN_PERC']?>px }
			<?
		}
		?></style><?
	}

	// PRICE MATRIX
	if( $arParams['I_PRICE_MATRIX']=='Y' )
		foreach($arResult['ITEMS'] as $k=>$e)
		{
			$arResult['ITEMS'][$k]['PRICE_MATRIX']					= CatalogGetPriceTableEx($e['ID'], 0, $arResult['PRICES_ALLOW'], 'Y', $arResult['CONVERT_CURRENCY']);
			$arResult['ITEMS'][$k]['PRICE_MATRIX']['I_MULTI_PRICE']	= $e['PROPERTIES']['I_MULTI_PRICE']['VALUE'];
			if (isset($arResult['ITEMS'][$k]['PRICE_MATRIX']['COLS']) && is_array($arResult['ITEMS'][$k]['PRICE_MATRIX']['COLS']))
			{
				foreach($arResult['ITEMS'][$k]['PRICE_MATRIX']['COLS'] as $keyColumn=>$arColumn)
					$arResult['ITEMS'][$k]['PRICE_MATRIX']['COLS'][$keyColumn]['NAME_LANG'] = htmlspecialcharsbx($arColumn['NAME_LANG']);
			}
		}

	// Water Mark
	$arParams['FILTER_WATER_MARK'] = false;
	if( $arParams['I_WATER_MARK_SECTION']=='Y' )
		foreach ($arResult['ITEMS'] as $k=>$e)
		{
			$arParams['FILTER_WATER_MARK'] = Array(
				array('name'=>'watermark', 'position'=>'center', 'size'=>'big', 'file'=>$_SERVER['DOCUMENT_ROOT'].'/local/templates/ilab_it_shop/tmpl/img/watermark.png')
			);
			$arResult['ITEMS'][$k]['I_PREVIEW_PICTURE'] = CFile::ResizeImageGet($e['PREVIEW_PICTURE'], false, BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arParams['FILTER_WATER_MARK']);
		}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
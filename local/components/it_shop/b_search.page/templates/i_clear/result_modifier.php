<?
use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	$l = strtoupper(LANGUAGE_ID);

	$arResult["TAGS_CHAIN"] = array();
	if($arResult["REQUEST"]["~TAGS"])
	{
		$res = array_unique(explode(",", $arResult["REQUEST"]["~TAGS"]));
		$url = array();
		foreach ($res as $key => $tags)
		{
			$tags = trim($tags);
			if(!empty($tags))
			{
				$url_without = $res;
				unset($url_without[$key]);
				$url[$tags] = $tags;
				$result = array(
					"TAG_NAME" => htmlspecialcharsex($tags),
					"TAG_PATH" => $APPLICATION->GetCurPageParam("tags=".urlencode(implode(",", $url)), array("tags")),
					"TAG_WITHOUT" => $APPLICATION->GetCurPageParam((count($url_without) > 0 ? "tags=".urlencode(implode(",", $url_without)) : ""), array("tags")),
				);
				$arResult["TAGS_CHAIN"][] = $result;
			}
		}
	}

	/* ---------------------------------------------------------------------------------------------------- iLaB */

	$arParams['SHOW_PRICE_COUNT']	= 1; // default Выводить цены для количества 
	// $arParams['PRICE_VAT_INCLUDE']	= 'Y'; // default Включать НДС в цену
	// iLab

	if(!CModule::IncludeModule('catalog'))
		return;// Модуль Catalog

	// Заберём все ID товаров
	foreach($arResult['SEARCH'] as $arEle){
		if($arEle['ITEM_ID'])
		{
			$I_id[]							= $arEle['ITEM_ID'];// ID
			$arParams['I_IBLOCK_ID']		= $arEle['PARAM2'];// ID инфоблока каталога товаров
		}
	}
	if(is_array($I_id))
	{// Если присутствует в поиске товары 

		// CURRENCY
		$arParams['PRICE_VAT_INCLUDE']	= $arParams['PRICE_VAT_INCLUDE'] !== 'N';
		$arParams['CURRENCY_ID']		= trim(strval($arParams['CURRENCY_ID']));
		$arPricecode					= $arParams['I_PRICE_CODE'];

		if ( $arParams['CURRENCY_ID']=='' )
			$arParams['CONVERT_CURRENCY'] = 'N';
		
		if ( $arParams['CONVERT_CURRENCY']=='Y' )
			if (!Loader::includeModule('currency'))
			{
				$arParams['CONVERT_CURRENCY']	= 'N';
				$arParams['CURRENCY_ID']		= '';
			} else {
				$currencyIterator = CurrencyTable::getList(array(
					'select' => array('CURRENCY'),
					'filter' => array('CURRENCY' => $arParams['CURRENCY_ID'])
				));
				if ($currency = $currencyIterator->fetch())
				{
					$arParams['CURRENCY_ID']		= $currency['CURRENCY'];
					$arConvertParams['CURRENCY_ID'] = $currency['CURRENCY'];
				}else {
					$arParams['CONVERT_CURRENCY']	= 'N';
					$arParams['CURRENCY_ID']		= '';
				}
				unset($currency, $currencyIterator);
			}
/*
		// Выберем типы цен доступные авторизованному пользователю --------PRICE
		$dbpr = CCatalogGroup::GetList(array('SORT' => 'ASC'),array('CAN_ACCESS' => 'Y'));
		while ($arpr = $dbpr->Fetch())
		{
//			$arResult['I_PRICES_CODE'][]	= $arpr;
			$arPricecode[]					= $arpr['NAME'];
		}
*/
		$arSelect = Array('ID', 'NAME', 'IBLOCK_ID', 'QUANTITY', 'PREVIEW_PICTURE');
		$arFilter = Array('ID'=>$I_id);

		// Выберем параметры типов цен, и добавляем их в arSelect и arFilter
		// Так же функция нужна для правильной отработки функции CIBlockPriceTools::GetItemPrices --------PRICE
		$arPrices = CIBlockPriceTools::GetCatalogPrices($arParams['I_IBLOCK_ID'], $arPricecode);
		foreach($arPrices as $value)
		{
			$arSelect[]											= $value['SELECT'];
			$arFilter['CATALOG_SHOP_QUANTITY_'.$value['ID']]	= $arParams['SHOW_PRICE_COUNT'];
			$iarFilter['CATALOG_SHOP_QUANTITY_'.$value['ID']]	= $arParams['SHOW_PRICE_COUNT'];
			$arPricesId[]										= $value['ID'];
		}

	//	$arResult['arPrices'] = $arPrices;
	//	$arResult['arSelect'] = $arSelect;
	//	$arResult['arFilter'] = $arFilter;

		// Картинки/Цены
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$ob_do			= $ob->GetFields();
			$ob_do['PRO']	= $ob->GetProperties();

			// SKU
			if( CCatalogSKU::IsExistOffers($ob_do['ID'], $ob_do['IBLOCK_ID']) )// Если есть торговые предложения
			{
				// PRICE MATRIX
				$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['I_TRADE_OFFERS'] = 'Y';

				$arInfo		= CCatalogSKU::GetInfoByProductIBlock($ob_do['IBLOCK_ID']);

				$iarFilter = Array('IBLOCK_ID'=>$arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID']=>$ob_do['ID']);
				$ires = CIBlockElement::GetList(array(), $iarFilter, false, false, $arSelect);
				while($iob = $ires->GetNextElement())
				{
					$iob_do = $iob->GetFields();

					$arOffers[$iob_do['ID']] = $iob_do;

					// Заберм все цены товара доступные пользователю --------PRICE
					$iob_do['PRICES']					= CIBlockPriceTools::GetItemPrices(	$iob_do['IBLOCK_ID'], $arPrices, $iob_do, $arParams['PRICE_VAT_INCLUDE'], $arConvertParams);
					$iob_do['CAN_BUY']					= CIBlockPriceTools::CanBuy(		$iob_do['IBLOCK_ID'], $arPrices, $iob_do);

					$arOffers[$iob_do['ID']]['PRICES']	= $iob_do['PRICES'];
					$arOffers[$iob_do['ID']]['CAN_BUY']	= $iob_do['CAN_BUY'];
				}

				// MIN_OFFERS_PRICE
				if(is_array($arOffers) && !empty($arOffers)) //Product has offers
				{
					$minItemPrice = 0;
					$minItemPriceFormat = '';
					foreach($arOffers as $arOffer)
					{
						foreach($arOffer['PRICES'] as $code=>$arPrice)
						{
							if($arPrice['CAN_ACCESS'])
							{
								if ($arPrice['DISCOUNT_VALUE'] < $arPrice['VALUE'])
								{
									$minOfferPrice			= $arPrice['DISCOUNT_VALUE'];
									$minOfferPriceFormat	= $arPrice['PRINT_DISCOUNT_VALUE'];
								}
								else
								{
									$minOfferPrice			= $arPrice['VALUE'];
									$minOfferPriceFormat	= $arPrice['PRINT_VALUE'];
								}

								if ($minItemPrice > 0 && $minOfferPrice < $minItemPrice)
								{
									$minItemPrice			= $minOfferPrice;
									$minItemPriceFormat		= $minOfferPriceFormat;
								}
								elseif ($minItemPrice == 0)
								{
									$minItemPrice			= $minOfferPrice;
									$minItemPriceFormat		= $minOfferPriceFormat;
								}
							}
						}
					}
					if ($minItemPrice > 0)
					{
						$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['OFFERS']['MIN_OFFER_PRICE']			= $minItemPrice;
						$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['OFFERS']['PRINT_MIN_OFFER_PRICE']	= $minItemPriceFormat;
					}
				}
				unset($arOffers);// Обновим переменую
			}

			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['NAME']					= $ob_do['NAME'];// Имя
			if( $ob_do['PRO']['I_FULLNAME_'.$l]['VALUE'] )
				$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['NAME']				= $ob_do['PRO']['I_FULLNAME_'.$l]['VALUE'];// Имя
			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['QUANTITY']				= $ob_do['CATALOG_QUANTITY'];// Количество
			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['ID']					= $ob_do['ID'];// ID
			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PREVIEW_PICTURE']		= CFile::GetPath($ob_do['PREVIEW_PICTURE']);// Картинка

			$mxResult = CCatalogSku::GetProductInfo($ob_do['ID']);
			if( is_array($mxResult) && !$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PREVIEW_PICTURE'] )// Если это ТП и нет картинки
				$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PREVIEW_PICTURE'] = $arResult['I_PRODUCT_ITEMS'][$mxResult['ID']]['PREVIEW_PICTURE'];

			// Заберм все цены товара доступные пользователю --------PRICE
			$ob_do['PRICES']													= CIBlockPriceTools::GetItemPrices(	$arParams['IBLOCK_ID'], $arPrices, $ob_do, $arParams['PRICE_VAT_INCLUDE'], $arConvertParams);
			$ob_do['CAN_BUY']													= CIBlockPriceTools::CanBuy(		$arParams['IBLOCK_ID'], $arPrices, $ob_do);
			// PRICE MATRIX
			if( $arParams['I_PRICE_MATRIX']=='Y' )
			{
				$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PRICE_MATRIX']					= CatalogGetPriceTableEx($ob_do['ID'], 0, $arPricesId, 'Y', array('CURRENCY_ID'=>$arParams['CURRENCY_ID']));
				$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PRICE_MATRIX']['I_MULTI_PRICE']	= $ob_do['PRO']['I_MULTI_PRICE']['VALUE'];
				if (isset($arResult['ITEMS'][$k]['PRICE_MATRIX']['COLS']) && is_array($arResult['ITEMS'][$k]['PRICE_MATRIX']['COLS']))
				{
					foreach($arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PRICE_MATRIX']['COLS'] as $keyColumn=>$arColumn)
						$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PRICE_MATRIX'][$keyColumn]['NAME_LANG'] = htmlspecialcharsbx($arColumn['NAME_LANG']);
				}
			}
			
			// MIN_PRICE
			if( $ob_do['PRICES'] )
				foreach($ob_do['PRICES'] as $p)
					if($p['MIN_PRICE']=='Y')
					{	$ob_do['MIN_PRICE'] = $p;	break;	}

			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['PRICES']				= $ob_do['PRICES'];
			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['CAN_BUY']				= $ob_do['CAN_BUY'];
			$arResult['I_PRODUCT_ITEMS'][$ob_do['ID']]['MIN_PRICE']				= $ob_do['MIN_PRICE'];
		}
	}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
<?	use Bitrix\Main\Type\Collection;
	use Bitrix\Currency\CurrencyTable;
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):

	$arResult['I_BASE_CURRENCY'] = CCurrency::GetBaseCurrency();// Код базовой валюты.
	$arResult['CAT_PRICES'] = CIBlockPriceTools::GetCatalogPrices($arParams["IBLOCK_ID"], $arParams["PRICE_CODE"]);//Типы цен для подставления названия цены
	// Выберем типы цен доступные текущему пользователю
	foreach ($arResult['PRICES'] as $k=>$e)
		if($e['CAN_BUY'] && $e['CAN_VIEW'])
			$arResult['I_PRICES_GROUP'][$k] = $e;
	/* Замена кода выше, ликвидация запроса.
	$res = CCatalogGroup::GetList(array('SORT' => 'ASC'),array('CAN_ACCESS'=>'Y'));
	while ($pr = $res->Fetch())
		$arResult['I_PRICES_GROUP'][$pr['NAME']] = $pr;*/

	// JQ prefix
	$sw = $arParams['I_SWIPE'];?>

	<script>
		$(document).ready(function(){
			var <?=$sw?>Swiper = new Swiper('.jq_sblock_<?=$sw?>',
			{
				grabCursor:				true,
				slidesPerView:			'auto',

				pagination: {
					el: $('.jq_pagination_<?=$sw?>'),
					dynamicBullets: true,
	//				type: 'bullets',// "bullets", "fraction", "progressbar" or "custom"
					clickable: true
				},

			});
			/*$('.jq_sblock_<?=$sw?>-left').on('click', function(e){
				e.preventDefault()
				<?=$sw?>Swiper.swipePrev()
			});
			$('.jq_sblock_<?=$sw?>-right').on('click', function(e){
				e.preventDefault()
				<?=$sw?>Swiper.swipeNext()
			});*/
		});
	</script>

	<?// Есть ли торговые предложения у товара?
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

		if (!CModule::IncludeModule("catalog"))
	return;

	// MIN_OFFERS_PRICE
	foreach($arResult['ITEMS'] as $cell=>$arElement)
	{
		if(is_array($arElement['OFFERS']) && !empty($arElement['OFFERS'])) //Product has offers
		{
			$minItemPrice = 0;
			$minItemPriceFormat = '';
			foreach($arElement['OFFERS'] as $keyOffer=>$arOffer)
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

	// Water Mark
	$arParams['FILTER_WATER_MARK'] = false;
	if( $arParams['I_WATER_MARK']=='Y' )
		foreach ($arResult['ITEMS'] as $k=>$e)
		{
			$arParams['FILTER_WATER_MARK'] = Array(
				array('name'=>'watermark', 'position'=>'center', 'size'=>'normal', 'file'=>$_SERVER['DOCUMENT_ROOT'].'/local/templates/ilab_it_shop/ilab/img/watermark.png')
			);
			$arResult['ITEMS'][$k]['I_PREVIEW_PICTURE'] = CFile::ResizeImageGet($e['PREVIEW_PICTURE'], false, BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arParams['FILTER_WATER_MARK']);
		}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>
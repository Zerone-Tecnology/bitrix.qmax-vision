<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$e = $arResult['ITEMS'][0];
//	$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
//	$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	// IMG
	if( $e['PROPERTIES'][$arParams['I_PICK']]['VALUE'] )
		$pick = $e['DISPLAY_PROPERTIES'][$arParams['I_PICK']]['FILE_VALUE']['SRC'];
	elseif( $e['PREVIEW_PICTURE']['SRC'] )
		$pick = $e['PREVIEW_PICTURE']['SRC'];
	else
		$pick = SITE_TEMPLATE_PATH.'/ilab/img/nophoto.png';
	?>
		<a href="<?=$e['DETAIL_PAGE_URL']?>" class="i_pro_day iprel" style="background-image: url(<?=$pick?>)" burl="<?=$pick?>"<?/* id="<?=$e['EDIT']?>"*/?>>
			<div class="i_pd_stiker ipabs"><?=GetMessage('PRODUCT_DAY')?></div>
			<div class="i_pd_price ipabs">
				<?// Максимальная цена [MAXIMUM_PRICE]
				if( $arParams['I_MAX_PROP_PRICE']=='Y' && $e['PROPERTIES']['MAXIMUM_PRICE']['VALUE'] && $e['MIN_OFFER_PRICE'] && $e['MIN_OFFER_PRICE']!=$e['PROPERTIES']['MAXIMUM_PRICE']['VALUE'] && !$e['PRICES'] ):?>
					<s class="i_pr_disc"><?=CurrencyFormat($e['PROPERTIES']['MAXIMUM_PRICE']['VALUE'], $arResult['I_BASE_CURRENCY'])?></s><br>
				<?endif
				// Максимальная цена [MAXIMUM_PRICE]?>
				<?if( array_key_exists($arParams['I_DEALER_PRICE'], $arResult['I_PRICES_GROUP'] ?? array()) ):// Дилер
					// Если нужно чтобы показывались у диллеров исключительно только диллерская цена.
					// В настройках компоненты - Символьный код оптовой цены(диллерская): указываем и работаем с ним
					if( $e['PRICES'][$arParams['I_DEALER_PRICE']] ):
						$de = preg_split('/\s(?=[^0-9])/', $e['PRICES'][$arParams['I_DEALER_PRICE']]['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.?>
						<span class="i_pr"><?=$de[0]?></span>&nbsp;<span class="i_tg"><?=$de[1]?></span>
					<?else:?>
						<div class="i_noprice">Дилерская цена.</div>
					<?endif?>

				<?elseif( $e['MIN_PRICE'] && $e['MIN_PRICE']['CAN_ACCESS'] ):// Цена [MIN_PRICE]
					$pr = preg_split('/\s(?=[^0-9])/', $e['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.

					if ( $e['MIN_PRICE']['DISCOUNT_VALUE'] < $e['MIN_PRICE']['VALUE'] ):// Скидка?>
						<s class="i_pr_disc"><?=$e['MIN_PRICE']['PRINT_VALUE']?></s><br>
					<?elseif( $pr_max = i_price($e['PRICES'], $e['MIN_PRICE']['DISCOUNT_VALUE']) ):// или вычислим самую наибольшую цену?>
						<s class="i_pr_disc"><?=$e['PRICES'][$pr_max]['PRINT_VALUE']?></s><br>
					<?endif?>

					<span class="i_pr<?if( strlen($e['MIN_PRICE']['DISCOUNT_VALUE'])>9 )echo ' ifont120'?>"><?=$pr[0]?></span>&nbsp;<span class="i_tg"><?=$pr[1]?></span>
					<span> / <?=$e['CATALOG_MEASURE_NAME']?></span>
				<?elseif( $e['PRINT_MIN_OFFER_PRICE'] ):?>
					<?// Максимальная цена [MAXIMUM_PRICE] v2.0
					if( $e['MIN_OFFER_PRICE']
						&& $arParams['I_MAX_PROP_PRICE']=='Y'
						&& $e['PROPERTIES']['MAXIMUM_PRICE']['VALUE']

						&& !$e['HIDE_MAX_OFFERS_PRICE'] ):?>
						<s class="i_pr_disc ipabs"><?=CurrencyFormat($e['PROPERTIES']['MAXIMUM_PRICE']['VALUE'], $arOption['I_BASE_CURRENCY'])?></s>
					<?endif?>

					<span class="i_pr_from"><?=GetMessage('FROM')?></span>&nbsp;<span class="i_pr<?if( strlen($e['MIN_OFFER_PRICE'])>7 )echo ' ifont130'?>"><?=$e['PRINT_MIN_OFFER_PRICE']?></span>
					<span> / <?=$e['CATALOG_MEASURE_NAME']?></span>
				<?else:
					echo '<div class="i_noprice">Нет цены.</div>';
				endif?>
			</div>
			<div class="i_pd_name ipabs"><?=$e['NAME']?></div>
		</a>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	foreach ($arResult['BASKET'] as $e) {
		if($e['DISCOUNT_PRICE_PERCENT']) {
			$per = round($e['DISCOUNT_PRICE_PERCENT']);
			($per == 0 || $per == -0) ? $arResult['BASKET'][$e['ID']]['DISCOUNT_PRICE_PERCENT_FORMATED'] = '' : $arResult['BASKET'][$e['ID']]['DISCOUNT_PRICE_PERCENT_FORMATED'] = $per.'%';
		}
	}
?>
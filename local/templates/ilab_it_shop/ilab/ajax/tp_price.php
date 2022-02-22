<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');

	if( !CModule::IncludeModule('iblock') || !CModule::IncludeModule('catalog') )
		return;

	$ar = explode('↕', $_POST['idiblock']);
//	$ar = array(20,783);

	$arParams['SHOW_PRICE_COUNT']	= 1; // default Выводить цены для количества 

	$arFilter = Array('IBLOCK_ID'=>$ar[0], 'ID'=>$ar[1], 'ACTIVE'=>'Y');
	$arSelect = Array('*');

	// Выберем типы цен доступные авторизованному пользователю --------PRICE
	$dbpr = CCatalogGroup::GetList(array('SORT' => 'ASC'),array('CAN_ACCESS' => 'Y'));
	while ($arpr = $dbpr->Fetch())
		$arPricecode[] = $arpr['NAME'];

	$arPrices = CIBlockPriceTools::GetCatalogPrices($ar[0], $arPricecode);
	foreach($arPrices as $value)
	{
		$arSelect[] = $value['SELECT'];
		$arFilter['CATALOG_SHOP_QUANTITY_'.$value['ID']] = $arParams['SHOW_PRICE_COUNT'];
	}

	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
	while($ob = $res->GetNextElement())
	{
		$ob_do = $ob->GetFields();

		// Заберм все цены товара доступные пользователю --------PRICE
		$ob_do['PRICES']													= CIBlockPriceTools::GetItemPrices(	$ar[0], $arPrices, $ob_do);
		$ob_do['CAN_BUY']													= CIBlockPriceTools::CanBuy(		$ar[0], $arPrices, $ob_do);
		
		// MIN_PRICE
		if( $ob_do['PRICES'] )
			foreach($ob_do['PRICES'] as $p)
				if($p['MIN_PRICE']=='Y')
				{	$ob_do['MIN_PRICE'] = $p;	break;	}

		$arResult = $ob_do;
	}

	$sum		= false;

	if( $arResult['MIN_PRICE'] )// Цена
	{
			$sum = '<div class="jq_cele_price_'.$arResult['ID'].'">';

			/*if( array_key_exists($arParams['I_DEALER_PRICE'], $arResult['I_PRICES_GROUP']) ):// Дилер
				// Если нужно чтобы показывались у диллеров исключительно только диллерская цена.
				// В настройках компоненты - Символьный код оптовой цены(диллерская): указываем и работаем с ним
				if( $arResult['PRICES'][$arParams['I_DEALER_PRICE']] ):
					$de = preg_split('/\s(?=[^0-9])/', $arResult['PRICES'][$arParams['I_DEALER_PRICE']]['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.?>
					<span class="i_pr"><?=$de[0]?></span>&nbsp;<span class="icard_tg"><?=$de[1]?></span>
				<?else:?>
					<div class="i_noprice">Дилерская цена.</div>
				<?endif?>

			<?else*/if( $arResult['MIN_PRICE'] && $arResult['MIN_PRICE']['CAN_ACCESS'] ):// Цена [MIN_PRICE]
				$pr = preg_split('/\s(?=[^0-9])/', $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.

				if ( $arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE'] )// Скидка
					$sum .= '<span class="icard_pr_disc">Старая цена: '.$arResult['MIN_PRICE']['PRINT_VALUE'].'</span>';
				elseif( $pr_max = i_price($arResult['PRICES'], $arResult['MIN_PRICE']['DISCOUNT_VALUE']) )// или вычислим самую наибольшую цену
					$sum .= '<span class="icard_pr_disc">Старая цена: '.$arResult['PRICES'][$pr_max]['PRINT_VALUE'].'</span>';

				$sum .= '<span class="icard_pr">'.$pr[0].'</span>&nbsp;<span class="icard_tg">'.$pr[1].'</span>';

			else:
				$sum .= '<div class="icard_noprice">Нет цены.</div>';
			endif;

			$sum .= '</div>';
	}

	echo $sum;

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
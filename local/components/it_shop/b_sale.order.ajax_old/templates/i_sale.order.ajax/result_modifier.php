<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
//Объединение свойств
$arResult['I_ORDER_PROP'] = ilab_sort_prop( $arResult['ORDER_PROP']['USER_PROPS_Y'], $arResult['ORDER_PROP']['USER_PROPS_N'] );
// breadcrumb
if( CSite::InDir(SITE_DIR.'personal/order.php') )
{
	global $APPLICATION;
	$APPLICATION->AddChainItem('Корзина', SITE_DIR.'personal/basket.php');
	$APPLICATION->AddChainItem($APPLICATION->GetTitle(), SITE_DIR.'personal/order.php');
}

// Службы доставки
$arResult['I_DELIVERY'] = CSaleDelivery::GetByID($arResult['ORDER']['DELIVERY_ID']);
// Состав заказа
$res = CSaleBasket::GetList(
	array(),
	array(
		'FUSER_ID'	=> CSaleBasket::GetBasketUserID(),
		'LID'		=> SITE_ID,
		'ORDER_ID'	=> $arResult['ORDER_ID']
	),
	false,
	false,
	array('ID', 'PRODUCT_ID', 'QUANTITY', 'PROPS', 'PRICE', 'CURRENCY', 'LID', 'NAME', 'IBLOCK_ID')
);
while ($obj = $res->Fetch())
{
	$arResult['I_BASK'][$obj['PRODUCT_ID']] = $obj;
	$arIdSec[]								= $obj['PRODUCT_ID'];

	// Выведем свойства элемента корзины
	/*$db = CSaleBasket::GetPropsList( array(),array('BASKET_ID' => $obj['ID']) );
	while ($ob = $db->Fetch())
	{
		$arBask[$obj['PRODUCT_ID']]['PROPS'][] = array(
			'NAME'	=> $ob['NAME'],
			'CODE'	=> $ob['CODE'],
			'VALUE'	=> $ob['VALUE'],
			'SORT'	=> $ob['SORT']
		);
	}*/
}

if($arIdSec)
{
	$res = CIBlockElement::GetElementGroups($arIdSec);
	while($obj = $res->Fetch())
		$arResult['I_PRODUCT_SECTION'][$obj['IBLOCK_ELEMENT_ID']] = $obj;
}?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
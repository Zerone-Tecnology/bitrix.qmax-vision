<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$lid = $_POST['lid'];

	if( !CModule::IncludeModule('sale') )
		return;

	// Выведем сумму в корзине для текущего пользователя
	$arFilter = array('FUSER_ID'=>CSaleBasket::GetBasketUserID(), 'LID'=>$lid, 'ORDER_ID'=>'NULL');
	$arSelect = array('ID', 'PRICE', 'QUANTITY', 'VAT_RATE');

	$sum	= 0;// Общая сумма
	$nds	= 0;// НДС
	$cou	= 0;// кол-во
	$cur	= CCurrency::GetBaseCurrency();;

	$res = CSaleBasket::GetList( array(), $arFilter, false, false, array());
	while ($ob = $res->Fetch())
		if($ob['DELAY'] == 'N' && $ob['CAN_BUY'] == 'Y')
		{
			$sum	+= $ob['QUANTITY']*$ob['PRICE'];
			$nds	+= roundEx(  (($ob['PRICE'] / ($ob['VAT_RATE'] +1)) * $ob['VAT_RATE']) * $ob['QUANTITY']  , SALE_VALUE_PRECISION);
			$cou	+= $ob['QUANTITY'];
			$cur	 = $ob['CURRENCY'];
		}

	echo mb_substr(CurrencyFormat($sum, $cur),0,-4).'|'.$nds.'|'.$cou;

}else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
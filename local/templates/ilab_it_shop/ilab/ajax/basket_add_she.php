<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
/*	Нельзя просто взять и по id положить в корзину...
	---------------------------------------------------------------------------------------------------- iLaB PowereD */
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	if( !CModule::IncludeModule('catalog') || !CModule::IncludeModule('sale') )
		return;

	$id					= intval( $_POST['id'] );
	$quan				= floatval( $_POST['quan'] );
	$type				= $_POST['type'];
	$field['LID']		= $_POST['lid'];

	if( $_POST['sku_code'] )
		$sku_code	= array_flip(explode('↕', $_POST['sku_code']));

	$res = CIBlockElement::GetByID( $id );// Если есть такой товар впринцепи
	if( $ob = $res->GetNextElement() )
	{
		$obj		= $ob->GetFields();
		$obj['PRO']	= $ob->GetProperties();

		$params	= array();
		// Add SKU PROPS in basket
		if( $obj['PRO']['CML2_LINK']['VALUE'] )
		{
			require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');

			$arr	= array_intersect_key($obj['PRO'], $sku_code);
			$params	= ilab_getSkuPropsData($arr);
		}

		$res = CSaleBasket::GetList(array(), array('FUSER_ID'=>CSaleBasket::GetBasketUserID(), 'LID'=>$field['LID'], 'ORDER_ID'=>'NULL'),false,false,array('ID', 'PRODUCT_ID'));
		while ($ob = $res->Fetch())
			if( $id==$ob['PRODUCT_ID'] )// Если товар в корзине
				$item = $ob['ID'];

		$result	= 'N';

		if( !$item )// Если товара нет в корзине
		{
//			old function 2015 ilab
			/*$field += array(
				'PRODUCT_ID'	=> $obj['ID'],
//				'PRICE'			=> 100,
//				'CURRENCY'		=> 'USD',
//				'NAME'			=> 'абракадабра',//$obj['NAME'],
			);
//			print_r($field);
			$item	= Add2BasketByProductID( $id, $quan, $field, $params);// Добавим*/

			// lang NAME
//			if( $obj['PRO']['I_NAME_'.$l]['VALUE'] )
//				$obj['NAME']	= $obj['PRO']['I_NAME_'.$l]['VALUE'];

			// Вес товара
			$obj['WEIGHT'] = 0;
			$res = CCatalogProduct::GetList(array(),array('ID'=>$obj['ID']),false,array('nTopCount'=>1),array('WEIGHT', 'QUANTITY'));
			if ($pob = $res->Fetch())
			{
				$obj['WEIGHT'] = $pob['WEIGHT'];
				$obj['QUANTITY'] = $pob['QUANTITY'];
			}

			// QUANTITY
			if( 0<$obj['QUANTITY'] && $quan>$obj['QUANTITY'] )
				$quan = $obj['QUANTITY'];

			// PRICE/CURRENCY
			$arParams = array(
				'PRODUCT_ID'	=> $obj['ID'],
				'QUANTITY'		=> $quan,
				'USER_ID'		=> $USER->GetID(),
				'SITE_ID'		=> $field['LID'],
			);

			if( $type=='Y' )
				$arParams['CHECK_QUANTITY'] = 'N';

			$proData = CCatalogProductProvider::GetProductData($arParams);
/*
echo '<pre>';
print_r($arParams);
print_r($proData);
echo '</pre>';
*/
			// add basket
			$field['PROPS'] = $params;
			$field += array(
				'PRODUCT_ID'				=> $obj['ID'],
				'PRICE'						=> $proData['PRICE'],
				'CURRENCY'					=> $proData['CURRENCY'],
				'QUANTITY'					=> $quan,
				'NAME'						=> $obj['NAME'],
				'DETAIL_PAGE_URL'			=> $obj['DETAIL_PAGE_URL'],
				'PRODUCT_XML_ID'			=> $obj['XML_ID'],// - внешний код товара (необходим при обмене заказами с 1С);
				'CATALOG_XML_ID'			=> $obj['IBLOCK_ID'],// - внешний код каталога (необходим при обмене заказами с 1С);
				'MODULE'					=> 'catalog',
				'VAT_RATE'					=> $proData['VAT_RATE'],
				'WEIGHT'					=> $obj['WEIGHT'],
			);

			if( $type=='N' )
				$field['PRODUCT_PROVIDER_CLASS'] = 'CCatalogProductProvider';
//			print_r($field);

			$item	= CSaleBasket::Add($field);
			$result	= 'Y';
		}

		if( CSaleBasket::Update($item, array('DELAY'=>$type, 'LID'=>$field['LID'])) )// Функция обновление товара корзины в отложенные
			echo $item;
	}
}
else
	echo 'DataError';
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>

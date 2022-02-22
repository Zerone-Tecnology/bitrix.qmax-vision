<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Loader,
	Bitrix\Main\Application,
	Bitrix\Sale;
// ---------------------------------------------------------------------------------------------------- iLaB
if ( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['FPRO_KEY']=='45gsiLab+1qUicK' )
{
	require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');
	if( !Loader::includeModule("sale") || !Loader::includeModule("sale") )
		return;

// ---------------------------------------------------------------------------------------------------- $_POST
	$phone = htmlspecialchars($request->getPost('telephone'));
	$email = htmlspecialchars($request->getPost('email'));
	$username = htmlspecialchars($request->getPost('name'));
	$lid = htmlspecialchars($request->getPost('lid'));
	$id = explode('|', htmlspecialchars($request->getPost('id')));
	$params = explode('|', htmlspecialchars($request->getPost('params')));
// ---------------------------------------------------------------------------------------------------- $_POST

// ---------------------------------------------------------------------------------------------------- Setting
	$arParams['SHOW_PRICE_COUNT']	= 1; // default Выводить цены для количества
	$arParams['PRICE_VAT_INCLUDE']	= 'Y'; // default Включать НДС в цену 
	$arParams['IBLOCK_ID']			= $id[0];
// ---------------------------------------------------------------------------------------------------- Setting

	$response = CIBlockElement::GetByID( $id );// Если есть такой товар впринцепи
	if( $object = $response->Fetch() )// Если id товара есть
	{
		// Выберем типы цен доступные авторизованному пользователю --------PRICE
		$res = CCatalogGroup::GetList(array('SORT' => 'ASC'),array('CAN_ACCESS' => 'Y'));
		while ($ob = $res->Fetch())
			$arPricecode[] = $ob['NAME'];

		$arSelect = Array('ID', 'NAME', 'IBLOCK_ID', 'QUANTITY');
		$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'],'ID'=>$id[1]);

		// Выберем параметры типов цен, и добавляем их в arSelect и arFilter
		// Так же функция нужна для правильной отработки функции CIBlockPriceTools::GetItemPrices --------PRICE
		$arPrices = CIBlockPriceTools::GetCatalogPrices($id[0], $arPricecode);
		foreach($arPrices as $value)
		{
			$arSelect[] = $value['SELECT'];
			$arFilter['CATALOG_SHOP_QUANTITY_'.$value['ID']] = $arParams['SHOW_PRICE_COUNT'];
		}

		// Вытащим товар 'Быстрого заказа'
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNext())
		{
			$arItem = $ob;
			$arItem['PRICES'] = CIBlockPriceTools::GetItemPrices($arParams['IBLOCK_ID'], $arPrices, $ob, $arParams['PRICE_VAT_INCLUDE']);
			if (!empty($arItem['PRICES']))
			{
				foreach ($arItem['PRICES'] as &$arOnePrice)
				{
					if ('Y' == $arOnePrice['MIN_PRICE'])
					{
						$arItem['MIN_PRICE'] = $arOnePrice;
						break;
					}
				}
				unset($arOnePrice);
			}
		}

//		$siteid			= SITE_ID;
		$persontype		= $params[0];// Тип плательщика		--------------- (Физ. лицо)
		$payment		= $params[1];// Платёжный системы	--------------- (Оплата наличными при получении заказа)
		$delivery		= $params[2];// Службы Доставки		--------------- (Самовывоз со склада или магазина в г. Алматы)
		$currency		= $arItem['MIN_PRICE']['CURRENCY'];// Валюта (KZT)

//		$email			= (strlen($email)>0) ? $email : 'fastorder@itsklad.kz';
//		$productid		= intval($_POST['productid']);
		$quantity		= 1;// Количество товара	--------------- (1)
		$price			= $arItem['MIN_PRICE']['DISCOUNT_VALUE'];// Цена
//		$pricedelivery	= ($price < 14900) ? 500 : 0;
		$new_password	= randString(7);// Генерируем пароль
		$summ			= $price/* + $pricedelivery*/;

		// проверка на наличие аккаунта
		$resUser = CUser::GetList($by = 'ID', $sort = 'asc', array('EMAIL'=>$email));
		if($ob = $resUser->Fetch())// Авторизован
			$USERID = $ob['ID'];
		else{// Не авторизован - новый пользователь
			$USER->Logout();

			$user = new CUser;
			$arFields = Array(
				'NAME'				=> $username,
				'EMAIL'				=> $email,
				'LOGIN'				=> $email,
				'LID'				=> $lid,
				'ACTIVE'			=> 'Y',
				'GROUP_ID'			=> array(7),
				'PASSWORD'			=> $new_password,
				'CONFIRM_PASSWORD'	=> $new_password,
			);
			$USERID = $user->Add($arFields);

			$USER->Login($email, $new_password, 'Y');
		}

		// новый заказ
		if( intval($USERID)>0 )
		{
			$arFields = array(
				'LID'				=> $lid,
				'PERSON_TYPE_ID'	=> $persontype,
				'PAYED'				=> 'N',
				'CANCELED'			=> 'N',
				'STATUS_ID'			=> 'N',
				'PRICE'				=> $summ,
				'CURRENCY'			=> $currency,
				'USER_ID'			=> $USERID,
				'PAY_SYSTEM_ID'		=> $payment,
//				'PRICE_DELIVERY'	=> $pricedelivery,
				'DELIVERY_ID'		=> $delivery,
				'DISCOUNT_VALUE'	=> 0,
				'TAX_VALUE'			=> 0,
				'USER_DESCRIPTION'	=> 'Заказать товар',
				'ADDITIONAL_INFO'	=> 'Телефон - '.$phone.', E-mail -'.$email.', Имя -'.$username,
			);

			if (CModule::IncludeModule('statistic'))
				$arFields['STAT_GID'] = CStatistic::GetEventParam();

			$ORDER_ID = (int) CSaleOrder::Add($arFields);// Добавим новый заказ

			ilab_AddOrderProperty('MOBILE_TELEPHONE_s1',	$phone,		$ORDER_ID);
			ilab_AddOrderProperty('EMAIL_s1',				$email,		$ORDER_ID);
			ilab_AddOrderProperty('NAME_s1',				$username,	$ORDER_ID);

			$res = CSaleBasket::GetList(
				array(),
				array(
					'FUSER_ID'	=> CSaleBasket::GetBasketUserID(),
					'LID'		=> $lid,
					'ORDER_ID'	=> 'NULL'
				),
				false,
				false,
				array('ID', 'PRODUCT_ID', 'QUANTITY', 'PROPS', 'PRICE', 'CURRENCY', 'LID', 'NAME')
			);
			while ($obj = $res->Fetch())
			{
				$arBask[$obj['PRODUCT_ID']] = $obj;

				// Выведем свойства элемента корзины
				$db = CSaleBasket::GetPropsList( array(),array('BASKET_ID' => $obj['ID']) );
				while ($ob = $db->Fetch())
				{
					$arBask[$obj['PRODUCT_ID']]['PROPS'][] = array(
						'NAME'	=> $ob['NAME'],
						'CODE'	=> $ob['CODE'],
						'VALUE'	=> $ob['VALUE'],
						'SORT'	=> $ob['SORT']
					);
				}
			}

			foreach($arBask as $e)
				CSaleBasket::Delete($e['ID']);

//			CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID(), false);// Удалим все записи с корзины

			$arFields = array(
				'LID'			=> $lid,
				'PRODUCT_ID'	=> $id[1],
				'PRICE'			=> $arItem['MIN_PRICE']['DISCOUNT_VALUE'],
				'CURRENCY'		=> $arItem['MIN_PRICE']['CURRENCY'],
				'NAME'			=> $arItem['NAME'],
				'ORDER_ID'		=> $ORDER_ID
			);

			// корзина заказа
			$result = false;
			$result = Add2BasketByProductID($id[1], $quantity, $arFields, array());

			if( $result )
			{
				$strOrderList = '';
				$arBasketList = array();
				$dbBasketItems = CSaleBasket::GetList(
						array('ID' => 'ASC'),
						array('ORDER_ID' => $ORDER_ID),
						false,
						false,
						array('ID', 'PRODUCT_ID', 'NAME', 'QUANTITY', 'PRICE', 'CURRENCY', 'TYPE', 'SET_PARENT_ID')
					);
				while ($arItem = $dbBasketItems->Fetch())
				{
					if (CSaleBasketHelper::isSetItem($arItem))
						continue;

					$arBasketList[] = $arItem;
				}

				$arBasketList = getMeasures($arBasketList);

				foreach ($arBasketList as $arItem)
					$strOrderList .= $arItem['NAME'].' - '.$arItem['QUANTITY'].' шт.: '.SaleFormatCurrency($arItem['PRICE'], $arItem['CURRENCY'])."\n";

/*
				#ORDER_ID#		- код заказа
				#ORDER_DATE#	- дата заказа
				#ORDER_USER#	- заказчик
				#PRICE#			- сумма заказа
				#EMAIL#			- E-Mail заказчика
				#BCC#			- E-Mail скрытой копии
				#ORDER_LIST#	- состав заказа
				#SALE_EMAIL#	- E-Mail отдела продаж
*/

				$arFields = Array(
					'ORDER_ID'			=> $ORDER_ID,
					'ORDER_DATE'		=> Date($DB->DateFormatToPHP(CLang::GetDateFormat('SHORT', SITE_ID))),
					'ORDER_USER'		=> $username,
					'PRICE'				=> SaleFormatCurrency($summ, $currency),
					'EMAIL'				=> $email,
					'BCC'				=> COption::GetOptionString('sale', 'order_email', 'order@'.$SERVER_NAME),
					'ORDER_LIST'		=> $strOrderList,
					'SALE_EMAIL'		=> COption::GetOptionString('sale', 'order_email', 'order@'.$SERVER_NAME),
				);

				$eventName = 'SALE_NEW_ORDER';

				$bSend = true;
				foreach(GetModuleEvents('sale', 'OnOrderNewSendEmail', true) as $arEvent)
					if (ExecuteModuleEventEx($arEvent, Array($ORDER_ID, &$eventName, &$arFields))===false)
						$bSend = false;

				if($bSend)
				{
					$event = new CEvent;
					$event->Send($eventName, $lid, $arFields, 'Y');
				}

			}

			if( $arBask )
				foreach ($arBask as $k=>$e)
					Add2BasketByProductID( $e['PRODUCT_ID'], $e['QUANTITY'], $e, array() );// Добавим

			return $result;
		}else
			return 'UserAddError';

	}
}else
	return 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
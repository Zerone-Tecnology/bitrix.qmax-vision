<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application,
	Bitrix\Main\Loader,
	Bitrix\Main\Mail\Event,
	Bitrix\Sale\Delivery,
	Bitrix\Sale\PaySystem,
	Bitrix\Sale\Order,
	Bitrix\Sale\Basket;

global $USER;

// ---------------------------------------------------------------------------------------------------- iLaB

if ( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['FPRO_KEY']=='45gsiLab+1qUicK' )
{
	require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');

	Loader::includeModule('iblock');
	Loader::includeModule('sale');
	Loader::includeModule('catalog');

	$request = Application::getInstance()->getContext()->getRequest();

	$phone = htmlspecialchars($request->getPost('telephone'));
	$email = htmlspecialchars($request->getPost('email'));
	$username = htmlspecialchars($request->getPost('name'));
	$lid = htmlspecialchars($request->getPost('lid'));
	$id = explode('|', htmlspecialchars($request->getPost('id')));
	$params = explode('|', htmlspecialchars($request->getPost('params')));

	$persontype	= $params[0]; // Тип плательщика --------------- (Физ. лицо)
	$paymentID = $params[1]; // Платёжный системы --------------- (Оплата наличными при получении заказа)
	$deliveryID = $params[2]; // Службы Доставки -------------- (Самовывоз со склада или магазина в г. Алматы)

	$arParams['SHOW_PRICE_COUNT']	= 1; // default Выводить цены для количества
	$arParams['PRICE_VAT_INCLUDE']	= 'Y'; // default Включать НДС в цену
	$arParams['IBLOCK_ID']			= $id[0];

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

	$price = $arItem['MIN_PRICE']['DISCOUNT_VALUE'];
	$new_password	= randString(7);// Генерируем пароль
	$sum = $price;

	if( $arItem )
	{
		// проверка на наличие аккаунта
		$resUser = CUser::GetList($by = 'ID', $sort = 'asc', array('EMAIL'=>$email));
		if($ob = $resUser->Fetch()) // Авторизован
		{
			$USERID = $ob['ID'];
		}
		else
		{ 	// Не авторизован - новый пользователь
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

		if( intval($USERID)>0 )
		{
			if( Loader::includeModule('statistic') )
				$arFields['STAT_GID'] = CStatistic::GetEventParam();

			// ------------------------------------------------------- Получение корзины текущего пользователя ----
			$basket = Basket::loadItemsForFUser($USERID, $lid);

			// ------------------------------------------------------- Удаление всех товаров из корзины -----------
			foreach ($basket as $basketItem) {
				if( $basketItem->getField('ID') )
					$delete = $basket->getItemById( $basketItem->getField('ID') )->delete();
			}
			$basket->save();

			// ------------------------------------------------------- Добавление товара из быстрого заказа -------
			$item = $basket->createItem('catalog', $id[1]);
			$item->setFields(array(
				'QUANTITY' => 1,
				'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
				'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
				'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
			));
			$basket->save();

			// ------------------------------------------------------- Создание заказа ----------------------------
			$order = Order::create($lid, $USERID);

			// ------------------------------------------------------- Тип плательщика ----------------------------
			$order->setPersonTypeId($persontype);

			// ------------------------------------------------------- Прикрепление корзины -----------------------
			$order->setBasket($basket);

			$currency = 'KZT';
			$price = $basket->getPrice();
			$sum = $price;

			// ------------------------------------------------------- Устанавливаем свойства ---------------------
			$order->setField('LID', $lid);
			$order->setField('CANCELED', 'N');
			$order->setField('STATUS_ID', 'Z');
			$order->setField('PRICE', $sum);
			$order->setField('CURRENCY', $currency);
			$order->setField('USER_ID', $USERID);
			$order->setField('DISCOUNT_VALUE', 0);
			$order->setField('TAX_VALUE', 0);
			$order->setField('USER_DESCRIPTION', 'Заказать товар');
			$order->setField('ADDITIONAL_INFO', 'Телефон - '.$phone.', E-mail - '.$email.', Имя - '.$username);

			// ------------------------------------------------------- Устанавливаем способ доставки --------------
			$shipmentCollection = $order->getShipmentCollection();
			$shipment = $shipmentCollection->createItem();
			$service = Delivery\Services\Manager::getById($deliveryID);
			$shipment->setFields(array(
				'DELIVERY_ID' => $service['ID'],
				'DELIVERY_NAME' => $service['NAME'],
			));

			// ------------------------------------------------------- Устанавливаем способ оплаты ----------------
			$paymentCollection = $order->getPaymentCollection();
			$payment = $paymentCollection->createItem();
			$paySystemService = PaySystem\Manager::getObjectById($paymentID);
			$payment->setFields(array(
				'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
				'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
			));

			// ------------------------------------------------------- Устанавливаем другие свойства --------------
			$order->doFinalAction(true);

			function getPropertyByCode($propertyCollection, $code)
			{
				foreach ($propertyCollection as $property)
					if ($property->getField('CODE') == $code)
						return $property;
			}

			$propertyCollection = $order->getPropertyCollection();

			$emailProperty = getPropertyByCode($propertyCollection, 'EMAIL_s1');
			$emailProperty->setValue($email);

			// TELEPHONE_s1 inactive order properties
//			$phoneProperty = getPropertyByCode($propertyCollection, 'TELEPHONE_s1');
//			$phoneProperty->setValue($phone);

			$mobilePhoneProperty = getPropertyByCode($propertyCollection, 'MOBILE_TELEPHONE_s1');
			$mobilePhoneProperty->setValue($phone);

			$nameProperty = getPropertyByCode($propertyCollection, 'NAME_s1');
			$nameProperty->setValue($username);

			// ------------------------------------------------------- Сохранение заказа --------------------------
			$result = $order->save();

			if (!$result->isSuccess())
			{
				$arResult['error'] = $result->getErrors();
			}
			else
			{
				$arResult['orderid'] = $result->getId();
				Event::send(array(
					"EVENT_NAME" => "SALE_NEW_ORDER",
					"LID" => $lid,
					"C_FIELDS" => array(
						"ORDER_ID" => $arResult['orderid'],
						"ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat('SHORT', 'RU'))),
						"ORDER_USER" => $username,
						"PRICE" => SaleFormatCurrency($sum, $currency),
						"EMAIL" => $email,
						'BCC'				=> COption::GetOptionString('sale', 'order_email', 'order@'.$SERVER_NAME),
						'ORDER_LIST'		=> $strOrderList,
						'SALE_EMAIL'		=> COption::GetOptionString('sale', 'order_email', 'order@'.$SERVER_NAME),
					),
				));
				$arResult['status'] = true;
			}
		}
	}
}
else $arResult['error'] = 'dataerror';

echo json_encode($arResult);

// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>

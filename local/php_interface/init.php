<?
use	Bitrix\Main\Loader,
	Bitrix\Main\EventManager,
	Bitrix\Main\Diag\Debug,
	Bitrix\Main\Application,
	Bitrix\Main\Web\Cookie,
	Bitrix\Main\Context,
	Bitrix\Sale,
	Bitrix\Highloadblock as HL;

/* ---------------------------------------------------------------------------------------------------- ilab.kernel */
$eventManager = EventManager::getInstance();
$eventManager->addEventHandlerCompatible('main', 'OnBeforeProlog', 'MyOnBeforePrologHandlerIlabKernel');

function MyOnBeforePrologHandlerIlabKernel()
{
	if( Bitrix\Main\Loader::includeModule('ilab.kernel') && PHP_SAPI != 'cli' )
	{
//		$start = microtime(true);

		$basket = array(
			// SITE_DIR.'personal/test.php',
			SITE_DIR.'personal/basket.php',
			SITE_DIR.'personal/order.php'
		);
		ilab\kernel\ilab\css::$exclude = array(
			'main' => array(
				'EX' => $basket
			),
			'basket' => $basket
		);

//		new ilab\kernel\init(SITE_TEMPLATE_PATH.'/ilab/');

//		$time = microtime(true) - $start;
//		printf('Скрипт выполнялся %.4F сек.', $time);
	}
}
/* ---------------------------------------------------------------------------------------------------- ilab.kernel */

/*Version 0.3 2011-04-25*/
AddEventHandler('iblock',	'OnAfterIBlockElementUpdate',	'DoIBlockAfterSave');
AddEventHandler('iblock',	'OnAfterIBlockElementAdd',		'DoIBlockAfterSave');
AddEventHandler('catalog',	'OnPriceAdd',					'DoIBlockAfterSave');
AddEventHandler('catalog',	'OnPriceUpdate',				'DoIBlockAfterSave');

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler('sale', 'OnSaleOrderSaved', 'SendSms');
$eventManager->addEventHandler('sale', 'OnSaleOrderPaid', 'SendSmsPaid');
$eventManager->addEventHandler('sale', 'OnSaleOrderCanceled', 'SendSmsCanceled');

// регистрируем обработчик события "OnAfterUserRegister"
AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserUpdateHandler");

AddEventHandler("main", "OnBeforeProlog", "MyOnBeforePrologHandler", 50);

function MyOnBeforePrologHandler()
{
	if( $_SERVER['SCRIPT_NAME'] == '/local/templates/ilab_it_shop/ilab/ajax/fast_order.php' )
	{
		$data = array();
		$data['name'] = htmlspecialchars($_REQUEST['name']);
		$data['telephone'] = htmlspecialchars($_REQUEST['telephone']);
		$data['email'] = htmlspecialchars($_REQUEST['email']);
		$data['id'] = htmlspecialchars($_REQUEST['id']);
		$data['lid'] = htmlspecialchars($_REQUEST['lid']);
		$data['params'] = htmlspecialchars($_REQUEST['params']);

		if( $data['name'] || $data['email'] || $data['telephone'] )
		{
			if( Loader::includeModule("highloadblock") )
			{
				$hlblock_id = 3;
				$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlblock_id)->fetch();
				$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
				$entity_data_class = $entity->getDataClass();
				$arAdd = array(
					'UF_NAME' => $data['name'],
					'UF_PHONE' => $data['telephone'],
					'UF_EMAIL' => $data['email'],
					'UF_ID' => $data['id'],
					'UF_DATE' => date('Y-m-d H:i:s')
				);
				$entity_data_class::add($arAdd);
			}
		}
	}

	$utm_source = htmlspecialchars($_REQUEST['utm_source']);
	$utm_medium = htmlspecialchars($_REQUEST['utm_medium']);
	$utm_campaign = htmlspecialchars($_REQUEST['utm_campaign']);
	if( $utm_source && $utm_medium && $utm_campaign )
	{
		$_SESSION['utm_source'] = $utm_source;
		$_SESSION['utm_medium'] = $utm_medium;
		$_SESSION['utm_campaign'] = $utm_campaign;
	}
}



// регистрируем обработчик события на изменения цены определенного товара
// AddEventHandler('iblock',	'OnAfterIBlockElementUpdate',	'OnPriceUpdateToLog');
// AddEventHandler("catalog", "OnPriceUpdate", "OnBeforePriceUpdateToLog");

/*
function OnBeforePriceUpdateToLog($ID, $arFields)
{
	$PRODUCT_ID = $arFields['PRODUCT_ID'];
	if($PRODUCT_ID == 72)
	{
		$arPriceType = array(
			'1' => 'Базовая',
			'2' => 'Оптовая',
			'3' => 'Розничная'
		);

		$mess =	'ID продукта - '.$PRODUCT_ID
				.' | Тип цены - '.$arPriceType[$arFields['CATALOG_GROUP_ID']]
				.' | ID цены - '.$ID
				.' | Цена - '.$arFields['PRICE']
		        .' | Дата изменения цены - '.date('d-m-Y H:m:s');

		\Bitrix\Main\Loader::includeModule('highloadblock');

		$hlb_ChangeProductPrices = 2;

		// значения HL ChangeProductPrices
		$hlblock_value = Bitrix\Highloadblock\HighloadBlockTable::getById($hlb_ChangeProductPrices)->fetch();
		$eCM = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock_value)->getDataClass();
		$data = array(
			'UF_PRODUCT_ID' => $PRODUCT_ID,
			'UF_PRICE_TYPE' => $arPriceType[$arFields['CATALOG_GROUP_ID']],
			'UF_PRICE_ID' => $ID,
			// 'UF_DATE' => date('Y-m-d H:i:s'),
			'UF_PRICE' => $arFields['PRICE']
		);
		$res = $eCM::add($data);

		Debug::dumpToFile($mess, '$debug', '/import/NewRegister.txt');
	}
}
*/

function OnBeforeUserUpdateHandler(&$arFields)
{
	if( !Context::getCurrent()->getRequest()->isAdminSection() )
	{
		$arFields["LOGIN"] = $arFields["EMAIL"];
		return $arFields;
	}
}
function OnAfterUserRegisterHandler(&$arFields)
{

	if( !Context::getCurrent()->getRequest()->isAdminSection() )
	{
		$rsUser = CUser::GetByLogin($arFields["LOGIN"]);
		$arUser = $rsUser->Fetch();

		$user = new CUser;
		$fields = Array(
			"LOGIN"          => $arFields["EMAIL"],
		);

		if ($user->Update($arUser['ID'], $fields) && (intval($arFields["ID"])>0) )
		{
			CEvent::Send(
				"MY_NEW_USER",
				"it",
				array(
					"LOGIN" => $arFields["EMAIL"],
					"EMAIL" => $arFields["EMAIL"],
					"PASSWORD" => $arFields["CONFIRM_PASSWORD"],
					"USER_ID" => $arFields["ID"],
					"NAME" => (trim ($arFields["NAME"]) == "")? $toSend["NAME"] = htmlspecialchars('<Не указано>'): $arFields["NAME"],
					"LAST_NAME" => (trim ($arFields["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = htmlspecialchars('<Не указано>'): $arFields["LAST_NAME"],
					"USER_IP" => $arFields["USER_IP"],
					"USER_HOST" => $arFields["USER_HOST"]
				)
			);
		}
		return $arFields;
	}
}


/** Отправляем СМС при новом заказе на номер, указанный покупателем. */
function SendSms(Bitrix\Main\Event $event)
{
	$order = $event->getParameter("ENTITY");
	$isNew = $event->getParameter("IS_NEW");

	$statusid = $order->getField('STATUS_ID');

	if($isNew)
	{
		$orderid = $order->getId();
		$sid = $order->getSiteId();

		if($sid == 'it') $code = 'MOBILE_TELEPHONE_s1';
		else $code = 'MOBILE_TELEPHONE_'.$sid;

		$dbOrderProps = CSaleOrderPropsValue::GetList(
			array("SORT" => "ASC"),
			array("ORDER_ID" => $orderid, "CODE"=>array($code))
		);

		if($arVals = $dbOrderProps->Fetch())
			if($arVals['CODE'] == $code)
				$phone = preg_replace('~[^0-9]+~','', $arVals['VALUE']);

		$message = 'adaptive.tmweb.ru - Ваш заказ принят. Номер заказа: ' . $orderid;

		Debug::dumpToFile(' ------------- При оформлении заказа ------ ', '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('ORDER_ID заказа - '.$orderid, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Город - '.$sid, '$debug', '/1_imp/SendSms.txt');
		Debug::dumpToFile('Код свойства телефона - '.$code, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Телефон пользователя - '.$phone, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Сообщение - '.$message, '$debug', '/import/SendSms.txt');
		// Debug::dumpToFile('Сообщение - '.$result, '$debug', '/import/SendSms.txt');
	}
	if($statusid == 'D')
	{
		$orderid = $order->getId();
		$sid = $order->getSiteId();

		if($sid == 'it') $code = 'MOBILE_TELEPHONE_s1';
		else $code = 'MOBILE_TELEPHONE_'.$sid;

		$dbOrderProps = CSaleOrderPropsValue::GetList(
			array("SORT" => "ASC"),
			array("ORDER_ID" => $orderid, "CODE"=>array($code))
		);

		if($arVals = $dbOrderProps->Fetch())
			if($arVals['CODE'] == $code)
				$phone = preg_replace('~[^0-9]+~','', $arVals['VALUE']);

		$message = 'adaptive.tmweb.ru - Ваш заказ готов к отгрузке. Номер заказа: ' . $orderid;

		Debug::dumpToFile(' ------------- При оформлении заказа ------ ', '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('ORDER_ID заказа - '.$orderid, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Город - '.$sid, '$debug', '/1_imp/SendSms.txt');
		Debug::dumpToFile('Код свойства телефона - '.$code, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Телефон пользователя - '.$phone, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Сообщение - '.$message, '$debug', '/import/SendSms.txt');
		// Debug::dumpToFile('Сообщение - '.$result, '$debug', '/import/SendSms.txt');
	}
}

function SendSmsPaid(Bitrix\Main\Event $event)
{
	$order = $event->getParameter("ENTITY");
	// $isNew = $event->getParameter("IS_NEW");

	if($order->isPaid())
	{
		$orderid = $order->getId();
		$sid = $order->getSiteId();

		if($sid == 'it') $code = 'MOBILE_TELEPHONE_s1';
		else $code = 'MOBILE_TELEPHONE_'.$sid;

		$dbOrderProps = CSaleOrderPropsValue::GetList(
			array("SORT" => "ASC"),
			array("ORDER_ID" => $orderid, "CODE"=>array($code))
		);

		if($arVals = $dbOrderProps->Fetch())
			if($arVals['CODE'] == $code)
				$phone = preg_replace('~[^0-9]+~','', $arVals['VALUE']);

		$message = 'adaptive.tmweb.ru - Ваш заказ оплачен. Номер заказа: ' . $orderid;

		Debug::dumpToFile(' ------------- При оформлении заказа ------ ', '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('ORDER_ID заказа - '.$orderid, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Город - '.$sid, '$debug', '/1_imp/SendSms.txt');
		Debug::dumpToFile('Код свойства телефона - '.$code, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Телефон пользователя - '.$phone, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Сообщение - '.$message, '$debug', '/import/SendSms.txt');
		// Debug::dumpToFile('Сообщение - '.$result, '$debug', '/import/SendSms.txt');
	}
}

function SendSmsCanceled(Bitrix\Main\Event $event)
{
	$order = $event->getParameter("ENTITY");
	// $isNew = $event->getParameter("IS_NEW");

	if($order->isCanceled())
	{
		$orderid = $order->getId();
		$sid = $order->getSiteId();

		if($sid == 'it') $code = 'MOBILE_TELEPHONE_s1';
		else $code = 'MOBILE_TELEPHONE_'.$sid;

		$dbOrderProps = CSaleOrderPropsValue::GetList(
			array("SORT" => "ASC"),
			array("ORDER_ID" => $orderid, "CODE"=>array($code))
		);

		if($arVals = $dbOrderProps->Fetch())
			if($arVals['CODE'] == $code)
				$phone = preg_replace('~[^0-9]+~','', $arVals['VALUE']);

		$message = 'adaptive.tmweb.ru - Ваш заказ отменен. Номер заказа: ' . $orderid;

		Debug::dumpToFile(' ------------- При оформлении заказа ------ ', '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('ORDER_ID заказа - '.$orderid, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Город - '.$sid, '$debug', '/1_imp/SendSms.txt');
		Debug::dumpToFile('Код свойства телефона - '.$code, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Телефон пользователя - '.$phone, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Сообщение - '.$message, '$debug', '/import/SendSms.txt');
		// Debug::dumpToFile('Сообщение - '.$result, '$debug', '/import/SendSms.txt');
	}
}

/*
function SendSmsDelivery(Bitrix\Main\Event $event)
{
	$orderObj = $event->getParameter("ENTITY");

	if($orderObj->isAllowDelivery())
	{
		$orderid = $orderObj->getField('ORDER_ID');

		$arOrder = CSaleOrder::GetByID($orderid);

		$sid = $arOrder['LID'];

		if($sid == 'it') $code = 'MOBILE_TELEPHONE_s1';
		else $code = 'MOBILE_TELEPHONE_'.$sid;

		$dbOrderProps = CSaleOrderPropsValue::GetList(
			array("SORT" => "ASC"),
			array("ORDER_ID" => $orderid, "CODE"=>array($code))
		);

		if($arVals = $dbOrderProps->Fetch())
			if($arVals['CODE'] == $code)
				$phone = preg_replace('~[^0-9]+~','', $arVals['VALUE']);

		$message = 'adaptive.tmweb.ru - Ваш заказ готов к отгрузке. Номер заказа: ' . $orderid;

		Debug::dumpToFile(' ------------- При оформлении заказа ------ ', '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('ORDER_ID заказа - '.$orderid, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Город - '.$sid, '$debug', '/1_imp/SendSms.txt');
		Debug::dumpToFile('Код свойства телефона - '.$code, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Телефон пользователя - '.$phone, '$debug', '/import/SendSms.txt');
		Debug::dumpToFile('Сообщение - '.$message, '$debug', '/import/SendSms.txt');
		// Debug::dumpToFile('Сообщение - '.$result, '$debug', '/import/SendSms.txt');
	}
	else
	{
		Debug::dumpToFile('Не работает', '$debug', '/import/SendSms.txt');
	}
}*/

function DoIBlockAfterSave($arg1, $arg2 = false)
{
	$ELEMENT_ID = false;
	$IBLOCK_ID = false;
	$OFFERS_IBLOCK_ID = false;
	$OFFERS_PROPERTY_ID = false;
	if (CModule::IncludeModule('currency'))
		$strDefaultCurrency = CCurrency::GetBaseCurrency();

	//Check for catalog event
	if(is_array($arg2) && $arg2['PRODUCT_ID'] > 0)
	{
		//Get iblock element
		$rsPriceElement = CIBlockElement::GetList(
			array(),
			array(
				'ID' => $arg2['PRODUCT_ID'],
			),
			false,
			false,
			array('ID', 'IBLOCK_ID')
		);
		if($arPriceElement = $rsPriceElement->Fetch())
		{
			$arCatalog = CCatalog::GetByID($arPriceElement['IBLOCK_ID']);
			if(is_array($arCatalog))
			{
				//Check if it is offers iblock
				if($arCatalog['OFFERS'] == 'Y')
				{
					//Find product element
					$rsElement = CIBlockElement::GetProperty(
						$arPriceElement['IBLOCK_ID'],
						$arPriceElement['ID'],
						'sort',
						'asc',
						array('ID' => $arCatalog['SKU_PROPERTY_ID'])
					);
					$arElement = $rsElement->Fetch();
					if($arElement && $arElement['VALUE'] > 0)
					{
						$ELEMENT_ID = $arElement['VALUE'];
						$IBLOCK_ID = $arCatalog['PRODUCT_IBLOCK_ID'];
						$OFFERS_IBLOCK_ID = $arCatalog['IBLOCK_ID'];
						$OFFERS_PROPERTY_ID = $arCatalog['SKU_PROPERTY_ID'];
					}
				}
				//or iblock which has offers
				elseif($arCatalog['OFFERS_IBLOCK_ID'] > 0)
				{
					$ELEMENT_ID = $arPriceElement['ID'];
					$IBLOCK_ID = $arPriceElement['IBLOCK_ID'];
					$OFFERS_IBLOCK_ID = $arCatalog['OFFERS_IBLOCK_ID'];
					$OFFERS_PROPERTY_ID = $arCatalog['OFFERS_PROPERTY_ID'];
				}
				//or it's regular catalog
				else
				{
					$ELEMENT_ID = $arPriceElement['ID'];
					$IBLOCK_ID = $arPriceElement['IBLOCK_ID'];
					$OFFERS_IBLOCK_ID = false;
					$OFFERS_PROPERTY_ID = false;
				}
			}
		}
	}
	//Check for iblock event
	elseif(is_array($arg1) && $arg1['ID'] > 0 && $arg1['IBLOCK_ID'] > 0)
	{
		//Check if iblock has offers
		$arOffers = CIBlockPriceTools::GetOffersIBlock($arg1['IBLOCK_ID']);
		if(is_array($arOffers))
		{
			$ELEMENT_ID = $arg1['ID'];
			$IBLOCK_ID = $arg1['IBLOCK_ID'];
			$OFFERS_IBLOCK_ID = $arOffers['OFFERS_IBLOCK_ID'];
			$OFFERS_PROPERTY_ID = $arOffers['OFFERS_PROPERTY_ID'];
		}
	}

	if($ELEMENT_ID)
	{
		static $arPropCache = array();
		if(!array_key_exists($IBLOCK_ID, $arPropCache))
		{
			//Check for MINIMAL_PRICE property
			$rsProperty = CIBlockProperty::GetByID('MINIMUM_PRICE', $IBLOCK_ID);
			$arProperty = $rsProperty->Fetch();
			if($arProperty)
				$arPropCache[$IBLOCK_ID] = $arProperty['ID'];
			else
				$arPropCache[$IBLOCK_ID] = false;
		}

		if($arPropCache[$IBLOCK_ID])
		{
			//Compose elements filter
			if($OFFERS_IBLOCK_ID)
			{
				$rsOffers = CIBlockElement::GetList(
					array(),
					array(
						'IBLOCK_ID' => $OFFERS_IBLOCK_ID,
						'PROPERTY_'.$OFFERS_PROPERTY_ID => $ELEMENT_ID,
					),
					false,
					false,
					array('ID')
				);
				while($arOffer = $rsOffers->Fetch())
					$arProductID[] = $arOffer['ID'];

				if (!is_array($arProductID))
					$arProductID = array($ELEMENT_ID);
			}
			else
				$arProductID = array($ELEMENT_ID);

			$minPrice = false;
			$maxPrice = false;
			//Get prices
			$rsPrices = CPrice::GetList(
				array(),
				array(
					'PRODUCT_ID' => $arProductID,
				)
			);
			while($arPrice = $rsPrices->Fetch())
			{
				if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY'])
					$arPrice['PRICE'] = CCurrencyRates::ConvertCurrency($arPrice['PRICE'], $arPrice['CURRENCY'], $strDefaultCurrency);

				$PRICE = $arPrice['PRICE'];

				if($minPrice === false || $minPrice > $PRICE)
					$minPrice = $PRICE;

				if($maxPrice === false || $maxPrice < $PRICE)
					$maxPrice = $PRICE;
			}

			//Save found minimal price into property

			/* OLD
			if($minPrice !== false)
			{
				CIBlockElement::SetPropertyValuesEx(
					$ELEMENT_ID,
					$IBLOCK_ID,
					array(
						'MINIMUM_PRICE' => $minPrice,
						'MAXIMUM_PRICE' => $maxPrice,
					)
				);
			}*/

			if($minPrice !== false)
			{
				$PROPERTY_VALUES = [
					'MINIMUM_PRICE' => $minPrice,
					'MAXIMUM_PRICE' => $maxPrice,
				];
			} else {
				$PROPERTY_VALUES = [
					'MINIMUM_PRICE' => '',
					'MAXIMUM_PRICE' => '',
				];
			}

			CIBlockElement::SetPropertyValuesEx(
				$ELEMENT_ID,
				$IBLOCK_ID,
				$PROPERTY_VALUES
			);
		}
	}
}

/*
// Выгрузка из 1С характеристик торговых предложений в отдельные свойства v1.0
AddEventHandler('iblock', 'OnAfterIBlockElementUpdate', Array('EXT1C', 'ATTRIBUTES2PROP'));
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', Array('EXT1C', 'ATTRIBUTES2PROP'));
class EXT1C
{
	function ATTRIBUTES2PROP(&$arFields)
	{
		if((@$_REQUEST['type']=='catalog') && (@$_REQUEST['mode']=='import'))//выгрузка из 1С?
		{
			$IBLOCK_ID	= $arFields['IBLOCK_ID'];
			$ELEMENT_ID	= $arFields['ID'];
			//получаем массив значений множественного свойства CML2_ATTRIBUTES в которое стандартно выгружаются характеристики ТП из 1С
			$CML2_ATTRIBUTES = CIBlockElement::GetProperty($IBLOCK_ID, $ELEMENT_ID, array('sort' => 'asc'), Array('CODE'=>'CML2_ATTRIBUTES'));

			while ($CML2_ATTRIBUTE = $CML2_ATTRIBUTES->GetNext())
			{
				$VALUE			= $CML2_ATTRIBUTE['VALUE'];//значение характеристики
				$DESCRIPTION	= $CML2_ATTRIBUTE['DESCRIPTION'];//название характеристики

				//проверяем, есть ли свойство с названием как в описание значения свойства в CML2_ATTRIBUTES
				$PROP = CIBlockElement::GetProperty($IBLOCK_ID, $ELEMENT_ID, array('sort' => 'asc'), Array('NAME'=> $DESCRIPTION));

				//если свойств нет, то создаем его, чтобы потом в него записать значение из CML2_ATTRIBUTES
				if(!$ar_props = $PROP->Fetch())
				{
					//транслителируем символьный код из наименования
					$CODE = CUtil::translit($DESCRIPTION, 'ru', array(
						'max_len'				=> 50,
						'change_case'			=> 'U', // 'L' - toLower, 'U' - toUpper, false - do not change
						'replace_space'			=> '_',
						'replace_other'			=> '_',
						'delete_repeat_replace'	=> true,
					));
					//добавляем '_' в код свойства, если его наименование начинается с цифры
					if(preg_match('/^[0-9]/', $CODE))
						$CODE = '_'.$CODE;

					$CODE = 'INPR_'.$CODE;

					$arFields_add = Array(
						'NAME'			=> $DESCRIPTION,
						'ACTIVE'		=> 'Y',
						'SORT'			=> '500',
						'CODE'			=> $CODE,
						'PROPERTY_TYPE'	=> 'S',
						'IBLOCK_ID'		=> $IBLOCK_ID,
					);

					//заполняем созданное свойство
					$ibp = new CIBlockProperty;
					if ($PropID = $ibp->Add($arFields_add))
						CIBlockElement::SetPropertyValueCode($ELEMENT_ID, $CODE, $VALUE);
				}
				else//если свойство с таким названием уже было, то заполняем его значением из CML2_ATTRIBUTES
				{
					CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, $IBLOCK_ID, array($ar_props['CODE'] => $VALUE));
				}
			}
		}
	}
}*/


// Выгрузка из 1С характеристик торговых предложений в отдельные свойства v2.0
$eventManager = \Bitrix\Main\EventManager::getInstance();

//$eventManager->addEventHandlerCompatible('iblock',	'OnAfterIBlockElementUpdate',	array('ext1cHandler', 'attributeFieldToProps'));
//$eventManager->addEventHandlerCompatible('iblock',	'OnAfterIBlockElementAdd',		array('ext1cHandler', 'attributeFieldToProps'));
//$eventManager->addEventHandlerCompatible('catalog',	'OnBeforeProductUpdate',		array('ext1cHandler', 'attributeQuant'));
//$eventManager->addEventHandlerCompatible('catalog',	'OnBeforeProductAdd',			array('ext1cHandler', 'attributeQuant'));

class ext1cHandler
{
	const CML2_ATTRIBUTES_NAME = 'CML2_ATTRIBUTES';

	protected static $iblockProps = null;
//	public static $disableHandler = false;

	/**
		* @param $iblockId
		* @return array|null
	*/
	protected static function getIblockProps($iblockId)
	{
		if (self::$iblockProps === null)
		{
			$resProps = CIBlock::GetProperties($iblockId, Array(), Array());
			if (intval($resProps->SelectedRowsCount()) > 0)
			{
				self::$iblockProps = array();
				while ($arProp = $resProps->Fetch())
				{
					self::$iblockProps[$arProp['CODE']] = $arProp['ID'];
				}
			}
		}
		return self::$iblockProps;
	}

	/**
		* @param $arFields
	*/

	public static function attributeFieldToProps($arFields)
	{
//		if (!self::is1cSync()) return true;

//		AddMessage2Log("\n".'Вызов функции'."\n".print_r($arFields, true), 'attributeFieldToProps:');

		self::getIblockProps($arFields['IBLOCK_ID']);

		if (empty(self::$iblockProps) || !is_array(self::$iblockProps)) return;

		//получаем массив значений множественного свойства CML2_ATTRIBUTES в которое стандартно выгружаются характеристики ТП из 1С
		$resCml2Attributes = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array('sort' => 'asc'), array('CODE' => self::CML2_ATTRIBUTES_NAME));

		while ($arCml2Attribute = $resCml2Attributes->GetNext())
		{

			$cml2AttributeName	= $arCml2Attribute['DESCRIPTION']; //название характеристики
			$cml2AttributeValue	= $arCml2Attribute['VALUE']; //значение характеристики

			// создание свойства
			$codeNewProp = self::getTranslit($cml2AttributeName);

			$codeNewProp = 'INPR_'.$codeNewProp;

//			AddMessage2Log("\n".'Название: '.$cml2AttributeName."\n".'Значение: '.$cml2AttributeValue."\n".'Перевод: '.$codeNewProp, 'attributeFieldToProps:');

			if ( !isset(self::$iblockProps[$codeNewProp]) && $codeNewProp!='INPR_KOLICHESTVO_TOVAROV' )// Если нет свойства то добавим
			{

				$arFields_add = array(
					'NAME'			=> $cml2AttributeName,
					'ACTIVE'		=> 'Y',
					'SORT'			=> '500',
					'CODE'			=> $codeNewProp,
					'PROPERTY_TYPE'	=> 'L',
					'IBLOCK_ID'		=> $arFields['IBLOCK_ID'],
					'VALUES'		=> array(),
				);

				$ibp = new CIBlockProperty;
				if($propId = $ibp->Add($arFields_add))
				{
					self::$iblockProps[$codeNewProp] = $propId;
//					AddMessage2Log("\n".'Если нет свойства то добавим: '.$cml2AttributeName.', с кодом: '.$codeNewProp.'|'.$propId, 'attributeFieldToProps:');
				}

			}

			if ( isset(self::$iblockProps[$codeNewProp]) && $codeNewProp!='INPR_KOLICHESTVO_TOVAROV' )// Если есть свойство
			{

				self::getEnumListProp($arFields['IBLOCK_ID'], self::$iblockProps[$codeNewProp]);

				$xmlIdPropValue = self::getTranslit($cml2AttributeValue);

				if (!isset(self::$enumListProps[self::$iblockProps[$codeNewProp]][$xmlIdPropValue]))// то добавим значение
				{

					$ibpenum = new CIBlockPropertyEnum;
					$arFieldsEnum = array(
						'XML_ID'		=> $xmlIdPropValue,
						'PROPERTY_ID'	=> self::$iblockProps[$codeNewProp],
						'VALUE'			=> $cml2AttributeValue
					);

					if ($enumPropValueId = $ibpenum->Add($arFieldsEnum))
					{
						self::$enumListProps[self::$iblockProps[$codeNewProp]][$xmlIdPropValue] = $enumPropValueId;
//						AddMessage2Log("\n".'Если есть свойство: '.$cml2AttributeName.', то добавим в него значение: '.$cml2AttributeValue, 'attributeFieldToProps:');
					}

				}

				if (isset(self::$enumListProps[self::$iblockProps[$codeNewProp]][$xmlIdPropValue]))// выберем нужное значение
				{
					CIBlockElement::SetPropertyValues($arFields['ID'], $arFields['IBLOCK_ID'], array(
						'VALUE' => self::$enumListProps[self::$iblockProps[$codeNewProp]][$xmlIdPropValue]
					), self::$iblockProps[$codeNewProp]);
//					AddMessage2Log("\n".'Выберем значение: '.$cml2AttributeValue, 'attributeFieldToProps:');
				}

			}

		}
	}
	// Количество товара на складе
	/*public static function attributeQuant($arFields)
	{

		if( is_array($arFields) )
			$ID = $arFields['ID'];
		else
			$ID = $arFields;

		$res = CIBlockElement::GetByID($ID);
		if($ob = $res->GetNextElement())
		{
			$fie = $ob->GetFields();
			$pro = $ob->GetProperties();

			if( $pro['INPR_KOLICHESTVO_KOMPLEKTOV']['VALUE'] )
			{
				if (self::$disableHandler && \Bitrix\Main\Loader::includeModule('catalog') && \Bitrix\Main\Loader::includeModule('iblock'))
					return;

				$arFields_upd = array(
					'ID'				=> $ID,
					'QUANTITY'			=> $pro['INPR_KOLICHESTVO_KOMPLEKTOV']['VALUE'],
					'QUANTITY_TRACE'	=> 'D',
				);

				self::$disableHandler = true; //отключаем

				if( CCatalogProduct::Add($arFields_upd) )
					AddMessage2Log( 'готова'.$ID.' | '.$pro['INPR_KOLICHESTVO_KOMPLEKTOV']['VALUE'] );
			}
		}
		return false;
	}*/

	private static $enumListProps = array();

	/**
		* @param $iblockId
		* @param $propId
		* @return array
	*/
	protected static function getEnumListProp($iblockId, $propId)
	{

		if (!isset(self::$enumListProps[$propId]))
		{
			$resEnumField = CIBlockPropertyEnum::GetList(array('SORT' => 'ASC'), array('IBLOCK_ID' => $iblockId, 'PROPERTY_ID' => $propId));
			if (intval($resEnumField->SelectedRowsCount()) > 0)
			{
				self::$enumListProps[$propId] = array();
				while ($arEnumField = $resEnumField->Fetch())
				{
					self::$enumListProps[$propId][$arEnumField['XML_ID']] = $arEnumField['ID'];
				}
			}
		}
		return self::$enumListProps;

	}

	/**
		* @param $text
		* @param string $lang
		* @return string
	*/
	private static function getTranslit($text, $lang = 'ru')
	{

		$resultString = CUtil::translit($text, $lang, array(
				'max_len'				=> 50,
				'change_case'			=> 'U',
				'replace_space'			=> '_',
				'replace_other'			=> '_',
				'delete_repeat_replace'	=> true,
			)
		);

		if (preg_match('/^[0-9]/', $resultString))
		{
			$resultString = '_' . $resultString;
		}

		return $resultString;
	}

	/**
		* @return bool
	*/
	private static function is1cSync()
	{
		static $is1C = null;
		if ($is1C === null)
		{
			$is1C = (isset($_GET['type'], $_GET['mode']) && $_GET['type'] === 'catalog' && $_GET['mode'] === 'import');
		}
		return $is1C;
	}
}

$eventManager->addEventHandlerCompatible('catalog', 'OnSuccessCatalogImport1C', array('import1cAfter', 'requisitesImport'));
$eventManager->addEventHandlerCompatible('catalog', 'OnSuccessCatalogImport1C', array('import1cAfter', 'propertyImport'));
$eventManager->addEventHandlerCompatible('catalog', 'OnSuccessCatalogImport1C', array('import1cAfter', 'unitsImport'));
$eventManager->addEventHandlerCompatible('catalog', 'OnSuccessCatalogImport1C', array('import1cAfter', 'stickerImport'));
//$eventManager->addEventHandlerCompatible('catalog', 'OnSuccessCatalogImport1C', array('import1cAfter', 'quantityImport'));

class import1cAfter
{
	// Количество из свойства в системное поле
	public static function quantityImport($arParams, $arFields)
	{
		include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/import_quant.php');

		return true;
	}

	// <Свойства>
	public static function attributeImport($arParams, $arFields)
	{
		include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/import_attribute.php');

		return true;
	}

	// <ЗначенияРеквизитов>
	public static function requisitesImport($arParams, $arFields)
	{
		include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/import_requisites.php');

		return true;
	}

	// Свойства
	public static function propertyImport($arParams, $arFields)
	{
		include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/import_property.php');

		return true;
	}
	// Единицы измерения
	public static function unitsImport($arParams, $arFields)
	{
		include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/import_units.php');

		return true;
	}
	// Установка стикеров
	public static function stickerImport($arParams, $arFields)
	{
		include_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/import_sticker.php');
		return true;
	}
}
// Перед отправкой письма о новом заказе
AddEventHandler('sale',	'OnOrderNewSendEmail',	'BeforeSendOrderNew');
function BeforeSendOrderNew($id, $eventName, $arFields)
{
//	AddMessage2Log($id.'|'.$eventName.'|'.SITE_ID.'|'.LANGUAGE_ID);
//	AddMessage2Log(print_r($arFields, true));

	$l = strtoupper(LANGUAGE_ID);

	$res = CSaleBasket::GetList(
		array('ID' => 'ASC'),
		array('ORDER_ID' => $id),
		false,
		false,
		array('ID', 'PRODUCT_ID', 'QUANTITY', 'PROPS', 'PRICE', 'CURRENCY', 'LID', 'NAME')
	);

	while ($obj = $res->Fetch())
	{
		if (CSaleBasketHelper::isSetItem($obj))
			continue;

		$arResult['ITEMS'][$obj['PRODUCT_ID']]['I_BASKET'] = $obj;
		$proId[] = $obj['PRODUCT_ID'];
	}

	if( $proId )
	{
		$arSelect = Array('ID', 'NAME', 'IBLOCK_SECTION_ID');
		$arFilter = Array('ID'=>$proId);
		$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
		while($ob = $res->GetNextElement())
		{
			$obj			= $ob->GetFields();
			$obj['PRO']		= $ob->GetProperties();

			if( $obj['PRO']['I_NAME_'.$l]['VALUE'] )
				$obj['NAME'] = $obj['PRO']['I_NAME_'.$l]['VALUE'];

			$arResult['ITEMS'][$obj['ID']]['ELEMENT'] = $obj;
		}

		$res = CSaleOrderPropsValue::GetOrderProps($id);
		$iGroup = -1;
		while ($arProps = $res->Fetch())
		{

			if ($arProps['TYPE']=='CHECKBOX')
			{
				if ($arProps['VALUE']=='Y')
					$arProps['VALUE'] = 'Да';
				else
					$arProps['VALUE'] = 'Нет';
			}
			elseif ($arProps['TYPE']=='TEXT' || $arProps['TYPE']=='TEXTAREA')
			{
				$arProps['VALUE'] = htmlspecialchars($arProps['VALUE']);
			}
			elseif ($arProps['TYPE']=='SELECT' || $arProps['TYPE']=='RADIO')
			{
				$arVal = CSaleOrderPropsVariant::GetByValue($arProps['ORDER_PROPS_ID'], $arProps['VALUE']);
				$arProps['NAME'] = htmlspecialchars($arVal['NAME']);
			}
			elseif ($arProps['TYPE']=='MULTISELECT')
			{
				$curVal = split(',', $arProps['VALUE']);
				for ($i = 0; $i<count($curVal); $i++)
				{
					$arVal = CSaleOrderPropsVariant::GetByValue($arProps['ORDER_PROPS_ID'], $curVal[$i]);
					if ($i>0) $Gval .= ', ';
						$Gval .= htmlspecialchars($arVal['NAME']);
				}
				$arProps['VALUE'] = $Gval;
			}
			elseif ($arProps['TYPE']=='LOCATION')
			{
				$arVal = CSaleLocation::GetByID($arProps['VALUE'], LANGUAGE_ID);
				$arProps['VALUE'] = htmlspecialchars($arVal['COUNTRY_NAME'].' - '.$arVal['CITY_NAME']);
			}

			$arResult['ORDER_PROPS'][]		= $arProps;
			$arResult['I_ORDER_PROPS'][]	= array(
				'NAME'	=> $arProps['PROPERTY_NAME'],
				'VALUE'	=> $arProps['VALUE']
			);
			$arResult['I_ORDER_PROPS_STR']	.= $arProps['PROPERTY_NAME'].': '.$arProps['VALUE']."\n";
		}

		// Параметры заказа
		$arOrder = CSaleOrder::GetByID($id);

		$arEventFields = array(
			'ORDER_ID'		=> $arFields['ORDER_ID'],// - код заказа
			'ORDER_DATE'	=> $arFields['ORDER_DATE'],// - дата заказа
			'ORDER_USER'	=> $arFields['ORDER_USER'],// - заказчик
			'PRICE'			=> $arFields['PRICE'],// - сумма заказа
			'EMAIL'			=> $arFields['EMAIL'],// - E-Mail заказчика
			'BCC'			=> $arFields['BCC'],// - E-Mail скрытой копии
			'ORDER_LIST'	=> $arFields['ORDER_LIST'],// - состав заказа
			'SALE_EMAIL'	=> $arFields['SALE_EMAIL'],// - E-Mail отдела продаж
			'ORDER_PROPS'	=> $arResult['I_ORDER_PROPS_STR'],// - Свойства заказа
		);

		// Служба доставки old
		/*$arDeliv = CSaleDelivery::GetByID($arOrder['DELIVERY_ID']);
		if ($arDeliv)
			$arEventFields['DELIVERY'] = "Доставка \"".$arDeliv['NAME']."\" стоит ".CurrencyFormat($arDeliv['PRICE'], $arDeliv['CURRENCY']);*/

		$services = \Bitrix\Sale\Delivery\Services\Manager::getActive();

		if($arDeliv = $services[$arOrder['ID']])
			$arEventFields['DELIVERY'] = "Доставка \"".$arDeliv['NAME']."\" стоит ".CurrencyFormat($arDeliv['PRICE'], $arDeliv['CONFIG']['MAIN']['PRICE']);

		// Служба оплаты old
		/*if ($arPaySys = CSalePaySystem::GetByID($arOrder['PAY_SYSTEM_ID'], $arOrder['PERSON_TYPE_ID']))
			$arEventFields['PAY_SYSTEM'] = $arPaySys['PSA_NAME'];*/

		$params = array(
			'select' => array('*'),
			'filter' => array('ID' => $arOrder['PAY_SYSTEM_ID'])
		);
		$res = Bitrix\Sale\PaySystem\Manager::getList($params);
		if($ob = $res->fetch())
			$arEventFields['PAY_SYSTEM'] = $ob['PSA_NAME'];

		CEvent::SendImmediate('SALE_NEW_ORDER_MANAGER', SITE_ID, $arEventFields, 'N', '');

//		AddMessage2Log(print_r($arResult, true));
//		AddMessage2Log(print_r($arEventFields, true));
//		AddMessage2Log(print_r($arOrder, true));
	}

}

//закроем сайт для не авторизованных пользователей
//AddEventHandler('main', 'OnProlog', 'CloseAccessForGroup');
function CloseAccessForGroup()
{
	global $USER, $APPLICATION;
	$mas = $USER->GetUserGroupArray();
	if(
		!in_array(1, $mas)
		&&
		!in_array(6, $mas)
		&&
		!in_array(8, $mas)
		&&
		!in_array(9, $mas)
		&&
		!in_array(12, $mas)
		&&
		(strpos($APPLICATION->GetCurPage(),'/bitrix/admin/'))===false
	)
	{
		require($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/site_closed.php');
		die;
	}
}



// lite Functions
if ($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions_lite.php') {
	require($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions_lite.php');
}
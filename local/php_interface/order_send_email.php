<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD

if ( \Bitrix\Main\Loader::includeModule('catalog') && \Bitrix\Main\Loader::includeModule('sale') && \Bitrix\Main\Loader::includeModule('iblock') )
{
//	AddMessage2Log($id.'|'.$eventName.'|'.SITE_ID.'|'.LANGUAGE_ID);
//	AddMessage2Log(print_r($arFields, true));
	AddMessage2Log('работа');

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
//		$iGroup = -1;
		while ($arProps = $res->Fetch())
		{
			$arResult['ORDER_PROPS'][]		= $arProps;
			$arResult['I_ORDER_PROPS'][]	= array(
				'NAME'	=> $arProps['PROPERTY_NAME'],
				'VALUE'	=> $arProps['VALUE_ORIG']
			);
			$arResult['I_ORDER_PROPS_STR']	.= $arProps['PROPERTY_NAME'].': '.$arProps['VALUE_ORIG']."\n";
/*
			if ($iGroup!=IntVal($arProps['PROPS_GROUP_ID']))
			{
				echo '<b>'.$arProps['GROUP_NAME'].'</b><br>';
				$iGroup = IntVal($arProps['PROPS_GROUP_ID']);
			}

			echo $arProps['NAME'].': ';

			if ($arProps['TYPE']=='CHECKBOX')
			{
				if ($arProps['VALUE']=='Y')
					echo 'Да';
				else
					echo 'Нет';
			}
			elseif ($arProps['TYPE']=='TEXT' || $arProps['TYPE']=='TEXTAREA')
			{
				echo htmlspecialchars($arProps['VALUE']);
			}
			elseif ($arProps['TYPE']=='SELECT' || $arProps['TYPE']=='RADIO')
			{
				$arVal = CSaleOrderPropsVariant::GetByValue($arProps['ORDER_PROPS_ID'], $arProps['VALUE']);
				echo htmlspecialchars($arVal['NAME']);
			}
			elseif ($arProps['TYPE']=='MULTISELECT')
			{
				$curVal = split(',', $arProps['VALUE']);
				for ($i = 0; $i<count($curVal); $i++)
				{
					$arVal = CSaleOrderPropsVariant::GetByValue($arProps['ORDER_PROPS_ID'], $curVal[$i]);
					if ($i>0) echo ', ';
						echo htmlspecialchars($arVal['NAME']);
				}
			}
			elseif ($arProps['TYPE']=='LOCATION')
			{
				$arVal = CSaleLocation::GetByID($arProps['VALUE'], LANGUAGE_ID);
				echo htmlspecialchars($arVal['COUNTRY_NAME'].' - '.$arVal['CITY_NAME']);
			}

			echo '<br>';
*/
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

		// Служба доставки
		$arDeliv = CSaleDelivery::GetByID($arOrder['DELIVERY_ID']);
		if ($arDeliv)
			$arEventFields['DELIVERY'] = "Доставка \"".$arDeliv['NAME']."\" стоит ".CurrencyFormat($arDeliv['PRICE'], $arDeliv['CURRENCY']);

		// Служба оплаты
		if ($arPaySys = CSalePaySystem::GetByID($arOrder['PAY_SYSTEM_ID'], $arOrder['PERSON_TYPE_ID']))
			$arEventFields['PAY_SYSTEM'] = $arPaySys['PSA_NAME'];

		CEvent::SendImmediate('SALE_NEW_ORDER_MANAGER', SITE_ID, $arEventFields, 'N', '');

//		AddMessage2Log(print_r($arEventFields, true));
//		AddMessage2Log(print_r($arOrder, true));
	}

} else
	AddMessage2Log("\n".'- Ошибка, модули не подключены!');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
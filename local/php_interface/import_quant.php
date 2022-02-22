<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$START_TIME = date('H:i:s');

$iblock_id			= 3;
$iblock_char_id		= 16;
$array_char_now		= array();
$array_quant_now	= array();
$noupd				= 0;
$upd				= 0;
$add				= 0;
$ELEM_ID			= 0;

if (\Bitrix\Main\Loader::includeModule('catalog') && \Bitrix\Main\Loader::includeModule('iblock'))
{
	// собираем базу торговых предложений и товаров
	$db_list = CIBlockElement::GetList(Array(), Array('IBLOCK_ID'=>array($iblock_id, $iblock_char_id)), false, false, array('ID', 'IBLOCK_ID', 'PROPERTY_KOLICHESTVO_TOVAROV', 'PROPERTY_CML2_ATTRIBUTES'));
	while($ob = $db_list->GetNextElement()){
		$ar_result			= $ob->GetFields();
		$ar_result['PROP']	= $ob->GetProperties();
		$array_char_now[$ar_result['ID']] = $ar_result;
	}
	$Log = '\n<br /> - '.'Торговых предложений и товаров - '.count($array_char_now); $message2Log .= $Log;
	//AddMessage2Log(print_r($array_char_now, true));

	// собираем базу остатков
	$db_list = CCatalogProduct::GetList(Array(), Array(), false, false, array('ID','QUANTITY','QUANTITY_TRACE','CAN_BUY_ZERO','NEGATIVE_AMOUNT_TRACE','SUBSCRIBE','VAT_ID','VAT_INCLUDED','WEIGHT'));
	while($ar_result = $db_list->Fetch())
		$array_quant_now[$ar_result['ID']] = $ar_result;
	$Log = '\n<br /> - '.'Остатков в базе - '.count($array_quant_now); $message2Log .= $Log;

	foreach($array_char_now as $tov){
		$ELEM_ID	= $tov['ID'];
		$QUANTITY	= 0;

		// проверяем это харакетристика ли
		if($tov['IBLOCK_ID'] == $iblock_char_id)
		{
			foreach($tov['PROP']['CML2_ATTRIBUTES']['DESCRIPTION'] as $key => $descr){
				if($descr == 'Количество товаров')
					$QUANTITY = $tov['PROP']['CML2_ATTRIBUTES']['VALUE'][$key];
			}
		} elseif($tov['IBLOCK_ID'] == $iblock_id) {
			$QUANTITY = $tov['PROP']['KOLICHESTVO_TOVAROV']['VALUE'];
		}

		if($QUANTITY){
			$arFields = array(
				'ID'					=> $ELEM_ID,
				'QUANTITY'				=> $QUANTITY,
				'QUANTITY_TRACE'		=> 'D',
				'CAN_BUY_ZERO'			=> 'D',
				'NEGATIVE_AMOUNT_TRACE'	=> 'D',
				'SUBSCRIBE'				=> 'D',
				'VAT_ID'				=> 1,
				'VAT_INCLUDED'			=> 'Y',
			);

			//остатки
			if (isset($array_quant_now[$ELEM_ID]))
			{
				if($array_quant_now[$ELEM_ID]['QUANTITY'] == $arFields['QUANTITY']
					&& $array_quant_now[$ELEM_ID]['VAT_ID'] == $arFields['VAT_ID']){
					$noupd++;
				} else {
					CCatalogProduct::Update($ELEM_ID, $arFields);
					$upd++;
				}
			} else {
				if(CCatalogProduct::Add($arFields)){
					$add++;
				} else
					$Log = '\n<br /> - '.'Ошибка добавления остатка - '.$ELEM_ID; $message2Log .= $Log;
			}
		}

		unset($array_quant_now[$ELEM_ID]);
	}

	$Log = '\n<br /> - '.'Остатков без обновлений - '.$noupd; $message2Log .= $Log;
	$Log = '\n<br /> - '.'Остатков обновлено - '.$upd; $message2Log .= $Log;
	$Log = '\n<br /> - '.'Остатков добавлено - '.$add; $message2Log .= $Log;
	$Log = '\n<br /> - '.'--------------------------'.$upd; $message2Log .= $Log;
} else {
	$Log = '\n<br /> - '.'Ошибка!!! Модули не подключены - '.$noupd; $message2Log .= $Log;
}

$Log = '\n<br /> - '.'Время начала - '.$START_TIME; $message2Log .= $Log;
$Log = '\n<br /> - '.'Время завершения - '.date('H:i:s'); $message2Log .= $Log;
AddMessage2Log($message2Log, 'import_quant:');

//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
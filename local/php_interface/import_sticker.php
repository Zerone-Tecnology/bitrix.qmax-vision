<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Loader;

$START_TIME = date('H:i:s');

$iblock_id = 3;
$arE_now = array();

if (Loader::includeModule('iblock'))
{
	// собираем базу торговых предложений и товаров
	$db_list = CIBlockElement::GetList(Array(), Array('IBLOCK_ID'=>$iblock_id), false, false, array('XML_ID', 'ID'));
	while($ob = $db_list->GetNext()){
		$arE_now[$ob['XML_ID']] = $ob;
	}
	$Log = '\n<br /> - '.'Товаров в каталоге - '.count($arE_now); $message2Log .= $Log;

	$xml_offers = $_SERVER["DOCUMENT_ROOT"].'/upload/1c_catalog/offers.xml';
	$classificator = simplexml_load_file($xml_offers)->ПакетПредложений->Предложения->Предложение;

	if (is_object($classificator)){
		foreach($classificator as $tov)
		{
			$XML_ID = (string) $tov->Ид;
			$PROP['I_SYSTEM_IN_STOCK'] = '';
			$PROP['I_SYSTEM_EXPECTED'] = '';
			$PROP['I_SYSTEM_TO_ORDER'] = '';
			$rezult = 0;

			foreach($tov->КоличествоНаСкладах->КоличествоНаСкладе as $sklad){
				$S_XML_ID = (string) $sklad->ИдСклада;
				$val = (int) $sklad->Количество;

				if($S_XML_ID == '24303e79-d9d2-11e5-be6c-90b11c88dafe' && $val > 0)
					$rezult = 1;
				elseif($S_XML_ID == '086e2b31-d9d4-11e5-be6c-90b11c88dafe' && $val > 0)
					$rezult = 2;
			}

			if($rezult == 1)
				$PROP['I_SYSTEM_IN_STOCK'] = 821;
			elseif($rezult == 2)
				$PROP['I_SYSTEM_EXPECTED'] = 827;
			else
				$PROP['I_SYSTEM_TO_ORDER'] = 822;

			// ставим товарам стикеры
			CIBlockElement::SetPropertyValuesEx($arE_now[$XML_ID]["ID"], $iblock_id, $PROP);
		}
	}else{
		$Log = "\n<br /> - ".'Ошибка xml'; $message2Log .= $Log;
	}
} else {
	$Log = '\n<br /> - '.'Ошибка!!! Модули не подключены - '.$noupd; $message2Log .= $Log;
}

$Log = '\n<br /> - '.'Время начала - '.$START_TIME; $message2Log .= $Log;
$Log = '\n<br /> - '.'Время завершения - '.date('H:i:s'); $message2Log .= $Log;
AddMessage2Log($message2Log, 'import_sticker:');

//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
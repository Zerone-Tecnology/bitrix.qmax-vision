<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD

$st = date('H:i:s');

if ( \Bitrix\Main\Loader::includeModule('catalog') && \Bitrix\Main\Loader::includeModule('iblock') )
{
	$Log = '';
	$xml_import = $_SERVER['DOCUMENT_ROOT'].'/upload/1c_catalog/import.xml';

	if( file_exists($xml_import) )
	{
		$Log .= "\n".' - import.xml найден';

		$xml_obj			= simplexml_load_file($xml_import);
		$arItems			= $xml_obj->Каталог->Товары->Товар;

		$res = CCatalogMeasure::getList();
		while($ob = $res->Fetch())
			$arr_measure[$ob['CODE']] = $ob;

//		$Log .= "\n".print_r($arItems, true);
//		$Log .= "\n".print_r($arr_measure, true);

		if( is_object($arItems) )
			foreach($arItems as $e)
			{
//				$Log		.= "\n".(string) $e->БазоваяЕдиница;
//				$Log		.= "\n".(string) $e->БазоваяЕдиница['Код'];
//				$Log		.= "\n".(string) $e->БазоваяЕдиница['НаименованиеПолное'];
				$id			= (string) $e->Ид;
				$id_m		= (int) $e->БазоваяЕдиница['Код'];
				$name_m		= (string) $e->БазоваяЕдиница['НаименованиеПолное'];

				$xml_measure[$id]['ID']		= $id_m;
				$xml_measure[$id]['NAME']	= $name_m;

//				$Log .= "\n".print_r($e, true);
			}

			if( is_array($xml_measure) )
			{
				$arFilter = Array('XML_ID'=>array_keys($xml_measure), 'ACTIVE'=>'Y');

				$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
				while($ob = $res->GetNext())
				{
					$m_arResult[] = $ob;
					if( $xml_measure[$ob['XML_ID']]['ID'] )
					{
						// ID единицы измерения
						$arFields	= array('MEASURE'=>$arr_measure[$xml_measure[$ob['XML_ID']]['ID']]['ID']);
						if( CCatalogProduct::Update($ob['ID'], $arFields) )
							$Log .= "\n".'Единица измерения товара: '.'['.$ob['ID'].'] '.$ob['NAME'].' - изменина на ['.$xml_measure[$ob['XML_ID']]['NAME'].']';
					}
				}
			}
//		$Log .= "\n".print_r($xml_measure, true);
		$Log .= "\n\n\n".'---------------------------------------------*---------------------------------------------';
		$Log .= "\n".'Всего товаров '.count($m_arResult).' - $m_arResult(Инфоблок)';
		$Log .= "\n".'Всего товаров '.count($xml_measure).' - $xml_measure(XML)';
//		$Log .= "\n".print_r($m_arResult, true);
	}

	$xml_offers = $_SERVER['DOCUMENT_ROOT'].'/upload/1c_catalog/offers.xml';

	if( file_exists($xml_offers) )
	{
		$Log .= "\n".' - offers.xml найден';

		$xml_obj			= simplexml_load_file($xml_offers);
		$arItems			= $xml_obj->ПакетПредложений->Предложения->Предложение;

		if( is_object($arItems) )
			foreach($arItems as $e)
			{
				$id			= (string) $e->Ид;
				$id_m		= (int) $e->БазоваяЕдиница['Код'];
				$name_m		= (string) $e->БазоваяЕдиница['НаименованиеПолное'];
				$coef		= (string) $e->Цены->Цена->Коэффициент;

				$xml_coef[$id]['ID']			= $id_m;
				$xml_coef[$id]['NAME']			= $name_m;
				$xml_coef[$id]['COEFFICIENT']	= $coef;

//				$Log .= "\n".print_r($e, true);
			}

		if( is_array($xml_coef) )
		{
			$arFilter = Array('XML_ID'=>array_keys($xml_coef), 'ACTIVE'=>'Y');
			$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
			while($ob = $res->GetNext())
			{
				$c_arResult[]	= $ob;
				$c_arr[]		= $ob['ID'];
			}

			$res = CCatalogMeasureRatio::getList(array(), Array('PRODUCT_ID'=>$c_arr));
			while($ob = $res->GetNext())
			{
				$mr[$ob['PRODUCT_ID']] = $ob;
			}
//			$Log .= "\n"."\n".print_r($mr, true)."\n"."\n";

			// Коэффициент единицы измерения
			foreach ($c_arResult as $e)
			{
				$coefficient	= $xml_coef[$e['XML_ID']]['COEFFICIENT'];
				$arFields		= array(
					'PRODUCT_ID'	=> $e['ID'],
					'RATIO'			=> $coefficient
				);

				if( isset($mr[$e['ID']]) && $coefficient && $mr[$e['ID']]['RATIO']!=$coefficient )
				{
					if( CCatalogMeasureRatio::Update($mr[$e['ID']]['ID'], $arFields) )
						$Log .= "\n".'Коэффициент единицы измерения товара: '.'['.$e['ID'].'] '.$e['NAME'].' - изменён, значение - ['.$coefficient.']';
				} elseif( $coefficient ) {
					if( CCatalogMeasureRatio::Add($arFields) )
						$Log .= "\n".'Коэффициент единицы измерения товара: '.'['.$e['ID'].'] '.$e['NAME'].' - добавлен, значение - ['.$coefficient.']';
				}
			}
		}

//		$Log .= "\n".print_r($xml_coef, true);
		$Log .= "\n\n\n".'---------------------------------------------*---------------------------------------------';
		$Log .= "\n".'Всего товаров '.count($c_arResult).' - $c_arResult(Инфоблок)';
		$Log .= "\n".'Всего предложений '.count($xml_coef).' - $xml_coef(XML)';
//		$Log .= "\n".print_r($c_arResult, true);
	}

} else
	$Log .= "\n".'- Ошибка, модули не подключены!';


$Log .= "\n".'- Время начала - '.$st;
$Log .= "\n".'- Время завершения - '.date('H:i:s');

// ---------------------------------------------------------------------------------------------------- Log
AddMessage2Log($Log."\n", 'import_units');

$arEventFields = array('MESSAGE' => $Log, 'DATE'=>date('d.m.Y'));
//CEvent::Send('IMPORT_SEND', 'it', $arEventFields);
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
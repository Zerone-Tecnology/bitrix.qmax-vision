<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD

if ( \Bitrix\Main\Loader::includeModule('catalog') && \Bitrix\Main\Loader::includeModule('iblock') )
{
//	$START_TIME	= date('H:i:s');
	$IBLOCK_ID	= 20;

	$arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
	while($ob = $res->GetNext())
	{
		$arResult = array(
			'IBLOCK_ID'		=> $ob['IBLOCK_ID'],
			'ID'			=> $ob['ID']
		);
		ext1cHandler::attributeFieldToProps($arResult);
	}

	//$Log = "\n".'- 1'; $Message2Log .= $Log;
} else
	AddMessage2Log("\n".'- Ошибка, модули не подключены!');
//	$Log = "\n".'- Ошибка, модули не подключены!'; $Message2Log .= $Log;


//$Log = "\n".'- Время начала - '.$START_TIME; $Message2Log .= $Log;
//$Log = "\n".'- Время завершения - '.date('H:i:s'); $Message2Log .= $Log;

// ---------------------------------------------------------------------------------------------------- Log
//AddMessage2Log($Message2Log."\n", 'import_property:');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
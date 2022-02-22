<?
//$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/..');

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS',true);
define('NO_AGENT_CHECK', true);
define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/attributeImport_log.txt');
set_time_limit(0);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$message2Log	= '';
$START_TIME		= date('H:i:s');
//$USER->Authorize(57);

function i_GetProp($iblockId)
{
	$res = CIBlock::GetProperties($iblockId, Array(), Array());
	while ($ob = $res->Fetch())
		$prop[$ob['CODE']] = $ob['ID'];

	return $prop;
}
function i_GetPropList($iblockId, $propId, $xml_id)
{
	$arFilter = array('IBLOCK_ID'=>$iblockId, 'PROPERTY_ID'=>$propId);

	if( $xml_id )
		$arFilter['XML_ID'] = $xml_id;

	$res = CIBlockPropertyEnum::GetList(array('SORT'=>'ASC'), $arFilter);
	while ($ob = $res->GetNext())
		$prop_list[$ob['XML_ID']] = $ob['ID'];

	return $prop_list;
}
function i_getTranslit($s)
{
	$s = strip_tags((string)$s); // убираем HTML-теги
	$s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
	$s = trim(preg_replace("/\s+/", ' ', $s)); // удаляем повторяющие пробелы
	$s = mb_strtoupper($s, 'UTF-8'); // переводим строку в нижний регистр (иногда надо задать локаль)
	$s = strtr($s, array('А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'E','Ж'=>'J','З'=>'Z','И'=>'I','Й'=>'Y','К'=>'K','Л'=>'L','М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F','Х'=>'H','Ц'=>'C','Ч'=>'CH','Ш'=>'SH','Щ'=>'SHCH','Ы'=>'Y','Э'=>'E','Ю'=>'YU','Я'=>'YA','Ъ'=>'','Ь'=>''));
	$s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
	$s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
	return $s; // возвращаем результат
}
/*
function getTranslit($text, $lang = 'ru')
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
*/
$xml_import = $_SERVER['DOCUMENT_ROOT'].'/upload/1c_catalog/import.xml';

if( file_exists($xml_import) )
{
	$Log = "\n<br /> - ".'import.xml найден'; $message2Log .= $Log;

	$IBLOCK_ID = 3;

	$load_file_importxml = simplexml_load_file($xml_import);
	$classificator = $load_file_importxml->Каталог->Товары->Товар;

	if( \Bitrix\Main\Loader::includeModule('iblock') && is_object($classificator) )
	{
		foreach($classificator as $ele)
			if( $ele->ЗначенияРеквизитов )
			{
				$ELE_XML_ID	= (string) $ele->Ид;
//				$ELE_NAME	= (string) $ele->Наименование;

				foreach($ele->ЗначенияРеквизитов->ЗначениеРеквизита as $prop)
				{
//					$PROP_ID		= (string) $prop->Ид;
					$PROP_NAME		= (string) $prop->Наименование;
					$PROP_VALUE		= (string) $prop->Значение;

					$PROP_NAME_TR	= 'REQ_'.i_getTranslit($PROP_NAME);
					$PROP_ID		= $PROP_NAME_TR;

					if( !$PROP[$PROP_ID] )
					{
						$PROP[$PROP_ID]['NAME']		= $PROP_NAME;
						$PROP[$PROP_ID]['CODE']		= $PROP_NAME_TR;
					}

					if( $PROP_VALUE )
					{
						$SET_VALUE[$ELE_XML_ID][$PROP_ID] = $PROP_VALUE;
						$GET_XML_ID[] = $ELE_XML_ID;
					}

				}
			}

		$IBLOCK_PROP	= i_GetProp($IBLOCK_ID);

		if( $PROP )
			foreach($PROP as $p)
				if( !$IBLOCK_PROP[$p['CODE']] )// Добавим свойства если нету
				{
					$ibp				= new CIBlockProperty;
					$arField_add		= array(
						'NAME'			=> $p['NAME'],
						'ACTIVE'		=> 'Y',
						'SORT'			=> '500',
						'CODE'			=> $p['CODE'],
						'PROPERTY_TYPE'	=> 'S',
						'MULTIPLE'		=> 'N',
						'IBLOCK_ID'		=> $IBLOCK_ID,
						'VALUES'		=> array()
					);

					if( $propId = $ibp->Add($arField_add) )
					{
						$IBLOCK_PROP[$p['CODE']] = $propId;
						$Log = "\n<br> - ".'Добавили свойство - '.$p['NAME'].', [ID] - '.$propId.', [CODE] - '.$p['CODE'];$message2Log .= $Log;
					}
				}

		if( $SET_VALUE )// Вставим нужное значение
		{
			$arSelect = Array('ID', 'XML_ID', 'NAME', 'IBLOCK_SECTION_ID');
			$arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'XML_ID'=>$GET_XML_ID);

			$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{

				$obj = $ob->GetFields();

				if( $SET_VALUE[$obj['XML_ID']] )
					foreach($SET_VALUE[$obj['XML_ID']] as $c=>$v)
						CIBlockElement::SetPropertyValuesEx($obj['ID'], $IBLOCK_ID, [ $c => $v ] );

			}

/*
			echo '<pre>';
				print_r($PROP);
				print_r($SET_VALUE);
				print_r($GET_XML_ID);
				print_r($IBLOCK_PROP);
			echo '</pre>';
*/

		}
	}

} else
	$Log = "\n<br /> - ".'import.xml отсутсвует'; $message2Log .= $Log;


$Log = "\n<br /> - ".'Время начала - '.$START_TIME; $message2Log .= $Log;
$Log = "\n<br /> - ".'Время завершения - '.date('H:i:s'); $message2Log .= $Log;
AddMessage2Log($message2Log, 'import_attribute:');

//$arEventFields = array('MESSAGE' => $message2Log, 'DATE'=>date('d.m.Y'));
//CEvent::Send('IMPORT_SEND', 's1', $arEventFields);

//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
//$USER->Logout();?>
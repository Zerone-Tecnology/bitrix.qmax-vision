<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use \Bitrix\Main\Loader;

Loader::includeModule('iblock');

$sFilePathDst = $_SERVER["DOCUMENT_ROOT"]."/import_images/";
$arUnpackOptions = [
	"REMOVE_PATH" => $_SERVER["DOCUMENT_ROOT"]
];

// Распаковка
$sFilePathArc =  $_SERVER["DOCUMENT_ROOT"].'/qmax_images.zip';
$resArchiver = CBXArchive::GetArchive($sFilePathArc);
$resArchiver->SetOptions($arUnpackOptions);
$uRes = $resArchiver->Unpack($sFilePathDst);

$dir = $_SERVER["DOCUMENT_ROOT"]."/import_images";

$arFiles = getFileList($dir, true);

foreach ( $arFiles as $file )
{
	$ar_file = explode("/", $file );
	$count = count( $ar_file );

	$arCode = explode(".", $ar_file[$count-1]);

	$arResult['FILES'][$arCode[0]][$arCode[1]] = [
		// "SRC" => 'https://'.$_SERVER["SERVER_NAME"].'/import_images/qmax_images/'.$ar_file[$count-1]
		'SRC' => $file
	];
}

foreach ( $arResult['FILES'] as $key => $file )
{
	ksort( $arResult['FILES'][$key] );
}


$arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM"];
$arFilter = ["IBLOCK_ID"=>3,"ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y"];
$res = CIBlockElement::GetList([], $arFilter, false, false);
$upd = 0;
$el = new CIBlockElement;
while($ob = $res->GetNextElement()) {
	$ob_do = $ob->GetFields();
	$ob_do['PRO'] = $ob->GetProperties();

	if( $ob_do['PRO']['ARTIKUL']['VALUE'] != '' && !empty($arResult['FILES'][$ob_do['PRO']['ARTIKUL']['VALUE']]) )
	{
		$PROP_PHOTO = [];
		foreach ( $arResult['FILES'][$ob_do['PRO']['ARTIKUL']['VALUE']] as $key => $prop_photo )
		{
			if( $key != 0 && $key != 1 )
			{
				$PROP_PHOTO[$key-1] = CFile::MakeFileArray( $prop_photo['SRC'] );
			}
		}

		if( !empty( $PROP_PHOTO ) )
		{
			$prop['I_MORE_PHOTO'] = $PROP_PHOTO;
			CIBlockElement::SetPropertyValuesEx($ob_do['ID'], 3, $prop);
			$upd++;
			$arResult['ITEMS'][] = $PROP_PHOTO;
		}
	}
}

echo '<br>Количество обновленных картинок - '.$upd;

function getFileList($dir, $recurse = false)
{
	// массив, хранящий возвращаемое значение
	$retval = [];

	// добавить конечный слеш, если его нет
	if(substr($dir, -1) != "/") $dir .= "/";

	// указание директории и считывание списка файлов
	$d = @dir($dir) or die("getFileList: Не удалось открыть каталог $dir для чтения");
	while(false !== ($entry = $d->read()))
	{
		// пропустить скрытые файлы

		if($entry[0] == ".") continue;

		if(is_dir("$dir$entry"))
		{
			$retval[] = "$dir$entry/";

			if($recurse && is_readable("$dir$entry/"))
			{
				$retval = array_merge($retval, getFileList("$dir$entry/", true));
			}
		}
		elseif(is_readable("$dir$entry"))
		{
			$retval[] = "$dir$entry";
		}
	}
	$d->close();

	return $retval;
}

echo '<pre>';
print_r( $arResult );
echo '</pre>';

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>

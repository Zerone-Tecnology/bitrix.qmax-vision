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

// Вывод ошибки или результата
if ( !$uRes )
{
	$arResult['status'] = false;
	$arResult['error'] = 'Возникла ошибка распаковки.';
	echo 'Возникла ошибка распаковки.';
}
else
{
	$arResult['status'] = true;
	$arResult['success'] = 'Распаковка прошла успешно.';
	echo 'Распаковка прошла успешно.';

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


	$arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_ARTIKUL", "PREVIEW_PICTURE", "DETAIL_PICTURE"];
	$arFilter = ["IBLOCK_ID"=>3,"ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y"];
	$res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
	$upd = 0;
	$el = new CIBlockElement;
	while($ob = $res->Fetch()) {
		if( $ob['PROPERTY_ARTIKUL_VALUE'] != '' && $arResult['FILES'][$ob['PROPERTY_ARTIKUL_VALUE']][0]['SRC'] != '' )
		{
			$arLoadProductArray = [
				'PREVIEW_PICTURE' => CFile::MakeFileArray( $arResult['FILES'][$ob['PROPERTY_ARTIKUL_VALUE']][0]['SRC'] ),
				'DETAIL_PICTURE' => CFile::MakeFileArray( $arResult['FILES'][$ob['PROPERTY_ARTIKUL_VALUE']][1]['SRC'] ),
			];
			if( $el->Update($ob['ID'], $arLoadProductArray) )
				$upd++;
		}
	}
}

echo '<br>Количество обновленных картинок - '.$upd;

echo '<pre>';
print_r( $arResult );
echo '</pre>';

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

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>

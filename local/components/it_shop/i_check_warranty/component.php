<?
use Bitrix\Main\Loader,
	Bitrix\Highloadblock as HL;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var $arResult
 * @var $arParams*/

Loader::includeModule("highloadblock");

$arParams['HIBLOCK_ID'] = (int) $arParams['HIBLOCK_ID'];
$arParams['ELEMENT_ID'] = (int) $arParams['ELEMENT_ID'];

if( $arParams['ELEMENT_ID'] > 0 && $arParams['HIBLOCK_ID'] > 0 )
{
	$hlbl = $arParams['HIBLOCK_ID']; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
	$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();

	$rsData = $entity_data_class::getList(array(
		'select' => ['*'],
		'order' => ['ID' => 'ASC'],
		"filter" => ['UF_NEWS_ID'=>$arParams['ELEMENT_ID']]  // Задаем параметры фильтра выборки
	));
	if($arData = $rsData->Fetch()){
		$arResult['ELEMENT'] = $arData;
	}
	else
	{
		$arResult['ELEMENT']['UF_LIKE'] = 0;
		$arResult['ELEMENT']['UF_DISLIKE'] = 0;
	}
	$arResult['COOKIES'] = $_COOKIE;
}
$this->IncludeComponentTemplate();
?>
<?
use Bitrix\Main\Loader;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var $arResult
 * @var $arParams*/

if($this->StartResultCache(false, $arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())){
	
	$this->IncludeComponentTemplate();
}
?>
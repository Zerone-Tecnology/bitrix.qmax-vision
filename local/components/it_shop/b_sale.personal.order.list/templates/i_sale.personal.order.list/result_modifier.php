<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["ORDER_BY_STATUS"] = Array();
foreach($arResult["ORDERS"] as $val)
{
	$arResult["ORDER_BY_STATUS"][$val["ORDER"]["STATUS_ID"]][] = $val;
}
?>





<?/*if($USER->isAdmin()):?>
	<pre>
		<?print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>
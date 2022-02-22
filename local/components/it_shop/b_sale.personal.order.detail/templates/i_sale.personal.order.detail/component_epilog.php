<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	global $APPLICATION;

	if( $arResult['ACCOUNT_NUMBER'] )
		$APPLICATION->SetTitle(Loc::getMessage('SPOD_LIST_MY_ORDER', array(
			'#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
			'#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
			))
		);

	$APPLICATION->AddChainItem(Loc::getMessage('SPOD_LIST_MY_ORDER', array(
			'#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
			'#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
		)),
		'/personal/orders/?ID='.$arResult["ACCOUNT_NUMBER"]
	);

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
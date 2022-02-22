<?$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../..');
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_payment/processing/CNPMerchantWebServiceClient.php");
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Sale,
	Bitrix\Main\Loader,
	Bitrix\Highloadblock\HighloadBlockTable as HL,
	Bitrix\Main\Application;

Loader::IncludeModule("highloadblock");

$HLFE_value = HL::compileEntity(HL::getById(4)->fetch())->getDataClass();
$rsData = $HLFE_value::getList([
	'filter' => ['UF_CHECKED' => ''],
	'limit' => 1
]);
while($arData = $rsData->Fetch()){
	$arStatus[] = $arData;
}
if($arStatus) {
	$client = new CNPMerchantWebServiceClient();
	foreach ($arStatus as $item) {
		/*echo '<pre>';
		print_r($item);
		echo '</pre>';
		echo '<hr>';*/

		$params = new getTransactionStatus();
		$params->merchantId = $item['UF_MERCHANTID'];
		$params->referenceNr = $item['UF_RRN'];
		$tranResult = $client->getTransactionStatus($params);

		$status = $tranResult->return->transactionStatus;
		$hlbl = 4;
		$hlblock = HL::getById($hlbl)->fetch();
		$entity = HL::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();
		// Массив полей для обновления
		$data = array(
			"UF_ORDER_STATUS" => $status,
			"UF_CHECKED" => 'Y'
		);

		$result = $entity_data_class::update($item['ID'], $data);

		/*echo '<pre>';
		var_dump($tranResult);
		echo '</pre>';
		echo '<hr>';*/

		if ($tranResult->return->transactionStatus == "PAID") {
			CModule::IncludeModule("sale");
			CSaleOrder::PayOrder($item['UF_ORDER_ID'], "Y"); // статус оплачен (Y/N)
		} elseif ($tranResult->return->transactionStatus == "REVERSED") {
			CModule::IncludeModule("sale");
			CSaleOrder::CancelOrder($item['UF_ORDER_ID'], "Y");
		}
	}
}
?>
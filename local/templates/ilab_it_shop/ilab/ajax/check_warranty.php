<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*	Нельзя просто взять и по id положить в корзину...
	---------------------------------------------------------------------------------------------------- iLaB PowereD */
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$code = $request->getPost("code");
	if( $code )
	{
		$arFile = file( $_SERVER['DOCUMENT_ROOT'].'/numbers.csv' );

		foreach( $arFile as $key => $item )
		{
			if( $key == 0 ) continue;
			$str = explode(";", $item);
			$number_code = (string) $str[0];
			$arData[$number_code]['CODE'] = $number_code;
			$arData[$number_code]['DATE'] = (string) $str[1];
		}

		if( $arData[$code] )
		{
			$arResult['status'] = true;
			$arResult['date'] = $arData[$code]['DATE'];
		}
		else
		{
			$arResult['status'] = false;
			$arResult['message'] = 'Нет даты';
		}
	}
	else
	{
		$arResult['status'] = false;
		$arResult['message'] = 'Неверная передача данных';
	}
}
else
{
	$arResult['status'] = false;
	$arResult['message'] = 'Неверная передача данных';
}
echo json_encode($arResult);
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
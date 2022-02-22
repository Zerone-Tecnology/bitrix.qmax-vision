<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*	Нельзя просто взять и по id положить в корзину...
	---------------------------------------------------------------------------------------------------- iLaB PowereD */
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$login = $request->getPost("login");
	if( $login )
	{
		$password = randString(6, array("abcdefghijklnmopqrstuvwxyz0123456789"));

		$rsUser = CUser::GetByLogin($login);
		$arUser = $rsUser->Fetch();

		$user = new CUser;
		$fields = Array(
			"PASSWORD"          => $password,
		);


		// asdsdasdasdas@asdasdas.asd

		if($user->Update($arUser['ID'], $fields))
		{
			CEvent::Send(
				"MY_NEW_PASSWORD",
				"it",
				array(
					"LOGIN" => $arUser["LOGIN"],
					"EMAIL" => $arUser["EMAIL"],
					"PASSWORD" => $password,
					"USER_ID" => $arUser["ID"],
					"NAME" => $arUser["NAME"],
					"LAST_NAME" => $arUser["LAST_NAME"]
				)
			);
			echo 'true';
		}
		else echo 'false';
	}
}
else echo 'DataError';
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
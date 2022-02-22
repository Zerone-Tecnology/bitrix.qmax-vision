<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*	Нельзя просто взять и по id положить в корзину...
	---------------------------------------------------------------------------------------------------- iLaB PowereD */
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$email = $request->getPost("email");
	if( $email )
	{
		$rsUser = CUser::GetByLogin($email);
		$arUser = $rsUser->Fetch();
		if($arUser)
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
}
else echo 'DataError';
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
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
		$arFiler = array('EMAIL' => $email);
		$rsUser = CUser::GetList($by = 'ID', $order = 'ASC', $arFiler);
		while ($arUser = $rsUser->Fetch())
		{
			$usermail = $arUser["EMAIL"];

		}
		if($usermail == $email){
			echo 'true';
		}else{
			echo 'false';
		}
		/*$rsUser = CUser::GetByLogin($email);
		$arUser = $rsUser->Fetch();
		if($arUser)
		{
			echo 'true';
			echo $arUser['LOGIN'];
		}
		else
		{
			echo 'false';
		}*/
	}
}
else echo 'DataError';
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
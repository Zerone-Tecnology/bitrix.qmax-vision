<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$user	= $_POST['captcha_user'];
	$sid	= $_POST['captcha_sid'];

	if ( $APPLICATION->CaptchaCheckCode( $user, $sid ) )
		echo 'true';
	else
		echo 'false';
} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
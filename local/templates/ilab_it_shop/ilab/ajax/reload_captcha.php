<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// ---------------------------------------------------------------------------------------------------- iLaB
if ($_SERVER['REQUEST_METHOD'] == 'POST')
	echo $GLOBALS['APPLICATION']->CaptchaGetCode();
else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
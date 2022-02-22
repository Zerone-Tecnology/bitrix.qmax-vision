<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$email = htmlentities($_REQUEST['email']);
$pass = rawurldecode($_REQUEST['pass']);

if($email && $pass){
	$login_password_correct = false;
	if (
		isset( $email ) && strlen( $pass ) > 0
		&&
		isset( $email ) && strlen( $pass ) > 0
	)
	{

		$rsUser = CUser::GetByLogin( $email );
		if ($arUser = $rsUser->Fetch())
		{
			if(strlen($arUser["PASSWORD"]) > 32)
			{
				$salt = substr($arUser["PASSWORD"], 0, strlen($arUser["PASSWORD"]) - 32);
				$db_password = substr($arUser["PASSWORD"], -32);
			}
			else
			{
				$salt = "";
				$db_password = $arUser["PASSWORD"];
			}

			$user_password =  md5($salt.$pass);

			if ( $user_password == $db_password )
			{
				$login_password_correct = true;
			}
		}
	}
	if($login_password_correct)  $result['result'] = 'yes';
	else $result['result'] = 'error';

}else
	$result['result'] = 'error';
echo json_encode($result);?>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
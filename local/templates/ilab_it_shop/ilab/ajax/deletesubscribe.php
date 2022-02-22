<?
define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define('PUBLIC_AJAX_MODE', true);

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\SubscribeTable;
use Bitrix\Main\Application;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

Loc::loadMessages(__FILE__);

// ---------------------------------------------------------------------------------------------------- iLaB

$request = Application::getInstance()->getContext()->getRequest();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['deleteSubscribe'] == 'Y')
{
	$str = $request->getPost("data");

	$obj = json_decode(base64_decode($str));

	$id_product = $obj->id;
	$id_user = $obj->user;
	$id_email = $obj->email;


	if($id_email != null)
	{
		if($id_user=='null')
		{
			$where = "USER_CONTACT = '".$id_email."' AND ITEM_ID = ".$id_product;
			$strSql = "DELETE FROM b_catalog_subscribe WHERE $where";
			if( $DB->Query($strSql) )
				echo 'true';

			/*
			$where = "USER_CONTACT = '".$id_email."'";
			$strSql = "SELECT ID, USER_CONTACT,	USER_ID, ITEM_ID FROM b_catalog_subscribe WHERE $where GROUP BY ID";
			$res = $DB->Query($strSql);
			$arr_Prod = '';
			while ($row = $res->Fetch())
			{
				$arr_Prod .= $row['USER_CONTACT'].'#';
			}
			echo $arr_Prod;*/
		}
		else
		{
			$where = "USER_ID = ".$id_user." AND USER_CONTACT = '".$id_email."' AND ITEM_ID = ".$id_product;
			$strSql = "DELETE FROM b_catalog_subscribe WHERE $where";
			if( $DB->Query($strSql) )
				echo 'true';
			/*
			$where = "USER_CONTACT = '".$id_email."'";
			$strSql = "SELECT ID, USER_CONTACT,	USER_ID, ITEM_ID FROM b_catalog_subscribe WHERE $where GROUP BY ID";
			$res = $DB->Query($strSql);
			$arr_Prod = '';
			while ($row = $res->Fetch())
			{
				$arr_Prod[] = $row['ID'].'#';
			}*/
		}
	}
	else
	{
		echo 'error';
	}


} else
	echo 'DataError';

// ---------------------------------------------------------------------------------------------------- iLaB

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
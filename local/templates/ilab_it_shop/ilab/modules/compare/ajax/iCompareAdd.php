<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['KEY']=='CompareAdd_v0.0.1' )
{

	if( false )// debugging - true to view params
		print_r($_POST);

	if( !$_SESSION['CATALOG_COMPARE_LIST'][$_POST['iblock_id']]['ITEMS'][$_POST['id']] )
	{
		$APPLICATION->IncludeComponent(
			'bitrix:catalog.compare.list',
			'',
			Array( 'IBLOCK_ID' => $_POST['iblock_id'] ),
			false
		);
	}

	if( false )// debugging - true to view params
	{
		echo '<pre>';
		print_r($_SESSION['CATALOG_COMPARE_LIST']);
		echo '</pre>';
	}

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
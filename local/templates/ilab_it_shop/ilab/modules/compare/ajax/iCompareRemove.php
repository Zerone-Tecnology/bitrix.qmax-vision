<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['KEY']=='CompareRemove_v0.0.1' )
{

	if( false )// debugging - true to view params
		print_r($_POST);

	if( $_POST['id'] && $_POST['iblock_id'] )
	{

		if( !is_array($_POST['id']) )
			$_POST['id'] = array($_POST['id']);

		foreach($_POST['id'] as $id)
			if( $_SESSION['CATALOG_COMPARE_LIST'][$_POST['iblock_id']]['ITEMS'][$id] )
				unset( $_SESSION['CATALOG_COMPARE_LIST'][$_POST['iblock_id']]['ITEMS'][$id] );

	} elseif( $_POST['remove_all'] )
		unset( $_SESSION['CATALOG_COMPARE_LIST'] );

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
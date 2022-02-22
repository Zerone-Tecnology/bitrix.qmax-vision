<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['KEY']=='InputHidden_v0.0.1' )
{

	if( false )// debugging - true to view params
		print_r($_POST);

	if( $_POST['compare'] )
	{

		$arResult['compare']['id']		= [];
		$arResult['compare']['string']	= '|';
		$arResult['compare']['count']	= 0;
		foreach($_SESSION['CATALOG_COMPARE_LIST'] as $i)
			if( $i['ITEMS'] )
				foreach($i['ITEMS'] as $e)
				{
					$arResult['compare']['id'][]	=  $e['ID'];
					$arResult['compare']['string']	.= $e['ID'].'|';
					$arResult['compare']['count']	+= 1;
				}

	}

	if( $arResult )
		echo json_encode($arResult);

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
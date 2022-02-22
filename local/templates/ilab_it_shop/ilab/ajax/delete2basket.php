<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	if( !CModule::IncludeModule('sale') || !CModule::IncludeModule('catalog') )
		return;

	$id = intval( $_POST['id'] );

	if( CSaleBasket::Delete($id) )
		echo 'true';

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	if( !CModule::IncludeModule('iblock') )
		return;

	if( CIBlock::GetPermission($_POST['iblock'])>='W' )
	{
		$DB->StartTransaction();
		if( !CIBlockElement::Delete($_POST['id']) )
		{
			$strWarning .= 'Error!';
			$DB->Rollback();
		} else {
			$DB->Commit();
			echo 'true';
		}
	}

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
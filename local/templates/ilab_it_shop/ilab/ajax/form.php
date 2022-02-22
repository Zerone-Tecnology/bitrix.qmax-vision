<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
if ( $_SERVER['REQUEST_METHOD']=='POST' && $_POST['FPRO_KEY']=='45gsiLab+1S23T' )
{
	if( !CModule::IncludeModule('form') )
		return;

	unset( $_POST['FPRO_KEY'] );

	$arValues	= $_POST;// Массив значений ответов
	$FORM_ID	= $_POST['form_id'];// ID веб-формы

	unset( $arValues['captcha_word'] );
	unset( $arValues['form_id'] );

	if( $arValues )
	{
		// Создадим новый результат
		if ($RESULT_ID = CFormResult::Add($FORM_ID, $arValues))
		{
			CFormResult::SetEvent($RESULT_ID);
			CFormResult::Mail($RESULT_ID);// Создадим почтовое событие для отсылки по EMail данных результата
			echo 'true';// Если всё прошло true
		} else
			echo 'false';
	}
} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
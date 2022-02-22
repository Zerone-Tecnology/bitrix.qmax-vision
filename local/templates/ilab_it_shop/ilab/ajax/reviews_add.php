<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['FPRO_KEY']=='45gsiLab+1revAdd' )
{

	if( !CModule::IncludeModule('iblock') )
		return;

	$p_info					= explode('|', $_POST['product_ajax']);
	
	$PROP['PRODUCT']		= $p_info[0];
	$PROP['PRODUCT_NAME']	= $p_info[1];

	$arLoadProductArray = Array(
		'IBLOCK_ID'				=> $_POST['review_iblock_id'],
		'NAME'					=> $_POST['name'],
		'ACTIVE'				=> $_POST['approval_reviews'],
		'IBLOCK_SECTION_ID'		=> false,
		'DETAIL_TEXT'			=> $_POST['message'],
		'PROPERTY_VALUES'		=> $PROP
	);

	$el = new CIBlockElement;
	if( $PRODUCT_ID = $el->Add($arLoadProductArray) )
	{

		$type = 'Добавлен отзыв о товаре';
		$link = '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='.$_POST['review_iblock_id'].'&type=catalog&ID='.$PRODUCT_ID;
		$arEventFields = array('TYPE' => $type, 'DATE' => date('d.m.Y'), 'LINK' => $link);
		CEvent::Send('RESPONSE_SEND', SITE_ID, $arEventFields);

		echo 'true';// Если всё прошло true
	}


} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
<?// OLD Functionals
/*
if( CSite::InDir(SITE_DIR.'personal/basket.php') )
	$pl = 'c';
elseif( CSite::InDir(SITE_DIR.'catalog/') )
	$pl = 'l';
else
	$pl = 'r';?>

	<div class="i_modal jq_modal ipabs iohid<?=' '.$APPLICATION->GetDirProperty('i_class')?>">
		<div class="i_modal_tit jq_modal_tit ifont110">
			<span class="jqm_regi"><?=GetMessage('M_REGISTRATION')?></span>
			<span class="jqm_auth"><?=GetMessage('M_JOIN_CABINET')?></span>
			<span class="jqm_map"><?=GetMessage('M_ADDRESS_SHOP')?></span>
			<span class="jqm_feedback"><?=GetMessage('M_CONTACT_US')?></span>
			<span class="jqm_fpay"><?=GetMessage('M_FORM_OF_PAYMENT')?></span>
			<span class="jqm_dmet"><?=GetMessage('M_DELIVERY_METHODS')?></span>
			<span class="jqm_quick"><?=GetMessage('M_FAST_ORDER')?></span>
			<span class="jqm_review"><?=GetMessage('M_ADD_REVIEW')?></span>
			<span class="jqm_pay"><?=GetMessage('M_ADD_PAYMNET')?></span>
			<span class="jqm_del"><?=GetMessage('M_ADD_DELIVERY')?></span>
			<span class="jqm_to_order"><?=GetMessage('M_TO_ORDER')?></span>
			<span class="jqm_more_stock"><?=GetMessage('M_MORE_STOCK')?></span>
			<span class="jqm_more_expected"><?=GetMessage('M_MORE_EXPECTED')?></span>
			<span class="jqm_more_to_order"><?=GetMessage('M_MORE_TO_ORDER')?></span>
			<div class="i_modal_close jq_modal_close ipabs"></div>
		</div>
		<div class="i_modal_in jq_modal_in">
			<div class="jqm_regi idnone" id="jqm_regi"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_regi.php',Array(),Array('MODE'=>'html', 'NAME'=>'Регистрация', 'SHOW_BORDER'=>false))?></div>
			<div class="jqm_auth idnone" id="jqm_auth"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_auth.php',Array(),Array('MODE'=>'html', 'NAME'=>'Авторизация', 'SHOW_BORDER'=>false))?></div>
			<?//<div class="jqm_map"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_address_shop.php',Array(),Array('MODE'=>'html', 'NAME'=>'Адреса магазинов', 'SHOW_BORDER'=>false))</div>?>
			<?//<div class="jqm_feedback idnone" id="jqm_feedback"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_contact_us.php',Array(),Array('MODE'=>'html', 'NAME'=>'Связаться с нами', 'SHOW_BORDER'=>false))</div>?>
			<?//<div class="jqm_fpay idnone"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_fpay.php',Array(),Array('MODE'=>'html', 'NAME'=>'Виды оплаты', 'SHOW_BORDER'=>true))</div>?>
			<?//<div class="jqm_dmet idnone"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_dmet.php',Array(),Array('MODE'=>'html', 'NAME'=>'Способы доставки', 'SHOW_BORDER'=>true))</div>?>
			<?//<div class="jqm_quick idnone" id="jqm_quick"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_quick.php',Array(),Array('MODE'=>'html', 'NAME'=>'Быстрый заказ', 'SHOW_BORDER'=>false))</div>?>
			<div class="jqm_review idnone" id="jqm_review"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_review.php',Array(),Array('MODE'=>'html', 'NAME'=>'Добавить отзыв', 'SHOW_BORDER'=>false))?></div>
			<div class="jqm_pay idnone" id="jqm_pay"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_payment.php',Array(),Array('MODE'=>'html', 'NAME'=>'Оплата', 'SHOW_BORDER'=>true))?></div>
			<div class="jqm_del idnone" id="jqm_del"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_delivery.php',Array(),Array('MODE'=>'html', 'NAME'=>'Доставка', 'SHOW_BORDER'=>true))?></div>
			<?//<div class="jqm_to_order idnone" id="jqm_to_order"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_to_order.php',Array(),Array('MODE'=>'html', 'NAME'=>'Товар на заказ', 'SHOW_BORDER'=>true))</div>?>
			<div class="jqm_more_stock idnone" id="jqm_more_stock" jqpos="<?=$pl?>"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_more_stock.php',Array(),Array('MODE'=>'html', 'NAME'=>'В наличии', 'SHOW_BORDER'=>true))?></div>
			<div class="jqm_more_expected idnone" id="jqm_more_expected" jqpos="<?=$pl?>"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_more_expected.php',Array(),Array('MODE'=>'html', 'NAME'=>'Ожидается', 'SHOW_BORDER'=>true))?></div>
			<div class="jqm_more_to_order idnone" id="jqm_more_to_order" jqpos="<?=$pl?>"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_more_to_order.php',Array(),Array('MODE'=>'html', 'NAME'=>'На заказ', 'SHOW_BORDER'=>true))?></div>
		</div>
	</div>
<?//<div class="i_opacity jq_opacity idnone"></div>*/
// OLD Functionals?>


<?
$STP = SITE_TEMPLATE_PATH;
$l = LANGUAGE_ID;

// Bitrix\Main\Context::getCurrent()->getSite()
?>

<div class="i_modal j_modal idn">
	<div class="i_modal_delta j_modal_delta"></div>
	<div class="i_modal_title j_modal_title">
		<div class="j_m_regi"><?=GetMessage('M_REGISTRATION')?></div>
		<div class="j_m_auth"><?=GetMessage('M_JOIN_CABINET')?></div>
		<div class="j_m_map"><?=GetMessage('M_ADDRESS_SHOP')?></div>
		<div class="j_m_feedback"><?=GetMessage('M_CONTACT_US')?></div>
		<div class="j_m_fpay"><?=GetMessage('M_FORM_OF_PAYMENT')?></div>
		<div class="j_m_dmet"><?=GetMessage('M_DELIVERY_METHODS')?></div>
		<div class="j_m_quick"><?=GetMessage('M_FAST_ORDER')?></div>
		<div class="j_m_review"><?=GetMessage('M_ADD_REVIEW')?></div>
		<div class="j_m_pay"><?=GetMessage('M_ADD_PAYMNET')?></div>
		<div class="j_m_del"><?=GetMessage('M_ADD_DELIVERY')?></div>
		<div class="j_m_to_order"><?=GetMessage('M_TO_ORDER')?></div>
		<?/* TODO
		<span class="jqm_to_order"><?=GetMessage('M_TO_ORDER')?></span>
		<span class="jqm_more_stock"><?=GetMessage('M_MORE_STOCK')?></span>
		<span class="jqm_more_expected"><?=GetMessage('M_MORE_EXPECTED')?></span>
		<span class="jqm_more_to_order"><?=GetMessage('M_MORE_TO_ORDER')?></span>
*/?>
		<div class="i_modal_close j_modal_close"></div>
	</div>
	<div class="i_modal_body j_modal_body">
		<div id="j_m_regi" class="j_m_regi"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_regi.php',[],['MODE'=>'html', 'NAME'=>'Регистрация', 'SHOW_BORDER'=>false])?></div>
		<div id="j_m_auth" class="j_m_auth"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_auth.php',[],['MODE'=>'html', 'NAME'=>'Авторизация', 'SHOW_BORDER'=>false])?></div>
		<div class="j_m_map"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_address_shop.php',[],['MODE'=>'html', 'NAME'=>'Адреса магазинов', 'SHOW_BORDER'=>false])?></div>
		<div class="j_m_feedback"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_contact_us.php',[],['MODE'=>'html', 'NAME'=>'Связаться с нами', 'SHOW_BORDER'=>false])?></div>
<?/*
		<div class="j_m_fpay"><?$APPLICATION->IncludeFile($STP.'/ilab/inc/'.$l.'/m_payment.php',[],['MODE'=>'html', 'NAME'=>'Виды оплаты', 'SHOW_BORDER'=>false])?></div>
		<div class="j_m_dmet"><?$APPLICATION->IncludeFile($STP.'/ilab/inc/'.$l.'/m_delivery.php',[],['MODE'=>'html', 'NAME'=>'Способы доставки', 'SHOW_BORDER'=>false])?></div>
*/?>
		<div class="j_m_quick"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_quick.php',[],['MODE'=>'html', 'NAME'=>'Быстрый заказ', 'SHOW_BORDER'=>false])?></div>
		<div class="j_m_review"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_review.php',[],['MODE'=>'html', 'NAME'=>'Добавить отзыв', 'SHOW_BORDER'=>false])?></div>
		<div class="j_m_pay"><?$APPLICATION->IncludeFile($STP.'/ilab/inc/'.$l.'/m_fpay.php',[],['MODE'=>'html', 'NAME'=>'Оплата', 'SHOW_BORDER'=>true])?></div>
		<div class="j_m_del"><?$APPLICATION->IncludeFile($STP.'/ilab/inc/'.$l.'/m_dmet.php',[],['MODE'=>'html', 'NAME'=>'Доставка', 'SHOW_BORDER'=>true])?></div>
		<div class="j_m_to_order"><?$APPLICATION->IncludeFile($STP.'/ilab/comp/'.$l.'/m_to_order.php',[],['MODE'=>'html', 'NAME'=>'Товар на заказ', 'SHOW_BORDER'=>true])?></div>
		<?/* TODO
		<div class="jqm_to_order idnone" id="jqm_to_order"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_to_order.php',Array(),Array('MODE'=>'html', 'NAME'=>'Товар на заказ', 'SHOW_BORDER'=>true))</div>?>
		<div class="jqm_more_stock idnone" id="jqm_more_stock" jqpos="<?=$pl?>"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_more_stock.php',Array(),Array('MODE'=>'html', 'NAME'=>'В наличии', 'SHOW_BORDER'=>true))?></div>
		<div class="jqm_more_expected idnone" id="jqm_more_expected" jqpos="<?=$pl?>"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_more_expected.php',Array(),Array('MODE'=>'html', 'NAME'=>'Ожидается', 'SHOW_BORDER'=>true))?></div>
		<div class="jqm_more_to_order idnone" id="jqm_more_to_order" jqpos="<?=$pl?>"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_more_to_order.php',Array(),Array('MODE'=>'html', 'NAME'=>'На заказ', 'SHOW_BORDER'=>true))?></div>
*/?>
	</div>
</div>
<?/*<div class="i_opacity jq_opacity idn"></div>*/?>
<?
// ---------------------------------------------------------------------------------------------------- DEMO
		  Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('browser')?>
			<div class="i_demo jq_demo i_browser">
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/browser.php',Array(),Array('MODE'=>'html', 'NAME'=>'', 'SHOW_BORDER'=>true));// browser?>
			</div>
		<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('browser','')
// ---------------------------------------------------------------------------------------------------- DEMO
?>
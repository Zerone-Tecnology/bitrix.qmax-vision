<?
// ---------------------------------------------------------------------------------------------------- DEMO
		  Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('demo')?>
			<div class="i_demo jq_demo<?if( isset($_COOKIE['I_DEMO']) )echo ' idnone'?>">
				<div class="i_demo_close jq_demo_close">×</div>
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/demo.php',Array(),Array('MODE'=>'html', 'NAME'=>'Деманстрационная инфа', 'SHOW_BORDER'=>true));// DEMO?>
			</div>
			<div class="i_demo_info jq_demo_info<?if( !isset($_COOKIE['I_DEMO']) )echo ' idnone'?>">
				<span class="i_demo_info_span"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/demo_info.php',Array(),Array('MODE'=>'html', 'NAME'=>'Инфо', 'SHOW_BORDER'=>true));// DEMO INFO?></span>
			</div>
		<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('demo','')
// ---------------------------------------------------------------------------------------------------- DEMO
?>
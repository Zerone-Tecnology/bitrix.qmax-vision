<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
  // ---------------------------------------------------------------------------------------------------- iLaB?>

<header class="i_header">
	<div class="i_wr">
	<div class="i_hbottom">
		<div class="i_left_col">
			<a href="<?=SITE_DIR?>" class="i_hlogo"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_logo.php',Array(),Array('MODE'=>'html', 'NAME'=>'Логотип', 'SHOW_BORDER'=>true))// Logo?></a>
		</div>
		<div class="i_right_col">
			<div class="i_top_flex">
				<div class="i_hcontact"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_contact.php',Array(),Array('MODE'=>'html', 'NAME'=>'Контакты', 'SHOW_BORDER'=>true))// Contacts?></div>
				<div class="i_hbasket jq_hbasket" id="jq_hbasket"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/h_basket.php',Array(),Array('SHOW_BORDER'=>false))// SmallBasket?></div>
			</div>
			<div class="i_bottom_flex">
				<div class="i_hblocklink">
					<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/h_lang_version.php',Array(),Array('SHOW_BORDER'=>false))// Language Versions?>
					<a href="<?=SITE_DIR?>contacts/" class="i_hfeedback jq_hfeedback ifleft"><span><?=GetMessage('CONTACT_US')?></span></a>
					<a href="<?=SITE_DIR?>contacts/" class="i_fmap jq_fmap ifleft" jq_id="i_pos_map"><span><?=GetMessage('MAP')?></span></a>
					<a href="<?=SITE_DIR?>contacts/" class="i_fmap i_pay jq_fpay ifleft" jq_id="i_pos_pay"><span><?=GetMessage('H_PAYMENT')?></span></a>
					<a href="<?=SITE_DIR?>contacts/" class="i_fmap i_del jq_fdel ifleft" jq_id="i_pos_del"><span><?=GetMessage('H_DELIVERY')?></span></a>
				</div>
				<?/*$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search_flat.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search*/?>
			</div>
		</div>
	</div>
	</div>
</header>

<?// ---------------------------------------------------------------------------------------------------- iLaB?>
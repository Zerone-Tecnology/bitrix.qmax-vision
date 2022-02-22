<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB?>

	<header class="i_header">
		<div class="i_wr">
			<div class="i_line_header_v3">
                <span class="show_hide_menu j_show_hide_menu"></span>
				<a href="<?=SITE_DIR?>" class="i_hlogo"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_logo.php',Array(),Array('MODE'=>'html', 'NAME'=>'Логотип', 'SHOW_BORDER'=>true))// Logo?></a>
				<div class="i_hcontact"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_contact.php',Array(),Array('MODE'=>'html', 'NAME'=>'Контакты', 'SHOW_BORDER'=>true))// Contacts?></div>

				<div class="i_line_header_icons">
					<div class="i_line_header_icons_item">
						<a href="<?=SITE_DIR?>contacts/" class="i_fmap i_pay jq_ad_fpay ifleft">
							<span><?=GetMessage('H_PAYMENT')?></span>
						</a>
<?/*
						<div class="i_modal j_modal ipabs iohid" id="jq_ad_fpay">
							<div class="i_modal_tit" id="i_pos_ad_pay">
								<div class="jqm_pay"><?=GetMessage('M_ADD_PAYMNET')?></div>
								<div class="i_modal_close j_modal_close ipabs"></div>
							</div>
							<div class="i_modal_in">
								<div class="jqm_pay" id="jqm_pay"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_payment.php',Array(),Array('MODE'=>'html', 'NAME'=>'Оплата', 'SHOW_BORDER'=>true))?></div>
							</div>
						</div>
*/?>
					</div>
					<div class="i_line_header_icons_item">
						<a href="<?=SITE_DIR?>contacts/" class="i_fmap i_del jq_ad_fdel ifleft">
							<span><?=GetMessage('H_DELIVERY')?></span>
						</a>
<?/*
						<div class="i_modal j_modal ipabs iohid" id="jq_ad_fdel">
							<div class="i_modal_tit" id="i_pos_ad_del">
								<div class="jqm_del"><?=GetMessage('M_ADD_DELIVERY')?></div>
								<div class="i_modal_close j_modal_close ipabs"></div>
							</div>
							<div class="i_modal_in">
								<div class="jqm_del" id="jqm_del"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_delivery.php',Array(),Array('MODE'=>'html', 'NAME'=>'Доставка', 'SHOW_BORDER'=>true))?></div>
							</div>
						</div>
*/?>
					</div>
				</div>
				<div class="i_hbasket jq_hbasket" id="jq_hbasket"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/h_basket.php',Array(),Array('SHOW_BORDER'=>false))// SmallBasket?></div>
			</div>
		</div>
	</header>


<?// ---------------------------------------------------------------------------------------------------- iLaB?>
<footer class="i_footer">
	<div class="i_wr">
		<div class="i_footer_flex">
			<div class="i_footer_flex_left">
				<div class="i_footer_flex_phone">
					<div class="i_fphone_tele"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_telephone.php',Array(),Array('MODE'=>'html', 'NAME'=>'Телефон', 'SHOW_BORDER'=>true));// Telephone?></div>
					<div class="i_fphone_mobi"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_mobphone.php',Array(),Array('MODE'=>'html', 'NAME'=>'Мобильный телефон', 'SHOW_BORDER'=>true));// Mobphone?></div>
				</div>
				<div class="i_footer_flex_other">
					<div class="i_faddress"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_address.php',Array(),Array('MODE'=>'html', 'NAME'=>'Адрес', 'SHOW_BORDER'=>true));// Address?></div>
					<div class="i_footer_map_wrap">
						<a href="<?=SITE_DIR?>contacts/" class="i_footer_map j_ad_fmap"><?=GetMessage('MAP')?></a>
<?/*
						<div class="i_modal j_modal ipabs iohid" id="j_ad_fmap">
							<div class="i_modal_tit" id="i_pos_ad_pay">
								<div class="jqm_pay"><?=GetMessage('M_ADDRESS_SHOP')?></div>
								<div class="i_modal_close j_modal_close ipabs"></div>
							</div>
							<div class="i_modal_in">
								<div class="jqm_map"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_address_shop.php',Array(),Array('MODE'=>'html', 'NAME'=>'Адреса магазинов', 'SHOW_BORDER'=>false))?></div>
							</div>
						</div>
*/?>
					</div>
					<div class="i_femail"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_email.php',Array(),Array('MODE'=>'html', 'NAME'=>'email адрес', 'SHOW_BORDER'=>true));// E-mail?></div>
                </div>
                <div class="i_footer_flex_network">
                    <div class="i_fsocial"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/f_social.php',Array(),Array('MODE'=>'html', 'NAME'=>'Соц. сети', 'SHOW_BORDER'=>false));// Social?></div>
				</div>
			</div>
			<?/* <div class="i_footer_flex_right"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/f_menu.php',Array(),Array('MODE'=>'html', 'NAME'=>'Footer меню', 'SHOW_BORDER'=>false));// Footer menu?></div> */?>
		</div>
	</div>
</footer>

<div class="i_bfooter">
	<div class="i_wr">
		<div class="i_bfooter_flex">
			<div class="i_flex_left">
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_copy.php',Array(),Array('MODE'=>'html', 'NAME'=>'Копирайт', 'SHOW_BORDER'=>true));// Copyright?>
				<div><?echo GetMessage('COPY').'&nbsp;'.date('Y')?>.</div>
			</div>
			<div class="i_flex_center">
				<div class="i_introduction"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_introduction.php',Array(),Array('MODE'=>'html', 'NAME'=>'Внедрение интернет магазина', 'SHOW_BORDER'=>true));// Introduction?></div>
			</div>
			<div class="i_flex_right">
				<div class="i_ilab"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/ilab.php',Array(),Array('MODE'=>'html', 'NAME'=>'ilab', 'SHOW_BORDER'=>false));// ilab?></div>
				<div class="i_composite ipabs" id="bx-composite-banner"></div>
			</div>
		</div>
	</div>
</div>

<div class="i_footer_panel">
    <div class="i_footer_panel_content">
        <div class="i_footer_cat">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_fp_menu.php',Array(),Array('MODE'=>'html', 'NAME'=>'Вертикальное меню каталога', 'SHOW_BORDER'=>false));// Vertical catalog menu?>
        </div>

		<a href="javascript:void(0)" class="i_footer_compare j_open_compare">
			<span>Сравнить </span>
			<span class="j_fp_comp_count">
				(<?=count($_SESSION['CATALOG_COMPARE_LIST']['3']['ITEMS'])?>)
			</span>
		</a>
		<a href="/personal/basket.php?wlist=Y" class="i_footer_favorite">
			<span>В избранное</span>
		</a>
        <div class="i_footer_cabinet i_login">
			<?if($USER->isAuthorized()):?>
				<?/*<a href="<?=SITE_DIR?>personal/orders/" class="i_login_cabinet"><span><?=GetMessage('CABINET')?></span></a>
                    <span class="i_log_sep"></span>*/?>
                <a href="<?=SITE_DIR?>personal/private/" class="i_fp_login_name"><span><?=$USER->GetLogin()?></span></a>
<!--                <a href="?logout=yes" class="i_login_exit"></a>-->
			<?else:?>
                <a href="<?=SITE_DIR?>personal/orders/" class="i_auth_personal jq_fp_auth_personal"><span><?=GetMessage('AUTH_PERSONAL')?></span></a>
<?/*
                <div class="i_modal j_modal ipabs iohid" id="jq_fp_auth_personal">
                    <div class="i_modal_tit" id="i_fp_auth_personal">
                        <div class="jqm_auth"><?=GetMessage('M_JOIN_CABINET')?></div>
                        <div class="i_modal_close j_modal_close ipabs"></div>
                    </div>
                    <div class="i_modal_in">
                        <div class="jqm_auth" id="jqm_auth"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_auth.php',Array(),Array('MODE'=>'html', 'NAME'=>'Авторизация', 'SHOW_BORDER'=>false))?></div>
                    </div>
                </div>
*/?>
				<?/*<span class="i_log_sep"></span>
                    <a class="i_tlogo" href="<?=SITE_DIR?>"></a>
                    <a href="/auth.php?register=yes" class="i_registration jq_registration"><span><?=GetMessage('REGISTRATION')?></span></a>*/?>
			<?endif?>
        </div>
        <div class="i_footer_search">
		    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search_footer.php',Array(),Array('MODE'=>'html', 'NAME'=>'Footer search', 'SHOW_BORDER'=>false));// Footer search?>
        </div>
        <div class="i_hbasket jq_hbasket" id="jq_hbasket">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/h_basket.php',Array(),Array('SHOW_BORDER'=>false))// SmallBasket?>
        </div>
    </div>
</div>

<? require($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/site_color_selected.php'); ?>

<div class="i_menu_view">
	<div class="i_menu_view_title j_show_param">
	</div>
	<div class="i_menu_view_cont">
		<div class="i_menu_view_item_title main_title"><span>Настройки сайта</span></div>
		<div class="i_menu_view_item_title"><span>Цвет сайта</span></div>
		<div class="i_menu_view_item_cont colors j_menu_view_item_cont" data-color="<?=$color?>">
			<span class="j_ch_color<?if($color=='#f75b18') echo ' selected';?>" data-color="#f75b18" style="background: #f75b18"></span>
			<span class="j_ch_color<?if($color=='#4d3b3b') echo ' selected';?>" data-color="#4d3b3b" style="background: #4d3b3b"></span>
			<span class="j_ch_color<?if($color=='#ff8a00') echo ' selected';?>" data-color="#ff8a00" style="background: #ff8a00"></span>
			<span class="j_ch_color<?if($color=='#e51b11') echo ' selected';?>" data-color="#e51b11" style="background: #e51b11"></span>
		</div>
		<div class="i_menu_view_item_title j_menu_view_item_title" data-view="<?=$view?>"><span>Расположение меню</span></div>
		<div class="i_menu_view_item_cont">
			<div class="i_menu_view_item jq_hor_menu j_menu_view_item<?if($view=='hor') echo ' selected';?>" data-menu="hor"><span>горизонтальное</span></div>
			<div class="i_menu_view_item jq_ver_menu j_menu_view_item<?if($view=='ver') echo ' selected';?>" data-menu="ver"><span>вертикальное</span></div>
		</div>
		<div class="i_menu_view_footer">
			<div class="apply j_menu_view_apply">Применить</div>
			<div class="default j_menu_view_default"><span>По умолчанию</span></div>
		</div>
	</div>
</div>

<div class="i_up j_up idnone"></div>


<?/*<div class="i_panel jq_panel ipfix">
	<div class="i_wr"><img src="<?=SITE_TEMPLATE_PATH.'/tmpl/del/panel.png'?>"></div>
</div>*/?>


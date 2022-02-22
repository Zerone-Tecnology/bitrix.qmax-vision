<div class="i_tblock">
	<div class="i_wr">
		<nav class="i_topmenu"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/h_topmenu.php',Array(),Array('SHOW_BORDER'=>false))// Topmenu?></nav>
        <div class="i_hcontact i_hcontact_width_max"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_contact.php',Array(),Array('MODE'=>'html', 'NAME'=>'Контакты', 'SHOW_BORDER'=>true))// Contacts?></div>

        <div class="i_login">
			<?if($USER->isAuthorized()):?>
				<a href="<?=SITE_DIR?>personal/orders/" class="i_login_cabinet"><span><?=GetMessage('CABINET')?></span></a>
				<?/*<span class="i_log_sep"></span>
                <a href="<?=SITE_DIR?>personal/private/" class="i_login_name"><span><?=$USER->GetLogin()?></span></a>*/?>
                <a href="?logout=yes" class="i_login_exit"></a>
                    <div class="i_line_header_search">
                        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search_flat.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search?>
                    </div>
                    <div class="i_search_mobile iprel i_search_mobile_header">
                        <span class="i_search_footer_mobile j_search_footer_mobile"></span>
                        <div class="i_search_footer_mobile_cont idnone">
                            <div id="<?=$CONTAINER_ID?>" class="i_search_flat  jq_search ipabs">
                                <span class="i_s_close j_s_close"></span>
                                <form action="/search/index.php">
                                    <input id="<?=$INPUT_ID?>" type="text" name="q" placeholder="<?=GetMessage('SITE_SEARCH')?>" size="3" maxlength="300" autocomplete="off" />
                                    <input class="search-button" name="s" type="submit" value="<?=GetMessage("CT_BST_SEARCH_BUTTON");?>" />
                                </form>
                            </div>
                        </div>
                    </div>
			<?else:?>
				<a href="<?=SITE_DIR?>personal/orders/" class="i_auth_personal jq_auth_personal"><span><?=GetMessage('AUTH_PERSONAL')?></span></a>
				<span class="i_log_sep"></span>
				<a class="i_tlogo" href="<?=SITE_DIR?>"></a>
				<?/*<a href="/auth.php?register=yes" class="i_registration jq_registration"><span><?=GetMessage('REGISTRATION')?></span></a>*/?>
                <div class="i_line_header_search">
					<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search_flat.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search?>
                </div>
                <div class="i_search_mobile iprel i_search_mobile_header">
                    <span class="i_search_footer_mobile j_search_footer_mobile"></span>
                    <div class="i_search_footer_mobile_cont idnone">
                        <div id="<?=$CONTAINER_ID?>" class="i_search_flat  jq_search ipabs">
                            <span class="i_s_close j_s_close"></span>
                            <form action="/search/index.php">
                                <input id="<?=$INPUT_ID?>" type="text" name="q" placeholder="<?=GetMessage('SITE_SEARCH')?>" size="3" maxlength="300" autocomplete="off" />
                                <input class="search-button" name="s" type="submit" value="<?=GetMessage("CT_BST_SEARCH_BUTTON");?>" />
                            </form>
                        </div>
                    </div>
                </div>

			<?endif?>
		</div>
	</div>
</div>

<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/h_leftmenu.php',Array(),Array('SHOW_BORDER'=>false))// Leftmenu?>


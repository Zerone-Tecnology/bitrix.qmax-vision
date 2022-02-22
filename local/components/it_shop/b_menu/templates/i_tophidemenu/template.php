<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
//$this->setFrameMode(true);

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Application;

$docRoot = Application::getDocumentRoot();

Loc::loadMessages($docRoot.SITE_TEMPLATE_PATH.'/header.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>
    <div class="i_lblock">
        <div class="i_menu_div_block">
            <div class="menutitle"><span class="close_hide_menu j_close_hide_menu"></span>Меню сайта</div>
            <div class="menu_login">
            <?if($USER->isAuthorized()):?>
                <a href="<?=SITE_DIR?>personal/private/" class="menucabinet"><span><?=$USER->GetLogin()?></span></a>
                <a href="?logout=yes" class="i_login_exit"><span>Выйти</span></a>
            <?else:?>
                <a href="<?=SITE_DIR?>personal/orders/" class="menucabinet i_auth_personal jq_hp_auth_personal"><span><?=GetMessage('AUTH_PERSONAL')?></span></a>
<?/*
                <div class="i_modal j_modal ipabs iohid" id="jq_hp_auth_personal">
                    <div class="i_modal_tit" id="i_hp_auth_personal">
                        <div class="jqm_auth"><?=GetMessage('M_JOIN_CABINET')?></div>
                        <div class="i_modal_close j_modal_close ipabs"></div>
                    </div>
                    <div class="i_modal_in">
                        <div class="jqm_auth" id="jqm_auth"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_auth.php',Array(),Array('MODE'=>'html', 'NAME'=>'Авторизация', 'SHOW_BORDER'=>false))?></div>
                    </div>
                </div>
*/?>
            <?endif;?>
            </div>
            <div class="i_scroll_height_auto">
                <div class="i_tm_scroll j_lmenu_scrollbar scrollbar-inner">
                    <? foreach($arResult as $key=>$arItem): ?>
                        <div class="menudiv<?if($arItem['SELECTED']) echo ' selected';?>"><a class="menulink j_menulink <?if($arItem['ITEMS']) echo "i_link_arrow"?>" href="<?=$arItem['LINK']?>"><?= $arItem['TEXT']?></a>
                        <? if($arItem['ITEMS']): ?>
                            <div class="menusub j_menusub">
                                <? foreach($arItem['ITEMS'] as $arSub): ?>
                                    <a class="menusublink<?if($arSub['SELECTED']) echo ' select';?>" href="<?=$arSub['LINK']?>"><?=$arSub['TEXT']?></a>
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>
                        </div>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>
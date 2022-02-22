<header class="i_header">
    <div class="i_header_wrap">
        <a href="<?=SITE_DIR?>" class="i_hlogo"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_logo.php',Array(),Array('MODE'=>'html', 'NAME'=>'Логотип', 'SHOW_BORDER'=>true))// Logo?></a>
        <div class="i_header_cont">
            <div class="i_hcontact">
            	<span class="i_tcontact_but j_tcontact_but"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_contact.php',Array(),Array('MODE'=>'html', 'NAME'=>'Контакты', 'SHOW_BORDER'=>true))// Contacts?></span>
            	<div class="i_tcontact_cont j_tcontact_cont idnone"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/h_schedule.php',Array(),Array('MODE'=>'html', 'NAME'=>'График работы\Контакты', 'SHOW_BORDER'=>true))// Schedule?></div>
           	</div>
            <a href="<?if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo '/catalog/'; if( CSite::InDir(SITE_DIR.'personal/order.php') )echo '/personal/basket.php'?>" class="i_hback"><?echo ( CSite::InDir(SITE_DIR.'personal/basket.php') ) ? GetMessage('BACK') : GetMessage('BACK_TO_BASKET')?></a>
        </div>
    </div>
</header>
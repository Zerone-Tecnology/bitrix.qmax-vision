<?
/* ----------------------------------------------------------------------------------------------------
Кто сюда попал? - mini INFO о проекте почитайте ка тут - /local/templates/ilab_it_shop/tmpl/info.txt
---------------------------------------------------------------------------------------------------- */
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
IncludeTemplateLangFile(__FILE__);

require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/tmpl/redirect.php');// Redirect
/*
// Переменая для условий легкой корзины и оформление заказа.
if( CSite::InDir(SITE_DIR.'personal/basket.php') || CSite::InDir(SITE_DIR.'personal/order.php') )
	$inc = '_b';
*/

$index = CSite::InDir(SITE_DIR.'index.php');
$personal = CSite::InDir(SITE_DIR.'personal/');
$order = CSite::InDir(SITE_DIR.'personal/basket.php') || CSite::InDir(SITE_DIR.'personal/order.php')/* || CSite::InDir(SITE_DIR.'personal/test.php')*/;
$catalog = CSite::InDir(SITE_DIR.'catalog/');
$internal = !$order && !$index;
//$internal = !$order && !$catalog && !$index;

// Переменая для условий легкой корзины и оформление заказа.
if( $order )
	$tmpl = 'basket';
else
	$tmpl = 'main';?>

<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>-<?=strtoupper(LANGUAGE_ID)?>">

	<head>



		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K24Z547');</script>
<!-- End Google Tag Manager -->

		<?$APPLICATION->ShowHead();
		$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/head.php',Array(),Array('SHOW_BORDER'=>false));
		$APPLICATION->ShowPanel()?>
		<style>.i_title::before { background-image: url(<?=$APPLICATION->GetDirProperty('i_background')?>) }</style>
	</head>

	<body class="page<?if( $catalog )echo ' i_catalog';if( $personal )echo ' i_personal_page';if( $index )echo ' i_index_page'?>">

		<?// ---------------------------------------------------------------------------------------------------- BODY BEFORE
		Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('body_before')?>
		<div class="i_body_before"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/body_before.php',Array(),Array('MODE'=>'html', 'NAME'=>'body before', 'SHOW_BORDER'=>false))// Before?></div>
		<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('body_before','')
		// ---------------------------------------------------------------------------------------------------- BODY BEFORE?>

		<div class="idnone">
			<!--[if lte IE 8]>
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_browser.php',Array(),Array('MODE'=>'html', 'NAME'=>'Browser', 'SHOW_BORDER'=>false))// browser?>
			<![endif]-->
		</div>

		<?if( $index ):?>
			<div class="i_ban_bg jq_ban_bg"></div>
		<?endif?>

		<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_demo.php',Array(),Array('MODE'=>'html', 'NAME'=>'DEMO', 'SHOW_BORDER'=>false))// DEMO?>

		<?if( $tmpl=='main' )
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/main/topblock.php',Array(),Array('MODE'=>'html', 'NAME'=>'Верхний блок', 'SHOW_BORDER'=>false))// TopBlock?>


		<div class="i_wrapper iprel aclear<?if( $tmpl=='basket' )echo ' i_basket_wrap'?>">

			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/'.$tmpl.'/header.php',Array(),Array('MODE'=>'html', 'NAME'=>'Шапка сайта', 'SHOW_BORDER'=>false));// Header?>

			<?//if( $internal )// ???????????????????
//				$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/i_in_center.php',Array(),Array('MODE'=>'html', 'NAME'=>'Центр блок', 'SHOW_BORDER'=>false));// Center block?>

			<?if( $index ):?>
                <h1 class="i_hide_title ipabs"><?$APPLICATION->ShowTitle()?></h1>
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/main/index.php',Array(),Array('MODE'=>'html', 'NAME'=>'Главная страница', 'SHOW_BORDER'=>false));// Index
			elseif( $internal ):?>

				<div class="i_work_area<?if(CSite::InDir(SITE_DIR.'catalog/')) echo ' i_cat_work'?><?if( !CSite::InDir(SITE_DIR.'index.php') && !CSite::InDir(SITE_DIR.'catalog/') )echo ' i_typical'?><?if( CSite::InDir(SITE_DIR.'personal/') )echo ' i_personal'; if( $APPLICATION->GetDirProperty('i_class') ) echo ' '.$APPLICATION->GetDirProperty('i_class'); ?>">
					<div class="i_wr">


						<?if( !$index && !$catalog ):
							$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_center.php',Array(),Array('MODE'=>'html', 'NAME'=>'Центр блок', 'SHOW_BORDER'=>false));// Center block
							$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_breadcrumb.php',Array(),Array('MODE'=>'html', 'NAME'=>'Хлебные-крошки', 'SHOW_BORDER'=>false));// Breadcrumb
						endif?>

						<?if( !$catalog ):?>
							<div class="i_lwork_flex">
								<div class="i_lwork i_w700 i_lwork_left ifleft">
									<?if( $APPLICATION->GetDirProperty('i_background') )echo '<div class="i_title">'?>
									<h1><?$APPLICATION->ShowTitle()?></h1>
									<?if( $APPLICATION->GetDirProperty('i_background') )echo '</div>'?>
						<?endif?>


			<?endif?>

			<?/*
				<div class="i_work_area<?if( !CSite::InDir(SITE_DIR.'index.php') && !CSite::InDir(SITE_DIR.'catalog/') )echo ' i_typical'?>">
			*/?>

<div class="i_work_content<?if( CSite::InDir(SITE_DIR.'contacts/') ) echo ' i_contacts_page' ?><?if( CSite::InDir(SITE_DIR.'index.php') ) echo ' i_index_page' ?>">


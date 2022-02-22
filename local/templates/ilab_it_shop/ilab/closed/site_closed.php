<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
//	---------------------------------------------------------------------------------------------------- iLaB PowereD?>

		<title>Сайт закрыт</title>

		<link sizes="32x32" type="images/x-icon" href="<?=SITE_TEMPLATE_PATH?>/ilab/img/icon/favicon.png" rel="icon">
		<link type="images/x-icon" href="<?=SITE_TEMPLATE_PATH?>/ilab/img/icon/favicon.ico" rel="shortcut icon">

		<?use \Bitrix\Main\Page as BMPage;
// ---------------------------------------------------------------------------------------------------- CSS
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/ilab/closed/site_closed.css')?>

		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
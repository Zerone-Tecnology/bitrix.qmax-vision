<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB PowereD?>

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<meta name="yandex-verification" content="3eadb1f31c4b3fb3" />
	<meta name="google-site-verification" content="aGEe6KrB17TwqXEOS-0vj0UiEgQGpMX32ECPce2_RSA" />

		<title><?$APPLICATION->ShowTitle()?></title>

		<link sizes="32x32" type="images/x-icon" href="<?=SITE_TEMPLATE_PATH?>/ilab/img/icon/favicon.png" rel="icon">
		<link type="images/x-icon" href="<?=SITE_TEMPLATE_PATH?>/ilab/img/icon/favicon.ico" rel="shortcut icon">

		<?use \Bitrix\Main\Page as BMPage;

		require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/site_color_selected.php');
/*
		// CSS
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/normalize.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/main.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/pre.css');

		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/style2.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/color/c_ilabshop2.css');

//		if($color == '#f75b18')
//			BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/color/c_ilabshop2.css');// Цветовые схемы /local/templates/ilab_it_shop/tmpl/css/color/название проекта.css

		if( $color=='#e51b11' )
			BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/color/c_ilabshop_red.css');// Цветовые схемы /local/templates/ilab_it_shop/tmpl/css/color/название проекта.css
		elseif( $color=='#ff8a00' )
			BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/color/c_ilabshop_orange.css');// Цветовые схемы /local/templates/ilab_it_shop/tmpl/css/color/название проекта.css
		elseif( $color=='#4d3b3b' )
			BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/color/c_ilabshop_brown.css');// Цветовые схемы /local/templates/ilab_it_shop/tmpl/css/color/название проекта.css

//		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/reset.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/jquery.formstyler.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/jquery.formstyler.therme.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/swiper.min.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/fancybox.css');
		BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/p_ilab/cs/iCompareModal.css');// p_ilab
		// BACKGROUND CSS
		if( file_exists($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/img/fon/background.png') )// -- Фоновый рисунок
			BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/background.css');

        // JS
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.min.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.formstyler.min.js');


        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/idangerous.swiper.min.js');// v3.4.1
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.scrollbar.js');// v3.4.1
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/shapeshift.min.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.form.min.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.fancybox.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.fancybox.thumbs.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.cookie.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.maskedinput.min.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/inputmask.min.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/inputmask.extensions.min.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/jquery.inputmask.min.js');

        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/swiper.min.js');

        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/components.js');

        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/functions.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/script.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/ab_script.js');
        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/ilab/js/ms_script.js');

        BMPage\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/p_ilab/js/jquery.ilab.js');
*/
		// PHP
		require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/modules/compare/php/functions.php');
		require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');
		require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/item.php');
// ---------------------------------------------------------------------------------------------------- RANDOM(preview) commenting out code
		//require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/random.php');
// ---------------------------------------------------------------------------------------------------- RANDOM(preview) commenting out code?>
<?/*
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
*/?>

		<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>

		<script src="//code.jivosite.com/widget.js" data-jv-id="haqfmxSCbC" skip-moving="true" async></script>
<?/*
		<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/tmpl/css/color/c_istore.css">
*/?>

<script type="text/javascript">
 (function(d, w, s) {
    var widgetHash = '2vb3p8qe39mjxqnkhbec', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
    gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
    var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
 })(document, window, 'script');
</script>
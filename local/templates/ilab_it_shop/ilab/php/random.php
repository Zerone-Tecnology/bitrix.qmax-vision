<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('random');

	$arImg		= array('background_1.jpg', 'background_2.jpg', 'background_3.jpg', 'background_4.jpg', 'background_5.jpg', 'background_6.jpg');
	$keyImg		= array_rand($arImg);
/*
	$arCss		= array('c_blue.css', 'c_red.css');
	$keyCss		= array_rand($arCss);

	use \Bitrix\Main\Page as BMPage;
	BMPage\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/tmpl/css/color/c_red.css');//.$arCss[$keyCss]
*/?>
	<?/*<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/tmpl/css/color/<?=$arCss[$keyCss]?>">*/?>
	<style>
	body { background: url(/local/templates/ilab_it_shop/ilab/img/fon/<?=$arImg[$keyImg]?>) no-repeat center top }
		.i_wrapper {
			background-color: #FFF;
			position: relative;/*<div class="i_tblock"> fix width 940px*/
			padding: 0 20px;
			width: 980px;

		-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		   -moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}
		.i_tblock {
			width: 980px;
			margin: 0 auto;
		}
	</style>

<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('random', '');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD?>
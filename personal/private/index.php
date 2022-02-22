<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<div class="i_personal_options_block">
	<h2>Основные параметры:</h2>
	<?$APPLICATION->IncludeComponent(
		"it_shop:b_main.profile",
		"i_main.profile",
		Array(
		)
	);?>
</div>
<div class="i_personal_profile_block">
	<h2>Список профилей:</h2>
	<?$APPLICATION->IncludeComponent(
		"it_shop:b_sale.personal.profile",
		"i_sale.personal.profile",
		array(
			"COMPONENT_TEMPLATE" => "i_sale.personal.profile",
			"PER_PAGE" => "20",
			"SEF_MODE" => "N",
			"SET_TITLE" => "Y",
			"USE_AJAX_LOCATIONS" => "N",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		),
		false
	);?>
</div>
<div class="i_personal_subscribe_block">
	<h2>Подписка на рассылку:</h2>
	<?$APPLICATION->IncludeComponent(
		"it_shop:b_subscribe.edit",
		"i_subscribe.edit",
		array(
			"SHOW_HIDDEN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"ALLOW_ANONYMOUS" => "Y",
			"SHOW_AUTH_LINKS" => "Y",
			"SET_TITLE" => "N",
			"AJAX_OPTION_ADDITIONAL" => ""
		),
		false
	);?>
</div>

<?$APPLICATION->SetTitle("Настройки");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
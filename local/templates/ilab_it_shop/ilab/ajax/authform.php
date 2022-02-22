<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$GLOBALS["APPLICATION"]->IncludeComponent(
	"bitrix:system.auth.form",
	"basket_form",
	Array(
		"REGISTER_URL" => "/auth.php",
		"FORGOT_PASSWORD_URL" => "/auth/",
		"PROFILE_URL" => "/personal/profiles/",
		"SHOW_ERRORS" => "Y",
		"STORE_PASSWORD" => "N"
	),
	false
);
?>

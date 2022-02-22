<?$APPLICATION->IncludeComponent(
	"it_shop:b_system.auth.form", 
	"i_auth_form", 
	array(
		"REGISTER_URL" => "/auth.php?register=yes",
		"FORGOT_PASSWORD_URL" => "/auth.php?forgot_password=yes",
		"PROFILE_URL" => "/personal/private/",
		"SHOW_ERRORS" => "Y"
	),
	false
);?>
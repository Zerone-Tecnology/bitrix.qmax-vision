<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"ALLOW_NEW_PROFILE" => Array(
		"NAME"=>GetMessage("T_ALLOW_NEW_PROFILE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT"=>"Y",
		"PARENT" => "BASE",
	),
	"SHOW_PAYMENT_SERVICES_NAMES" => Array(
		"NAME" => GetMessage("T_PAYMENT_SERVICES_NAMES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" =>"Y",
		"PARENT" => "BASE",
	),
	"SHOW_STORES_IMAGES" => Array(
		"NAME" => GetMessage("T_SHOW_STORES_IMAGES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" =>"N",
		"PARENT" => "BASE",
	),
	'CITY_ID_PROP' => Array(
		'NAME' => GetMessage('CITY_ID_PROP'),
		'TYPE' => 'TEXT',
		'DEFAULT' => '',
	),
	'I_PP_CHECK'	=> array(
		'PARENT'			=> 'ILAB_SHOP',
		'NAME'				=> GetMessage('I_PP_CHECK'),
		'TYPE'				=> 'CHECKBOX',
	),
	'I_PP_CHECK_TEXT'	=> array(
		'PARENT'			=> 'ILAB_SHOP',
		'NAME'				=> GetMessage('I_PP_CHECK_TEXT'),
		'TYPE'				=> 'STRING',
		'DEFAULT'			=> ''
	)
);
?>
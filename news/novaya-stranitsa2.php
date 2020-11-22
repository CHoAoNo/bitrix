<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница2");
?><?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"REGISTER_URL" => "/user/registration.php",
		"FORGOT_PASSWORD_URL" => "/user/",
		"PROFILE_URL" => "/user/profile.php",
		"SHOW_ERRORS" => "N"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
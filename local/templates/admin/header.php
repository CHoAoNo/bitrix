<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID;?>-<?=strtoupper(LANGUAGE_ID);?>">
<head>
<?$APPLICATION->ShowHead();?>
<title><?$APPLICATION->ShowTitle()?></title>
<?$APPLICATION->SetAdditionalCSS("/local/templates/admin/template_style.css");?>

<?$APPLICATION->AddHeadScript("/local/templates/.default/js/jquery-1.8.2.min.js");?>
<?$APPLICATION->AddHeadScript("/local/templates/.default/js/functions.js" );?>


</head>
<body>
<?$APPLICATION->ShowPanel();?>
	
			
<!--- // end header area --->
		

<?$APPLICATION->IncludeComponent(
"bitrix:system.auth.form", 
"auth", 
array(
"COMPONENT_TEMPLATE" => "auth",
"FORGOT_PASSWORD_URL" => "/user/",
"PROFILE_URL" => "/user/profile.php",
"REGISTER_URL" => "/user/registration.php",
"SHOW_ERRORS" => "Y"
),
false
);?>
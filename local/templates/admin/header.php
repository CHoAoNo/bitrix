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

<?$APPLICATION->AddHeadScript("/local/templates/.default/js/list.min.js" );?>


</head>
<body>
<?$APPLICATION->ShowPanel();?>

<div class="menu">
<?$APPLICATION->IncludeComponent("bitrix:menu", "ad.menu", Array(
	"COMPONENT_TEMPLATE" => "horizontal_multilevel",
		"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);?>
</div>
	
			
<!--- // end header area --->
		

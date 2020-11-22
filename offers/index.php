<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Акции");
?>Text here....<?$APPLICATION->IncludeComponent("bitrix:menu", ".default", array(
	"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => "",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
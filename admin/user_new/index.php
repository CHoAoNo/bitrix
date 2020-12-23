<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новые пользователи");
?><? $APPLICATION->IncludeComponent(
"my.components:new_users.list",
".default",
Array(
"CACHE_TIME" => "1200"
),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$filter = Array("GROUPS_ID"=> Array(1,2,3,4,5,6));
$rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter);

while($arItem = $rsUsers->GetNext())
{
	$arResult['USERS'][] = $arItem;
}

$this->IncludeComponentTemplate();
?>
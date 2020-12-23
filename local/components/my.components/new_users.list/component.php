<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$filter = Array("GROUPS_ID"=> Array(1,2,3,4,5,6));
$arParams["NAV_PARAMS"] = array('nTopCount' => 3);
$rsUsers = CUser::GetList(($by="date_register"), ($order="desc"), $filter, $arParams);

if ($this->StartResultCache())
{
	while($arItem = $rsUsers->GetNext())
	{
		$arResult['USERS'][] = $arItem;
	}
	$this->IncludeComponentTemplate();
}
?>
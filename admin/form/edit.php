<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<div class="popup-form-edit">
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.edit", 
	"ad.form.result.edit", 
	array(
		"COMPONENT_TEMPLATE" => "ad.form.result.edit",
		"WEB_FORM_ID" => "1",
		"RESULT_ID" => $_REQUEST['RESULT_ID'],
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"SEF_MODE" => "N",
		"EDIT_ADDITIONAL" => "Y",
		"EDIT_STATUS" => "Y",
		"LIST_URL" => "index.php",
		"VIEW_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => ""
		
	),
	false
);?>
</div>
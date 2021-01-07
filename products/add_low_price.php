<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
global $USER;
$USER_ID = 0;

if ($USER->IsAuthorized()){
	$USER_ID = $USER->GetID();
}

//Подготовка:
if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
}

	
//Добавление:
if (CModule::IncludeModule('highloadblock')) {
	$arElementFields = array(
		'UF_USER_ID' => $USER_ID,
		'UF_USER_NAME' => $_POST['name'],
		'UF_USER_PHONE' => preg_replace("/[^0-9]/", '', $_POST['phone']),
		'UF_PRODUCT_NAME' => $_POST['productName'],
		'UF_PRODUCT_ID' => $_POST['productID'],
		'UF_PRODUCT_CODE' => $_POST['productCode'],
		'UF_PRODUCT_PAGE' => $_POST['productRef'],
		'UF_REQUEST_PRICE' => $_POST['price'],
		'UF_REQUEST_DATE' => new \Bitrix\Main\Type\DateTime
	);
	
	$obResult = $strEntityDataClass::add($arElementFields);
	$ID = $obResult->getID();

	if ($obResult->isSuccess())
		echo "Мы вам сообщим свое решение";
}
?>
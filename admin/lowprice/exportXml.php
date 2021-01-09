<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?php

// id Highload-блока
const MY_HL_BLOCK_ID = 2;
// id ифноблока с товарами
const	PRODUCT_IBLOCK_ID = 8;

// массив необходимых товаров, будет содержать PREVIEW_PICTURE и PROPERTY_PRICE_VALUE по id товара
$arProducts = array();
if( !empty($_POST['listProducts']) && CModule::IncludeModule('iblock') ){
	
	// id товаров
	$ids = $_POST['listProducts'];

	$rs = CIBlockElement::GetList(
		Array(),
		['IBLOCK_ID' => PRODUCT_IBLOCK_ID, 'ID' => $ids],
		false, false,
		['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_PRICE']
	);
	
	while ($ar = $rs->Fetch()) {
		$id = $ar["ID"];
		$arProducts[$id] = array('picture' => $ar['PREVIEW_PICTURE'], 'price' => $ar['PROPERTY_PRICE_VALUE']);
	}
	
}	
	
// массив необходимых пользователей, будет содержать LOGIN, NAME и LAST_NAME по id пользователя
$arUsers = array();
if( !empty($_POST['listUsers']) ){
	
	$arParams["FIELDS"] = array("ID", "LOGIN", "NAME", "LAST_NAME");
	$rsUsers = CUser::GetList(($by="id"), ($order="desc"), array('ID' => implode('|', $_POST['listUsers'])), $arParams);

	while($arItem = $rsUsers->GetNext())
	{
		$id = $arItem["ID"];
		$arUsers[$id] = array('login' => $arItem["LOGIN"], 'name' => $arItem["NAME"], 'last_name' => $arItem["LAST_NAME"]);
	}
}	


// фильтр для HL по id заявок
$arFilter = array();
if( !empty($_POST['listRequests']) ){
	$arFilter = array("LOGIC" => "OR");
	foreach($_POST['listRequests'] as $id){
		$arFilter[] = array("ID" => $id);
	}
}
// данные не были отфильтрованы, экспорт всех заявок
else
	$arFilter = array();
	

if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(MY_HL_BLOCK_ID)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
	
	$rsData = $strEntityDataClass::getList(array(
		'select' => array('*'),
		'filter' => $arFilter
	));
	



	// инициализация XML файла
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Заявки xmlns:xlink="http://www.w3.org/1999/xlink">
</Заявки>
XML;
	$sxe = new SimpleXMLElement($xmlstr);
	
	// перебор полученных для экспорта заявок
	while ($request = $rsData->Fetch()){
		
		$user_id = $request['UF_USER_ID'];
		$product_id = $request['UF_PRODUCT_ID'];
		
		
		// далее заполение XML
		
		$parent = $sxe->addChild('Заявка');
		$parent->addAttribute('ID', $request['ID']);
		$parent->addAttribute('Дата', $request['UF_REQUEST_DATE']);
		$parent->addAttribute('Статус', $request['UF_STATUS'] ? 'Обработана': 'Не обработана');
		

		$user = $parent->addChild('Пользователь');
		$user1 = $user->addChild('Заявитель');
		$user1->addChild('ФИО', $request['UF_USER_NAME']);
		$user1->addChild('Телефон', $request['UF_USER_PHONE']);
		
		// если пользователь был авторизован, добавить необходмимую информацию
		if($user_id){
			$user2 = $user->addChild('Авторизованный');
			$user2->addAttribute('ID', $user_id);
			$user2->addAttribute('xlink:href', '/admin/users/' . $arUsers[$user_id]['login'], 'http://www.w3.org/1999/xlink');
			$user2->addChild('ФИО', $arUsers[$user_id]['last_name']. " " .$arUsers[$user_id]['name']);
		}
		
		
		$product = $parent->addChild('Товар');
		$product->addAttribute('Код', $request['UF_PRODUCT_CODE']);
		$product->addAttribute('xlink:href', $request['UF_PRODUCT_PAGE'], 'http://www.w3.org/1999/xlink');
		
		// если есть фото товара, добавить фото
		if($arProducts[$product_id]['picture']){
			$foto = $product->addChild('Фото');
			$foto->addAttribute('xlink:href', CFile::GetPath( $arProducts[$product_id]['picture'] ), 'http://www.w3.org/1999/xlink');
		}
		

		$price1 = $product->addChild('Цена', $request['UF_REQUEST_PRICE']);
		$price1->addAttribute('Тип', 'Желаемая');
		
		$price2 = $product->addChild('Цена', $arProducts[$product_id]['price']);
		$price2->addAttribute('Тип', 'Актуальная');
		
		
		// если заявка была обработана, добавить комментарий
		if($request['UF_STATUS']){
			$parent->addChild('Комментарий', $request['UF_COMMENT']);
		}
		
	}

	echo $sxe->asXML();
}


?>
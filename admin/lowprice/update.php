<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
// id Highload-блока
const MY_HL_BLOCK_ID = 2;

if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(MY_HL_BLOCK_ID)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
	
	// id заявки для обновления
	$idForUpdate = $_POST['requestId'];
	
	// обновить комментарий и статус
	$result = $strEntityDataClass::update($idForUpdate, array(
		'UF_COMMENT'	=> $_POST['comment'],
		'UF_STATUS'		=> 1
	));
	
	
	if ($result->isSuccess()){
		// если есть почта (заявка была от авторизованного пользоавтеля), то отправить письмо
		if( !empty($_POST['mail']) ){
			// информация по заявке
			$rsData = $strEntityDataClass::getList(array(
				'select' => array('UF_PRODUCT_CODE', 'UF_REQUEST_DATE', 'UF_COMMENT'),
				'filter' => array("ID" => $_POST['requestId'])
			));
			$arItem = $rsData->Fetch();
			
			// время ответа
			$time = date("Y-m-d H:i:s");
			
			// текст письма
			$text = "Артикул товара: " . $arItem['UF_PRODUCT_CODE'] . "\n";
			$text .= "Дата заявки: " . $arItem['UF_REQUEST_DATE'] . "\n";
			$text .= "Полученный комментарий: " . $arItem['UF_COMMENT'] . "\n";
			$text .= "Время ответа: " . $time . "\n";
			
			mail($_POST['mail'], "Заявка {$_POST['requestId']}", $text);
		}

		echo "Заявка обработана";
	}

}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<div class="overlay2"></div>
<div class="detail-request-price">
<?
	// id ифноблока с товарами
	$PRODUCT_IBLOCK_ID = 8;
	// id заявки
	$REQUEST_ID = $_POST["ID"];
	

//Подготовка HL:
if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
}

//Получение записи HL (заявки):
if (CModule::IncludeModule('highloadblock')) {
  $rsData = $strEntityDataClass::getList(array(
		'select' => array('*'),
		'filter' => array("ID" => $REQUEST_ID)
  ));
  
	if($arItem = $rsData->Fetch()) {
		// если заявка была от аториз. пользователя, то получить этого пользователя
		if($arItem['UF_USER_ID']!=0){
			$rsUser = CUser::GetByID($arItem['UF_USER_ID']);
			$arUser = $rsUser->Fetch();
		}
		
		// получение товара из инфоблока, для вывода изображения
		if(CModule::IncludeModule("iblock")) {
			$res = CIBlockElement::GetByID($arItem['UF_PRODUCT_ID']);
			$product = $res->GetNext();
		}

		// получение цены товара
		$db_props = CIBlockElement::GetProperty($PRODUCT_IBLOCK_ID, $arItem['UF_PRODUCT_ID'], array("sort" => "asc"), Array("CODE"=>"PRICE"));
		if($ar_props = $db_props->Fetch())
			$price = $ar_props["VALUE"];
		else
			$price = '';
			

?>
		<table class="form-table low-price">
			<tr><td>ID заявки:</td><td><?=$arItem['ID']?></td></tr>
			<tr><td>Дата заявки:</td><td><?=$arItem['UF_REQUEST_DATE']?></td></tr>
			<tr><td>ФИО создавшего:</td><td><?=$arItem['UF_USER_NAME']?></td></tr>
			<tr><td>Телефон:</td><td><?=$arItem['UF_USER_PHONE']?></td></tr>
			<tr><td>ФИО авториз. пользователя:</td><td><?= $arUser['LAST_NAME'] . " " . $arUser['NAME']?></td></tr>
			<tr><td>Страница пользователя:</td><td><?if($arItem['UF_USER_ID']!=0):?><a target="_blank" href="/admin/users/<?=$arUser['LOGIN']?>">анкета</a><?endif;?></td></tr>
			<tr><td>Артикул товара:</td><td><?=$arItem['UF_PRODUCT_CODE']?></td></tr>
			<tr><td>Название товара:</td><td><?=$arItem['UF_PRODUCT_NAME']?></td></tr>
			<tr><td>Страница товара:</td><td><a target="_blank" href="<?=$arItem['UF_PRODUCT_PAGE']?>">товар</a></td></tr>
			<tr><td>Фото товара:</td><td><?if($product["PREVIEW_PICTURE"]):?><img height="100" src="<?=CFile::GetPath($product["PREVIEW_PICTURE"])?>">
			<?endif;?></td></tr>
			<tr><td>Желаемая цена:</td><td><?=$arItem['UF_REQUEST_PRICE']?></td></tr>
			<tr><td>Актуальная цена:</td><td><?=$price?></td></tr>
			<?if($arItem['UF_STATUS']):?>
			<tr><td>Комментарий:</td><td> <?=$arItem['UF_COMMENT']?></td></tr>
			<?endif;?>
		</table>
		
		<?// если заявка не обработана, то вывести форму для обработки?>
		<?if(!$arItem['UF_STATUS']):?>
			<br>
			<form name="my" id="form" action="" method="POST">
				<p>Комментарий</p>
				<textarea name="comment" required="required" cols='50'></textarea>
				<input name="requestId" type="hidden" value="<?=$arItem['ID']?>">
				<input name="mail" type="hidden" value="<?=$arUser['EMAIL']?>">
				<input class="def-button" name="submit" type="submit"  value="Обработать">
			</form>
		<?endif;?>
<?
	}
}
?>
</div>
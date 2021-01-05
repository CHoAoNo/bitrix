<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Хочу дешевле");
?>

<?
//Получение id пользователя и телефонов
global $USER;
$rsUser = CUser::GetByID($USER->GetID()); 
$arUser = $rsUser->Fetch();
// телефон
$personalPhone = preg_replace("/[^0-9]/", '', $arUser["PERSONAL_PHONE"]);
// мобильный телефон
$personalMobile = preg_replace("/[^0-9]/", '', $arUser["PERSONAL_MOBILE"]);


// далее идет создание вариантов номеров телефонов начинающихся на 7(8)
// для обработки ситуации, когда в анкете и в заявке указан один и тот же номер телефона, 
// но начинающийся на разные первые цифры
$firstNumber = mb_substr($personalPhone, 0, 1);
if($firstNumber == 7)
	$personalPhone2 = '8' . mb_substr($personalPhone, 1);
if($firstNumber == 8)
	$personalPhone2 = '7' . mb_substr($personalPhone, 1);


$firstNumber = mb_substr($personalMobile, 0, 1);
if($firstNumber == 7)
	$personalMobile2 = '8' . mb_substr($personalMobile, 1);
if($firstNumber == 8)
	$personalMobile2 = '7' . mb_substr($personalMobile, 1);

// фильтр для получения записей из Highload-блока
$arFilter = array(
"LOGIC" => "OR",
	array("UF_USER_ID" => $arUser["ID"]),
	array("UF_USER_PHONE" => $personalPhone),
	array("UF_USER_PHONE" => $personalPhone2),
	array("UF_USER_PHONE" => $personalMobile),
	array("UF_USER_PHONE" => $personalMobile2)
);


//Подготовка Highload-блока
if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
}
?>
<table class="low-price">
	<thead>
		<tr>
			<th>Артикул товара</th>
			<th>Название товара</th>
			<th>Страница товара</th>
			<th>Дата заявки</th>
			<th>Состояние заявки</th>
			<th>Комментарий</th>
		</tr>
	</thead>
	<tbody>
<?
//Получение списка:
if (CModule::IncludeModule('highloadblock')) {
  $rsData = $strEntityDataClass::getList(array(
		'select' => array('UF_PRODUCT_CODE','UF_PRODUCT_NAME','UF_PRODUCT_PAGE','UF_REQUEST_DATE','UF_STATUS','UF_COMMENT'),
		'order' => array('ID' => 'ASC'),
		'filter' => $arFilter
  ));
  
	while ($arItem = $rsData->Fetch()) {
?>
		<tr>
			<td><?=$arItem['UF_PRODUCT_CODE']?></td>
			<td><?=$arItem['UF_PRODUCT_NAME']?></td>
			<td><a href="<?=$arItem["UF_PRODUCT_PAGE"]?>">товар</a></td>
			<td><?=$arItem['UF_REQUEST_DATE']?></td>
			<td><?=$arItem['UF_STATUS']? "обработано" : "не обработано"?></td>
			<td><?=$arItem['UF_COMMENT']?></td>
		</tr>
<? 
	}
}
?>
	</tbody>
</table>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
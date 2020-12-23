<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
// изображения
$result = array();

// ошибки
$strError = '';

// Перебор файлов из формы
foreach($_FILES as $i => $file) {
	// Создаем массив для функции SaveFile
	$arrFile = array(
			'name' => $file["name"],
			'size' => $file["size"],
			'tmp_name' => $file["tmp_name"],
			'type' => $file["type"],
			'old_file' => '',
			'del' => '',
			'MODULE_ID' => 'iblock'
	);

	// проверка, файл должен быть изображением
	$error = CFile::CheckImageFile($arrFile);
	if (strlen($error)>0){
		$strError .= $error.": {$file["name"]}<br>";
		continue;
	} 
	
	// Перемещаем файл из временной папки в upload и получаем id
	$id = CFile::SaveFile($arrFile, 'iblock');   
	$result[$id] = $file["name"];
}
?>

<?// изображения ?>
<?if(!empty($result)):?>
<div class="result">
<?
foreach($result as $id => $name){
	echo "<a class='image' href='download.php?id=$id'>Изображение $name</a><br>";
}
?>
</div>
<?endif;?>

<?// ошибки ?>
<?if(strlen($strError)>0):?>
<div class="form-error">
<?=$strError;?>
</div>
<?endif;?>
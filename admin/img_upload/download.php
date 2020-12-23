<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
global $USER;
// проверка на авторизованность
if ($USER->IsAuthorized()){
	// при доступе через ajax 
	if(!empty($_POST)) {
		echo CFile::GetPath($_GET["id"]);
	}
	// при прямом доступе через ссылку вида .../img_upload/download.php?id=71
	else {
		$href = CFile::GetPath($_GET["id"]);?>
		<script>
		var link = document.createElement('a');
		link.setAttribute('href', "<?=$href?>");
		link.setAttribute('download', '');
		link.click();
		</script>
	<?
	}	
}
// перенаправление на страницу 404
else {
	require(\Bitrix\Main\Application::getDocumentRoot() . "/404.php");
	die();
}
?>

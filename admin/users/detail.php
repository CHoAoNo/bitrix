<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Анкета");
?>


<?
	$login = explode('/', $_SERVER['REQUEST_URI'])[3];
	
	$rsUser = CUser::GetByLogin($login);
	$arUser = $rsUser->Fetch();
	//var_dump($arUser);
?>
	<div class="profile">
		<ul>
			<li>ID: <span><?=$arUser['ID']?></span></li>
			<li>Login: <span><?=$arUser['LOGIN']?></span></li>
			<li>Фамилия: <span><?=$arUser['LAST_NAME']?></span></li>
			<li>Имя: <span><?=$arUser['NAME']?></span></li>
			<li>Отчество: <span><?=$arUser['SECOND_NAME']?></span></li>
			<li>Наименование компании: <span><?=$arUser['WORK_COMPANY']?></span></li>
			<li>Отдел: <span><?=$arUser['WORK_DEPARTMENT']?></span></li>
			<li>Должность: <span><?=$arUser['WORK_POSITION']?></span></li>
			<li>Телефон: <span><?=$arUser['WORK_PHONE']?></span></li>
			<li>Почта: <span><?=$arUser['EMAIL']?></span></li>
			<li>Последняя авторизация: <span><?=$arUser['LAST_LOGIN']?></span></li>
			<li>Дата регистрации: <span><?=$arUser['DATE_REGISTER']?></span></li>
		</ul>
	</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
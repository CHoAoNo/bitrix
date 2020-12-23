<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="users">
	<table class="allusers">
		<thead><th>ID</th><th>Логин</th><th>Имя Фамилия</th><th>Почта</th><th>Дата регистрации</th></thead>
		<tbody class="list">
		<?foreach($arResult[USERS] as $arItem){
		printf("<tr><td class='user_id'>%s</td><td class='user_login'><a href='/admin/users/%s/'>%s</a></td><td class='user_name'>%s</td><td class='user_email'>%s</td><td class='user_date'>%s</td></tr>",
				$arItem['ID'], $arItem['LOGIN'], $arItem['LOGIN'], $arItem['NAME']." ".$arItem['LAST_NAME'], $arItem['EMAIL'], $arItem['DATE_REGISTER']);
		}?>
		</tbody>
	</table> 
</div>
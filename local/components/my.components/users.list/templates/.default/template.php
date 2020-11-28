<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="users">
	<input class="search" placeholder="Поиск">
	<div class="filter-wrap">
	<p>Фильтр по дате авторизации<br/>
	Обязательно указывать обе даты</p>
	<label for="from-date">С даты</label>
	<input id="from-date" type="date">
	<label for="to-date">По дату</label>
	<input id="to-date" type="date">
	
	<button class="filter-date">Фильтровать</button>
	</div>
	<table class="allusers">
		<thead><th>ID</th><th>Логин</th><th>Имя Фамилия</th><th>Почта</th><th>Дата последней авторизации</th></thead>
		<tbody class="list">
		<?foreach($arResult[USERS] as $arItem){
		printf("<tr><td class='user_id'>%s</td><td class='user_login'><a href='/admin/users/%s/'>%s</a></td><td class='user_name'>%s</td><td class='user_email'>%s</td><td class='user_date'>%s</td></tr>",
				$arItem['ID'], $arItem['LOGIN'], $arItem['LOGIN'], $arItem['NAME']." ".$arItem['LAST_NAME'], $arItem['EMAIL'], $arItem['LAST_LOGIN']);
		}?>
		</tbody>
	</table> 
</div>


<script>
var options = {
	valueNames: [ 'user_id', 'user_login', 'user_name', 'user_email', 'user_date']
};
var userList = new List('users', options);


$('.filter-date').on('click',function(){
	let fromDate = new Date(document.getElementById('from-date').value);
	let toDate = new Date(document.getElementById('to-date').value);

  if($(this).hasClass( 'selected' )){
    userList.filter();
    $(this).removeClass('selected');
		$(this).text('Фильтровать');
  } 
	else {
    userList.filter(function(item) {
			year = item.values().user_date.substring(6, 10);
			month = item.values().user_date.substring(3, 5);
			day = item.values().user_date.substring(0, 2);
			userDate = new Date(`${year}-${month}-${day}`);

			return (userDate>=fromDate && userDate<=toDate);
			});
    $(this).addClass('selected');
		$(this).text('Сбросить фильтр');
  }
});
</script>
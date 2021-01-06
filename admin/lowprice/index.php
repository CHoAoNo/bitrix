<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Снижение цены");
?>


<?//Подготовка Highload-блока
if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
}
?>
<div class="wrap-center-2" id="requests-list">
	<h1 class="title">Заявки на снижение цены</h1>
	
	<div class="filters-wrap">
	
		<input class="search" placeholder="Поиск" />
	
		<div class="filter-wrap filter-status">
			<p>Фильтр по статусу</p>
			<select id="status">
				<option class="filter-status-reset">Все</option>
				<option class="filter-status-1">Обработано</option>
				<option class="filter-status-0">Не обработано</option>
			</select>
		</div>
	
		<div class="filter-wrap">
			<p>Фильтр по дате</p>
			<label for="from-date">С даты</label>
			<input id="from-date" type="date">
			<label for="to-date">По дату</label>
			<input id="to-date" type="date">
		</div>
	
	</div>
	

	<table class="form-table low-price">
		<thead>
			<tr>
				<th class="sort" data-sort="request_date">&#9661;&#9651; Дата заявки</th>
				<th class="sort" data-sort="product_code">&#9661;&#9651; Артикул товара</th>
				<th class="sort" data-sort="product_name">&#9661;&#9651; Название товара</th>
				<th class="sort" data-sort="status">&#9661;&#9651; Состояние заявки</th>
			</tr>
		</thead>
		<tbody class="list">
<?
//Получение списка:
if (CModule::IncludeModule('highloadblock')) {
  $rsData = $strEntityDataClass::getList(array(
		'select' => array('UF_REQUEST_DATE','UF_PRODUCT_CODE','UF_PRODUCT_NAME','UF_STATUS'),
		'order' => array('ID' => 'ASC')
  ));
  
	while ($arItem = $rsData->Fetch()) {
?>
			<tr>
				<td class='request_date'><?=$arItem['UF_REQUEST_DATE']?></td>
				<td class='product_code'><?=$arItem['UF_PRODUCT_CODE']?></td>
				<td class='product_name'><?=$arItem['UF_PRODUCT_NAME']?></td>
				<td class='status'><?=$arItem['UF_STATUS']? "обработано" : "не обработано"?></td>
			</tr>
<? 
	}
}
?>
		</tbody>
	</table>
	<ul class="pagination"></ul>
</div>

<script>
// скрипт для фильтрации, сортировки (при клике на заголовки таблицы) 
// и постраничной навигации с помощью плагина List.js

// параметры 
var options = {
	valueNames: [ 'request_date', 'product_code', 'product_name', 'status'],
	page: 20,
  pagination: true
};
var requestsList = new List('requests-list', options);

// обертка над функцией фильтрации (по дате и статусу)
function filterDateStatus(){
	// сбросить старый фильтр
	requestsList.filter();
	
	//получени дат
	let fromDate = new Date(document.getElementById('from-date').value);
	let toDate = new Date(document.getElementById('to-date').value);
	
	// если переменная "С даты" не была установлена, то установить дату на временную метку Unix
	if(fromDate == 'Invalid Date')
		fromDate = new Date('1970-01-01T00:00:00');
		
	// если переменная "По дату" не была установлена, то указать на текущую дату
	if(toDate == 'Invalid Date')
		toDate = Date.now();
	
	// функция фильтрации
  requestsList.filter(function(item) {	
		// выбраный статус
		var n = document.getElementById("status").options.selectedIndex;
		
		// дата перебираемого элемента
		year = item.values().request_date.substring(6, 10);
		month = item.values().request_date.substring(3, 5);
		day = item.values().request_date.substring(0, 2);
		requestDate = new Date(`${year}-${month}-${day}`);
		
		// фильтр только по дате
		if(n == 0)
			return (requestDate>=fromDate && requestDate<=toDate);
		
		// фильтр по дате со статусом 'обработано'
		if(n == 1)
			return (requestDate>=fromDate && requestDate<=toDate && item.values().status == 'обработано');
		
		// фильтр по дате со статусом 'не обработано'
		if(n == 2)
			return (requestDate>=fromDate && requestDate<=toDate && item.values().status == 'не обработано');
	});
   
}


// запуск фильтрации при изменении поля 'С даты'
$('#from-date').on('change', function(){
		filterDateStatus();	
});
// запуск фильтрации при изменении поля 'По дату'
$('#to-date').on('change', function(){
		filterDateStatus();	
});

// запуск фильтрации при выборе статуса для фильтрации
$('.filter-status-reset').on('click',function(){
	filterDateStatus();
});
	
$('.filter-status-1').on('click',function(){
	filterDateStatus();
});
	
$('.filter-status-0').on('click',function(){
	filterDateStatus();
});

</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
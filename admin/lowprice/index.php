<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->AddHeadScript("/local/templates/admin/js/jquery.fancybox.pack.js");
$APPLICATION->SetAdditionalCSS("/local/templates/admin/include/fancybox/jquery.fancybox.css");
$APPLICATION->SetTitle("Снижение цены");
?>

<?
// id Highload-блока
const MY_HL_BLOCK_ID = 2;

if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(MY_HL_BLOCK_ID)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
}
?>
<div class="overlay"></div>
<div class="wrap-center-2" id="filtered-list">

	<h1 class="title">Заявки на снижение цены</h1>
	
	<div class="filters-wrap">

		<input class="search" placeholder="Поиск" />
		<button class="def-button export">Экспорт XML</button>
	
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
				<th class="sort" data-sort="id">&#9661;&#9651; ID</th>
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
		'select' => array('ID','UF_REQUEST_DATE','UF_PRODUCT_CODE','UF_PRODUCT_NAME','UF_STATUS','UF_USER_ID','UF_PRODUCT_ID'),
		'order' => array('ID' => 'ASC')
  ));
  
	while ($arItem = $rsData->Fetch()) {
?>
			<tr class="ajax-detail" data-id="<?=$arItem['ID']?>">
				<td class='id'><?=$arItem['ID']?></td>
				<td class='user_id hiden'><?=$arItem['UF_USER_ID']?></td>
				<td class='product_id hiden'><?=$arItem['UF_PRODUCT_ID']?></td>
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
// просмотр детальной информации по заявке
$('.ajax-detail').on('click', function(){
	showDetail($(this));
});

function showDetail(self){
	requestID = self.attr('data-id');
	
	$.ajax({
		beforeSend: function() {
			$('.overlay').fadeIn();
		},
		complete: function() {
			$('.overlay').fadeOut();
		},
		url: 'detail.php',
		type: 'POST',
		data: {'ID': requestID
		},
		success: function(data){
			$.fancybox({content:data,helpers:{overlay:{locked: false}}});
			$.fancybox.hideLoading();
		}
	});
};
</script>

<script>
// скрипт для фильтрации, сортировки (при клике на заголовки таблицы) 
// и постраничной навигации с помощью плагина List.js
// и экспорта в XML отфильтрованных данных

// для экспорта в XML формируется 3 списка id: заявок, пользователей, товаров;
// чтобы выбрать необходимые данные тремя запросами

// параметры List.js
var options = {
	valueNames: [ 'id', 'user_id', 'product_id', 'request_date', 'product_code', 'product_name', 'status'],
	page: 20,
  pagination: true
};
var filteredList = new List('filtered-list', options);

// список id заявок
var listRequests = new Array();

// список id пользователей по умолчанию (все имеющиеся в списке)
var listUsersDefault = new Set();
users = document.querySelectorAll('.user_id');
users.forEach(function(userItem) {
  listUsersDefault.add(userItem.textContent);
});

// список id товаров (все имеющиеся в списке)
var listProductsDefault = new Set();
products = document.querySelectorAll('.product_id');
products.forEach(function(productItem) {
  listProductsDefault.add(productItem.textContent);
});

// список id пользователей для заполнения при фильтрации
var listUsers = new Set();
// список id товаров для заполнения при фильтрации
var listProducts = new Set();

// обертка над функцией фильтрации (по дате и статусу)
function filterDateStatus(){
	// сбросить списки id
	listRequests.length = 0;
	listUsers.clear();
	listProducts.clear();
	// сбросить старый фильтр
	filteredList.filter();
	
	// выбраный статус заявки
	var n = document.getElementById("status").options.selectedIndex;
	
	//получение дат
	let fromDate = new Date(document.getElementById('from-date').value);
	let toDate = new Date(document.getElementById('to-date').value);
	
	// если переменная "С даты" не была установлена, то установить дату на временную метку Unix
	if(fromDate == 'Invalid Date')
		fromDate = new Date('1970-01-01T00:00:00');
		
	// если переменная "По дату" не была установлена, то указать на текущую дату
	if(toDate == 'Invalid Date')
		toDate = Date.now();
	
	// фильтры не установлены
	if(fromDate == 'Invalid Date' && toDate == 'Invalid Date' && n == 0)
		return;
	
		
	
	// функция фильтрации
  filteredList.filter(function(item) {	
		
		// дата перебираемого элемента
		year = item.values().request_date.substring(6, 10);
		month = item.values().request_date.substring(3, 5);
		day = item.values().request_date.substring(0, 2);
		requestDate = new Date(`${year}-${month}-${day}`);
		
		// фильтр только по дате
		if(n == 0 && requestDate>=fromDate && requestDate<=toDate){
			// заполнение списков id
			listRequests.push(item.values().id);
			listUsers.add(item.values().user_id);
			listProducts.add(item.values().product_id);
			return true;
		}
			
		
		// фильтр по дате со статусом 'обработано'
		if(n == 1 && requestDate>=fromDate && requestDate<=toDate && item.values().status == 'обработано'){
			// заполнение списков id
			listRequests.push(item.values().id);
			listUsers.add(item.values().user_id);
			listProducts.add(item.values().product_id);
			return true;
		}
		
		// фильтр по дате со статусом 'не обработано'
		if(n == 2 && requestDate>=fromDate && requestDate<=toDate && item.values().status == 'не обработано'){
			// заполнение списков id
			listRequests.push(item.values().id);
			listUsers.add(item.values().user_id);
			listProducts.add(item.values().product_id);
			return true;
		}

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

// запуск фильтрации при выборе статуса заявки для фильтрации
$('.filter-status-reset').on('click',function(){
	filterDateStatus();
});
	
$('.filter-status-1').on('click',function(){
	filterDateStatus();
});
	
$('.filter-status-0').on('click',function(){
	filterDateStatus();
});


// экспорт в XML
$('.export').on('click', function(){
	
	// если происходит экспорт в XML неотфильтрованных заявок, 
	// то использовать списки id по умолчанию
	if(listRequests.length == 0){
		listUsers = listUsersDefault;
		listProducts = listProductsDefault;
	}
		
	$.ajax({
		beforeSend: function() {
			$('.overlay').fadeIn();
		},
		complete: function() {
			$('.overlay').fadeOut();
		},
		url: 'exportXml.php',
		type: 'POST',
		data: {	
			listRequests: listRequests, 
			listUsers: Array.from(listUsers),
			listProducts: Array.from(listProducts)
		},
		success: function(data){
			var hiddenElement = document.createElement('a');
			hiddenElement.href = 'data:text/xml,' + data;
			hiddenElement.target = '_blank';
			hiddenElement.download = 'export.xml';
			hiddenElement.click();
		}
	});
	
});
</script>

<script>
// обработка заявки
$(function(){
	$('body').on('submit','form',function(e){
		e.preventDefault();
		
		let form = document.forms.my; 
		// id заявки
		let requestID = form.elements.requestId.value; 
		
		let data = $(this).serialize();
		
		$.ajax({
			beforeSend: function() {
				$('.overlay2').fadeIn();
			},
			complete: function() {
				$('.overlay2').fadeOut();
			},
			url: 'update.php',
			type: 'POST',
			data: data,
			success: function(data){
				$.fancybox({content:data,helpers:{overlay:{locked: false}}});
				$.fancybox.hideLoading();
				// изменить текст на обработано
				document.querySelector("tr[data-id='" + requestID + "'] td.status").textContent = 'обработано';
			}
		});
	});
});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
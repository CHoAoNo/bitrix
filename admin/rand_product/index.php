<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Случайный продукт");
?>

<div class="wrap-button">
<a class="button" id="button" href="#">Показать ещё</a>
</div>

<div class="wrap-rand-prod-list">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"rand_prod", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "8",
		"IBLOCK_TYPE" => "products",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "PRICE",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "RAND",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "",
		"SORT_ORDER2" => "",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "rand_prod",
		"FILTER_ARRAY" => $arFilter
	),
	false
);?>
</div>

<script>
// скрипт для кнопки "Показать ещё"
$(function() {
	//обертка куда будут вставляться товары
	wrap = $( ".wrap-rand-prod-list" );
	
	//кнопка показать ещё
	btn = $( "#button" );

	// фильтр
	filter = '';
  
  btn.click( function(e) {
    e.preventDefault(); 

		function startAnimation() { // - функция запуска анимации
			$("body").after("<div id=\"fon\" style='position: fixed; top: 0px; left: 0px; opacity: 0.5; background: #fff; width: 100%; height: 100%; z-index: 99999999; text-align: center;'></div>");
		}

		function stopAnimation() { // - функция останавливающая анимацию
			$("#fon").remove();
		}

		// проверка на вывод уже всех товаров, тогда делать ничего не надо
		if( $(".no-more-products").length) {}
		
		// иначе отправить ajax запрос
		else{
			// формирование списка id уже выведенных товаров
			$(".list-item").each(function() {
				id = $(this).attr("data-id");
				filter += id + " ";
			});
			
			$.ajax({
				url: "get_list.php",
				type: "POST",
				data: { 
					filter: filter
				},
				beforeSend: function() {
					startAnimation();  // запуск анимации загрузки
				},
				complete: function() {
					stopAnimation();  // останавка анимации загрузки
				},
				success: function( data ) {
					wrap.prepend( data );		// записать результат в обертку
					inWindow();	// вызов функции для фиксации просмотра товаров, 
											// иначе если не будет события прокрутки, по которой срабатывает обработчик 
											// (например пользователь просмотрел товары, но не прокручивал вниз,
											// а ушел с сайта), то первым товарам не зафиксируется просмотр
				}
			});
		}
		
	});
	
});
</script>

<script>
// скрипт для фиксации просмотренных товаров (фиксирование происходит при прокрутке)
// и отправки ajax запроса на изменение счетчика просмотренных товаров

// массив просмотренных товаров
var result = new Set();

// функция определения факта показа товара
// 70% видимой области товара было в области окна браузера (только по высоте)
function inWindow(){
  var scrollTop = $(window).scrollTop();
  var windowHeight = window.innerHeight;
  var currentEls = $("div.list-item");
	
	// если все товары просмотренны, то убрать обработчик события прокрутки
	if( currentEls.length == result.size){
		window.removeEventListener('scroll', listener);
		return
	}
	
  currentEls.each(function(){	
		// если товар уже просмотрен, то его обрабатывать не надо
		if( result.has($(this).attr("data-id")) ) {
			return true;
		}
		else {
			var el = $(this);
			var elHeight = el.height();
			var offset = el.offset();
			
			// 30% высоты блока товара может быть скрыто сверху или синзу для того, чтобы засчитать его показаным
			if( scrollTop <= (offset.top + 0.3*elHeight) && (0.7*elHeight + offset.top) < (scrollTop + windowHeight) ) {
				result.add( $(this).attr("data-id") );
			}
		}
  });

}

// вызов функции для регистрации показа первых товаров ещё до скролла
inWindow();


// дроссель (ограничитель по времени) для обработчика события прокрутки
function throttle(fn, wait) {
  var time = Date.now();
  return function() {
    if ((time + wait - Date.now()) < 0) {
      fn();
      time = Date.now();
    }
  }
}
listener = throttle(inWindow, 200);

// регистрция обработчика события прокрутки
window.addEventListener('scroll', listener);

// если добавлены новые товары, то добавить и обработчик события прокрутки
document.getElementById("button").addEventListener("click", function(event){
  event.preventDefault();
	window.addEventListener('scroll', listener);
}); 


// отправка ajax при закрытии или обновлении страницы
// для изменения счетчика показов товаров
$(window).on('unload', function() {
    var fd = new FormData();
    fd.append('idArray', JSON.stringify(result));
    navigator.sendBeacon('counter.php', fd);
});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
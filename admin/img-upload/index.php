<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Загрузка изображений");
?>

<div class="wrap-center">
<br>
	<form enctype="multipart/form-data" method="post">
		 <p><input type="file" multiple="multiple" name="f">
		 <input type="submit" value="Отправить"></p>
	</form> 
</div>


<script>
$(function(){
	// Переменная где будут располагаться данные файлов
	var file;
 
	// Вешаем функцию на событие
	// Получим данные файлов и добавим их в переменную
	$('input[type=file]').change(function(){
    files = this.files;
	});

	// кнопка скачивания
	$(document).on('click', '.image', function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr("href"),
			type: 'POST',
			data: 'ajax',
			success: function(data) {		// получаем адрес, создаем ссылку, и вешаем на неё нажатие
				var link = document.createElement('a');
				link.setAttribute('href', data);
				link.setAttribute('download', '');
				link.click();
				return false;
			},
			error: function (data) {
				console.log('Error', data);
			}
		});
	});
 
  // Отправка файлов
	$('body').on('submit','form', function(e){
		e.preventDefault();
		$('.form-error').remove();	// удалить предыдущий блок с ошибками если есть
		var data = new FormData();	// файлы
    $.each( files, function( key, value ){
        data.append( key, value );
    });

		$.ajax({
			url: "upload.php",
			type: 'POST',
			dataType: 'html',
			data: data,
			cache: false,
      contentType: false,
      processData: false,
			success: function(data) {
        $('.wrap-center').prepend( $(data).filter('.form-error') );	// блок с ошибками
				$('.wrap-center').append( $(data).filter('.result') );		// блок с ссылками на изображения
			},
			error: function (data) {
        console.log('Error', data);
			}
		});
	});	

});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
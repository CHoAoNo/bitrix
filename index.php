<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мебельная компания");
?><p>
	 Разрабатываем уникальные сайты, на 100% адаптированные под особенности Вашего бизнеса и ориентированные на Вашу целевую аудиторию. Внедряем инновационное программное обеспечение собственной разработки.
</p>
<p>
	 Сделаем сайт привлекательным, удобным и надёжным. Оформим его так, чтобы он грамотно демонстрировал все преимущества товара или услуги. Продвинем его в ТОП10 результатов выдачи поисковых систем. Именно это то, что и должен делать качественный коммерческий сайт – приводить новых клиентов и приносить дополнительную прибыль.
</p>
<p>
	 Мы работаем в сфере интернет-маркетинга и современных цифровых технологий. Занимаемся разработкой, поддержкой и продвижением сайтов и прочих высоконагруженных ресурсов с 2004 года. Входим в Топ3 веб-студия региона
</p>
<h3>Наша продукция</h3>
 <?$APPLICATION->IncludeComponent(
	"bitrix:furniture.catalog.index",
	"",
	Array(
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"IBLOCK_BINDING" => "section",
		"IBLOCK_ID" => "#PRODUCTS_IBLOCK_ID#",
		"IBLOCK_TYPE" => "products"
	)
);?>
<h3>Наши услуги</h3>
 <?$APPLICATION->IncludeComponent(
	"bitrix:furniture.catalog.index",
	"",
	Array(
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"IBLOCK_BINDING" => "element",
		"IBLOCK_ID" => "#SERVICES_IBLOCK_ID#",
		"IBLOCK_TYPE" => "products"
	)
);?>
<p>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news",
	".default",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(0=>"",1=>"",),
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "arrows",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(0=>"",1=>"",),
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PANEL" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => "#NEWS_IBLOCK_ID#",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(0=>"",1=>"",),
		"LIST_PROPERTY_CODE" => array(0=>"",1=>"",),
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "5",
		"NUM_DAYS" => "30",
		"NUM_NEWS" => "20",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/news/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => array("news"=>"","section"=>"","detail"=>"#ELEMENT_ID#/","search"=>"search/","rss"=>"rss/","rss_section"=>"#SECTION_ID#/rss/",),
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "Y",
		"USE_SEARCH" => "N",
		"YANDEX" => "N"
	)
);?>
<p>
	 Если вы используете базовую редакцию продукта - «Компания», то можете перейти на редакцию «Совместная работа», и ваш портал приобретет все возможности для осуществления горизонтальных коммуникаций и управлению Экстранетом. Вы сможете организовать внутри компании коллективную работу над проектами в рабочих группах, вести учет и планирование времени и событий, обмениваться сообщениями и почтой через портал, проводить внутри компании видеоконференции и делать многое другое.
</p>
<p>
	 Можете сразу перейти с «младшей», базовой редакции на «Бизнес-процессы». После такого перехода ваш портал можно будет интегрировать с внешним сайтом, на портале добавятся возможности визуального проектирования бизнес-процессов и управления списками, включая списки в рабочих группах. Кроме того, вы сможете анализировать посещаемость своего портала
</p>
<p>
	 При переходе вся информация на портале сохранится. Вам не потребуется создавать сайт заново. <br>
	 С помощью технологии SiteUpdate вы получите новые модули продукта и установите их без помощи разработчиков.
</p>
<h2>Выставка новых образцов</h2>
 <img src="/bitrix/templates/.default/content/10.png" alt="" align="left">
<p>
	 Ваш портал приобретет все возможности для осуществления горизонтальных коммуникаций и управлению Экстранетом. Вы сможете организовать внутри компании коллективную работу над проектами в рабочих группах, вести учет и планирование времени и событий, обмениваться сообщениями и почтой через портал, проводить внутри компании видеоконференции и делать многое другое.
</p>
<h3>Заголовок</h3>
<p>
 <i>Можете сразу перейти с «младшей», базовой редакции на «Бизнес-процессы». После такого перехода ваш портал можно будет интегрировать с внешним сайтом, на портале добавятся возможности визуального проектирования бизнес-процессов и управления списками, включая списки в рабочих группах. Кроме того, вы сможете анализировать посещаемость своего портала </i>
</p>
<p>
	 При переходе вся информация на портале сохранится. Вам не потребуется создавать сайт заново. С помощью технологии SiteUpdate вы получите новые модули продукта и установите их без помощи разработчиков.
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
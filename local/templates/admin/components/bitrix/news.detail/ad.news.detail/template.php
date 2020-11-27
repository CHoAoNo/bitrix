<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
$this->addExternalCss($this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css');
CUtil::InitJSCore(array('fx'));
?>

<div class="bx-newsdetail">
	<div class="bx-newsdetail-block" id="<?echo $this->GetEditAreaId($arResult['ID'])?>">

	<?if($arParams["DISPLAY_PICTURE"]!="N"):?>
		<?if ($arResult["VIDEO"]):?>
			<div class="bx-newsdetail-youtube embed-responsive embed-responsive-16by9" style="display: block;">
				<iframe src="<?echo $arResult["VIDEO"]?>" frameborder="0" allowfullscreen=""></iframe>
			</div>
		<?elseif ($arResult["SOUND_CLOUD"]):?>
			<div class="bx-newsdetail-audio">
				<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?echo urlencode($arResult["SOUND_CLOUD"])?>&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>
			</div>
		<?elseif ($arResult["SLIDER"] && count($arResult["SLIDER"]) > 1):?>
			<div class="bx-newsdetail-slider">
				<div class="bx-newsdetail-slider-container" style="width: <?echo count($arResult["SLIDER"])*100?>%;left: 0%;">
					<?foreach ($arResult["SLIDER"] as $file):?>
					<div style="width: <?echo 100/count($arResult["SLIDER"])?>%;" class="bx-newsdetail-slider-slide">
						<img src="<?=$file["SRC"]?>" alt="<?=$file["DESCRIPTION"]?>">
					</div>
					<?endforeach?>
					<div style="clear: both;"></div>
				</div>
				<div class="bx-newsdetail-slider-arrow-container-left"><div class="bx-newsdetail-slider-arrow"><i class="fa fa-angle-left" ></i></div></div>
				<div class="bx-newsdetail-slider-arrow-container-right"><div class="bx-newsdetail-slider-arrow"><i class="fa fa-angle-right"></i></div></div>
				<ul class="bx-newsdetail-slider-control">
					<?foreach ($arResult["SLIDER"] as $i => $file):?>
						<li rel="<?=($i+1)?>" <?if (!$i) echo 'class="current"'?>><span></span></li>
					<?endforeach?>
				</ul>
			</div>
		<?elseif ($arResult["SLIDER"]):?>
			<div class="bx-newsdetail-img">
				<img
					src="<?=$arResult["SLIDER"][0]["SRC"]?>"
					width="<?=$arResult["SLIDER"][0]["WIDTH"]?>"
					height="<?=$arResult["SLIDER"][0]["HEIGHT"]?>"
					alt="<?=$arResult["SLIDER"][0]["ALT"]?>"
					title="<?=$arResult["SLIDER"][0]["TITLE"]?>"
					/>
			</div>
		<?elseif (is_array($arResult["DETAIL_PICTURE"])):?>
			<div class="bx-newsdetail-img">
				<img
					src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
					width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
					height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
					alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
					title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
					/>
			</div>
		<?endif;?>
	<?endif?>

	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3 class="bx-newsdetail-title"><?=$arResult["NAME"]?></h3>
	<?endif;?>

	<div class="bx-newsdetail-content">
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
	<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	</div>

	<?foreach($arResult["FIELDS"] as $code=>$value):?>
		<?if($code == "SHOW_COUNTER"):?>
			<div class="bx-newsdetail-view"><i class="fa fa-eye"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
				<?=intval($value);?>
			</div>
		<?elseif($code == "SHOW_COUNTER_START" && $value):?>
			<?
			$value = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($value, CSite::GetDateFormat()));
			?>
			<div class="bx-newsdetail-date"><i class="fa fa-calendar-o"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
				<?=$value;?>
			</div>
		<?elseif($code == "TAGS" && $value):?>
			<div class="bx-newsdetail-tags"><i class="fa fa-tag"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
				<?=$value;?>
			</div>
		<?elseif($code == "CREATED_USER_NAME"):?>
			<div class="bx-newsdetail-author"><i class="fa fa-user"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
				<?=$value;?>
			</div>
		<?elseif ($value != ""):?>
			<div class="bx-newsdetail-other"><i class="fa"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
				<?=$value;?>
			</div>
		<?endif;?>
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<?
		if(is_array($arProperty["DISPLAY_VALUE"]))
			$value = implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
		else
			$value = $arProperty["DISPLAY_VALUE"];
		?>
		<?if($arProperty["CODE"] == "FORUM_MESSAGE_CNT"):?>
			<div class="bx-newsdetail-comments"><i class="fa fa-comments"></i> <?=$arProperty["NAME"]?>:
				<?=$value;?>
			</div>
		<?elseif ($value != ""):?>
			<div class="bx-newsdetail-other"><i class="fa"></i> <?=$arProperty["NAME"]?>:
				<?=$value;?>
			</div>
		<?endif;?>
	<?endforeach;?>

	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<div class="bx-newsdetail-date"><i class="fa fa-calendar-o"></i> <?echo $arResult["DISPLAY_ACTIVE_FROM"]?></div>
	<?endif?>
	<?if($arParams["USE_RATING"]=="Y"):?>
		<div class="bx-newsdetail-separator">|</div>
		<div class="bx-newsdetail-rating">
			<?$APPLICATION->IncludeComponent(
				"bitrix:iblock.vote",
				"flat",
				Array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_ID" => $arResult["ID"],
					"MAX_VOTE" => $arParams["MAX_VOTE"],
					"VOTE_NAMES" => $arParams["VOTE_NAMES"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
					"SHOW_RATING" => "Y",
				),
				$component
			);?>
		</div>
	<?endif?>

	<div class="row">
		<div class="col-xs-5">
		</div>
	<?
	if ($arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="col-xs-7 text-right">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", $arParams["SHARE_TEMPLATE"], array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
	</div>
	</div>
</div>
<script type="text/javascript">
	BX.ready(function() {
		var slider = new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arResult['ID']));?>', {
			imagesContainerClassName: 'bx-newsdetail-slider-container',
			leftArrowClassName: 'bx-newsdetail-slider-arrow-container-left',
			rightArrowClassName: 'bx-newsdetail-slider-arrow-container-right',
			controlContainerClassName: 'bx-newsdetail-slider-control'
		});
	});
</script>

<? 
	//перевод заголовка в массив для поиска схожих новостей, + добавление id текущей новости
	$buf = explode(' ', $arResult["NAME"]);
		$arrFilter = array();
	foreach($buf as $name){
		if(mb_strlen($name)>3)
			$arrFilter[]=$name;
	}
?>



<div class="news-list">
<h2>Похожие новости</h2>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"ad.news.same", 
	array(
		"COMPONENT_TEMPLATE" => "ad.news.same",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",

		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"MY_FILTER_DATA" => $arrFilter,
		"MY_FILTER_ID" => $arResult['ID'],
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "PROPERTY1",
			1 => "PROPERTY2",
			2 => "PROPERTY3",
			3 => "PROPERTY4",
			4 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "#SITE_DIR#/admin/iblock/detail.php?ELEMENT_ID=#ELEMENT_ID#",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => "arrows",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>
</div>


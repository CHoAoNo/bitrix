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
?>

<script type="text/javascript" >
	$().ready(function(){
		$(function(){
			$('#slides').slides({
				preload: true,
				generateNextPrev: false,
				autoHeight: true,
				play: 4000,
				effect: 'fade'
			});
		});
	});
</script>
		
<div class="sl_slider" id="slides">
	<div class="slides_container">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
			<div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div>
				<? if(is_array($arItem["PREVIEW_PICTURE"])):?>
					<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" />
					<?endif;?>
					<h2><a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?echo $arItem["NAME"]?></a></h2>
					<p><?=$arItem["PREVIEW_TEXT"]?></p>
					<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>" class="sl_more">Подробнее &rarr;</a>
				</div>
			</div>
		<?endforeach;?>
	</div>
</div>
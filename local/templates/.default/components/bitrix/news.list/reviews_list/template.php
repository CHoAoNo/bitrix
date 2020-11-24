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

<?foreach($arResult["ITEMS"] as $arItem):?>
<div class="review-block">
	<div class="review-text">
	
		<div class="review-block-title"><span class="review-block-name"><a href="<?= $arItem['DETAIL_PAGE_URL']?>"><?echo $arItem["NAME"]?></a></span><span class="review-block-description"><?echo $arItem["PROPERTIES"]["POSITION"]["VALUE"]?> <?echo $arItem["PROPERTIES"]["COMPANY_NAME"]["VALUE"]?></span></div>
		
		<div class="review-text-cont">
			<?echo $arItem["PREVIEW_TEXT"]?>
		</div>
		
	</div>
	<div class="review-img-wrap"><a href="<?= $arItem['DETAIL_PAGE_URL']?>">
		<? if(is_array($arItem["PREVIEW_PICTURE"])):?>
			<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="img">
		<?endif;?>
	</a></div>
</div>
<?endforeach;?>

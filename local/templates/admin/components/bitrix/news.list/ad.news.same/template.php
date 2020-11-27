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

<div class="news-list">
	<ul>
	<?$count=1;?>
	
	<?foreach($arResult["ITEMS"] as $arItem):?>
	<?if($count==6){break;}?>

		<? //разбиение заголовка текущей новости на массив и поиск пересения с искомой новостью
			$arr = explode(' ', $arItem["NAME"]);
		?>
		<?if( array_intersect($arr, $arParams['MY_FILTER_DATA']) && ($arItem['ID']!=$arParams['MY_FILTER_ID']) ):?>
			<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			
			<li class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
						<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
					<?else:?>
						<b><?echo $arItem["NAME"]?></b><br />
					<?endif;?>
				<?endif;?>
				
				<? 
					
					$ar = explode(' ', $arItem["DETAIL_TEXT"], 11);
					$preview_text = implode(' ', array_slice($ar, 0, 10));
				?>	
				
				<div id="preview-text<?=$count?>">
					<p><?=$preview_text?></p>
					<a href="javascript:change_visibility ('preview-text<?=$count?>', 'detail-text<?=$count?>')">Показать все</a>		
				</div>

				<div id="detail-text<?=$count?>" style="display:none">
					<p><?=$preview_text?> <?=$ar[10]?></p>
					<a href="#" onClick="change_visibility ('detail-text<?=$count?>', 'preview-text<?=$count?>')">Скрыть все</a>
				</div>
				
			</li>
			<?++$count;?>
		<?endif;?>
	<?endforeach;?>
	
	<?if($count==1):?>
		<p>Схожих новостей нет</p>
	<?endif;?>
	</ul>
</div>




<script type="text/javascript">
function change_visibility (block_4_close, block_4_open) {
    document.getElementById(block_4_close).style.display='none';
    document.getElementById(block_4_open).style.display='';
		event.preventDefault();
}
</script>

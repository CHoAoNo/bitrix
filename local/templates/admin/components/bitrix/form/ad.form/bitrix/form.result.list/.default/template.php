<? //список
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="wrap-form">

<a class="pushme" href="#">Создать</a>


<?
if (strlen($arResult["FORM_ERROR"]) > 0) ShowError($arResult["FORM_ERROR"]);
if (strlen($arResult["FORM_NOTE"]) > 0) ShowNote($arResult["FORM_NOTE"]);
?>


<form name="rform_<?=$arResult["filter_id"]?>" method="post" action="<?=POST_FORM_ACTION_URI?>#nav_start">
	<input type="hidden" name="WEB_FORM_ID" value="<?=$arParams["WEB_FORM_ID"]?>" />
	<?=bitrix_sessid_post()?>
	<div class="navigation">
	<?=$arResult["pager"]?>
	</div>
	<table class="form-table data-table">
		<?
		/***********************************************
					  table header
		************************************************/
		?>
		<thead>
			<tr>
				<th>								
					<table class="form-results-header-inline">
						<tr>
							<th>
							<?
							if ($arParams["can_delete_some"]) 
							{
							?>
							
							<?
							} //endif ($can_delete_some);
							?>ID<?if ($arParams["SHOW_STATUS"]!="Y") { ?><?=SortingEx("s_id")?><? } //endif($SHOW_STATUS!="Y");?></th>
							<?
							if ($arParams["SHOW_STATUS"]=="Y") 
							{
							?>
							<td><?=SortingEx("s_id")?></td>
							<?
							} //endif($SHOW_STATUS=="Y");
							?>
						</tr>
						
					</table>
				</th>
				<th><?=GetMessage("FORM_TIMESTAMP")?><?=SortingEx("s_timestamp")?></th>
				<?
				if ($arParams["F_RIGHT"] >= 25) 
				{ 
				?>
				
				<? 
				} //endif;($F_RIGHT>=25)
				?>
				<?
				$colspan = 4;
				if (is_array($arResult["arrColumns"])) 
				{
					foreach ($arResult["arrColumns"] as $arrCol)
					{
						if (!is_array($arParams["arrNOT_SHOW_TABLE"]) || !in_array($arrCol["SID"], $arParams["arrNOT_SHOW_TABLE"])) 
						{
							if (($arrCol["ADDITIONAL"]=="Y" && $arParams["SHOW_ADDITIONAL"]=="Y") || $arrCol["ADDITIONAL"]!="Y") 
							{
								$colspan++;
								?>
				<th>
								<?
								if ($arParams["F_RIGHT"] >= 25) 
								{
								?>
								<?
								}//endif($F_RIGHT>=25);
								?>
								<?=$arrCol["RESULTS_TABLE_TITLE"]?>
				</th><?
							} //endif(($arrCol["ADDITIONAL"]=="Y" && $SHOW_ADDITIONAL=="Y") || $arrCol["ADDITIONAL"]!="Y");
						} //endif(!is_array($arrNOT_SHOW_TABLE) || !in_array($arrCol["SID"],$arrNOT_SHOW_TABLE));
					} //foreach
				} //endif(is_array($arrColumns)) ;
				?>
				<th><?=GetMessage("FORM_STATUS")?></th>
			</tr>
		</thead>
		
		<?
		/***********************************************
					  table body
		************************************************/
		?>
		<?
		if(count($arResult["arrResults"]) > 0)
		{
			?>
			<tbody>
			<?
			$j=0;
			foreach ($arResult["arrResults"] as $arRes)
			{ 
				$j++;

			if ($arParams["SHOW_STATUS"]=="Y" || $arParams["can_delete_some"] && $arRes["can_delete"])
			{
				if ($j>1) 
				{
			?>
				
			<?
				} //endif ($j>1);
			?>
				
			<? 
			} //endif ($SHOW_STATUS=="Y");
			?>
				<tr>
					<td>

						<b><?=($arParams["USER_ID"]==$arRes["USER_ID"]) ? "<span class='form-result-id'>".$arRes["ID"]."</span>" : $arRes["ID"]?></b>

				</td>
				<td><?=$arRes["TSX_0"]?>  <?=$arRes["TSX_1"]?></td>
				<?
				if ($arParams["F_RIGHT"] >= 25) 
				{ 
				?>

				<? 
				} //endif ($F_RIGHT>=25);
				?>
				<?
				foreach ($arResult["arrColumns"] as $FIELD_ID => $arrC)
				{
					if (!is_array($arParams["arrNOT_SHOW_TABLE"]) || !in_array($arrC["SID"], $arParams["arrNOT_SHOW_TABLE"])) 
					{
						if (($arrC["ADDITIONAL"]=="Y" && $arParams["SHOW_ADDITIONAL"]=="Y") || $arrC["ADDITIONAL"]!="Y") 
						{						
				?>
				<td>
					<?
					
					$arrAnswer = $arResult["arrAnswers"][$arRes["ID"]][$FIELD_ID];
					if (is_array($arrAnswer)) 
					{
						foreach ($arrAnswer as $key => $arrA)
						{
						?>
							<?if (strlen(trim($arrA["USER_TEXT"])) > 0) {?><?=$arrA["USER_TEXT"]?><?}?>
							<?if (strlen(trim($arrA["ANSWER_TEXT"])) > 0) {?>[<span class='form-anstext'><?=$arrA["ANSWER_TEXT"]?></span>]&nbsp;<?}?>
							<?if (strlen(trim($arrA["ANSWER_VALUE"])) > 0 && $arParams["SHOW_ANSWER_VALUE"]=="Y") {?>(<span class='form-ansvalue'><?=$arrA["ANSWER_VALUE"]?></span>)<?}?>
									
									<?
									if (intval($arrA["USER_FILE_ID"])>0) 
									{
										if ($arrA["USER_FILE_IS_IMAGE"]=="Y") 
										{
										?>
											<?=$arrA["USER_FILE_IMAGE_CODE"]?>
										<?
										}
										else 
										{
										?>
										<a title="<?=GetMessage("FORM_VIEW_FILE")?>" target="_blank" href="/bitrix/tools/form_show_file.php?rid=<?=$arRes["ID"]?>&hash=<?=$arrA["USER_FILE_HASH"]?>&lang=<?=LANGUAGE_ID?>"><?=$arrA["USER_FILE_NAME"]?></a>
										(<?=$arrA["USER_FILE_SIZE_TEXT"]?>)
										[&nbsp;<a title="<?=str_replace("#FILE_NAME#", $arrA["USER_FILE_NAME"], GetMessage("FORM_DOWNLOAD_FILE"))?>" href="/bitrix/tools/form_show_file.php?rid=<?=$arRes["ID"]?>&hash=<?=$arrA["USER_FILE_HASH"]?>&lang=<?=LANGUAGE_ID?>&action=download"><?=GetMessage("FORM_DOWNLOAD")?></a>&nbsp;]
										<?
										}
									}
									?>
						<? 
						} //foreach
					} // endif (is_array($arrAnswer));
					?>
				</td>
				<?
					} //endif (($arrC["ADDITIONAL"]=="Y" && $SHOW_ADDITIONAL=="Y") || $arrC["ADDITIONAL"]!="Y") ;
					} // endif (!is_array($arrNOT_SHOW_TABLE) || !in_array($arrC["SID"],$arrNOT_SHOW_TABLE));
				} //foreach
				?>
				<td><span class="<?=htmlspecialcharsbx($arRes["STATUS_CSS"])?>"><?=htmlspecialcharsbx($arRes["STATUS_TITLE"])?></span></td>
			</tr>
			<? 
			} //foreach
			?>
			</tbody>
		<?
		}
		?>
		<?
		if ($arParams["HIDE_TOTAL"]!="Y") 
		{ 
		?>
		<tfoot>
			<tr>
				<th colspan="<?=$colspan?>"><?=GetMessage("FORM_TOTAL")?>&nbsp;<?=$arResult["res_counter"]?></th>
			</tr>
		</tfoot>
		<? 
		} //endif ($HIDE_TOTAL!="Y");
		?>

	</table>	
	<div class="navigation"><?=$arResult["pager"]?></div>
</form>
</div>


<script>
$(function(){
	$('.pushme').click(function(e){
		getForm();
		e.preventDefault();
	});
	
	$('body').on('submit','.popup-form form',function(e){
		e.preventDefault();
		var dataForm = $(this).serialize()+'web_form_submit=Y';
		$.fancybox.showLoading();
		getForm(dataForm);
	});
});

function getForm(data){		
	$.ajax({
		url: 'form.php',
		type: 'POST',
		data: data,
		success: function(data){
		$.fancybox({content:data,helpers:{overlay:{locked: false}}});
		$.fancybox.hideLoading();
		}
	});
}
</script>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//echo "<pre>arParams: "; print_r($arParams); echo "</pre>";
//echo "<pre>arResult: "; print_r($arResult); echo "</pre>";

//echo "<pre>"; print_r($arResult["arrFORM_FILTER"]); echo "</pre>";
?>


<div class="wrap-form">

<?
if ($arParams["can_delete_some"])
{
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function OnDelete_<?=$arResult["filter_id"]?>()
{
	var show_conf;
	var arCheckbox = document.forms['rform_<?=$arResult["filter_id"]?>'].elements["ARR_RESULT[]"];
	if(!arCheckbox) return;
	if(arCheckbox.length>0 || arCheckbox.value>0)
	{
		show_conf = false;
		if (arCheckbox.value>0 && arCheckbox.checked) show_conf = true;
		else
		{
			for(i=0; i<arCheckbox.length; i++)
			{
				if (arCheckbox[i].checked) 
				{
					show_conf = true;
					break;
				}
			}
		}
		if (show_conf)
			return confirm("<?=GetMessage("FORM_DELETE_CONFIRMATION")?>");
		else
			alert('<?=GetMessage("FORM_SELECT_RESULTS")?>');
	}
	return false;
}

function OnSelectAll_<?=$arResult["filter_id"]?>(fl)
{
	var arCheckbox = document.forms['rform_<?=$arResult["filter_id"]?>'].elements["ARR_RESULT[]"];
	if(!arCheckbox) return;
	if(arCheckbox.length>0)
		for(i=0; i<arCheckbox.length; i++)
			arCheckbox[i].checked = fl;
	else
		arCheckbox.checked = fl;
}
//-->
</SCRIPT>
<? 
} //endif($can_delete_some);
?>

<?
if (strlen($arResult["FORM_ERROR"]) > 0) ShowError($arResult["FORM_ERROR"]);
if (strlen($arResult["FORM_NOTE"]) > 0) ShowNote($arResult["FORM_NOTE"]);
?>
<p>
<b><a href="<?=$arParams["NEW_URL"]?><?=$arParams["SEF_MODE"] != "Y" ? (strpos($arParams["NEW_URL"], "?") === false ? "?" : "&")."WEB_FORM_ID=".$arParams["WEB_FORM_ID"] : ""?>"><?=GetMessage("FORM_ADD")?>&nbsp;&nbsp;&gt;&gt;</a></b>
</p>
<form name="rform_<?=$arResult["filter_id"]?>" method="post" action="<?=POST_FORM_ACTION_URI?>#nav_start">
	
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
							?>ID<?if ($arParams["SHOW_STATUS"]!="Y") { ?><br /><?=SortingEx("s_id")?><? } //endif($SHOW_STATUS!="Y");?></th>
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
				<td><?=$arRes["TSX_0"]?><br /><?=$arRes["TSX_1"]?></td>
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
							<?if (strlen(trim($arrA["USER_TEXT"])) > 0) {?><?=$arrA["USER_TEXT"]?><br /><?}?>
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
										(<?=$arrA["USER_FILE_SIZE_TEXT"]?>)<br />
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

	
</form>
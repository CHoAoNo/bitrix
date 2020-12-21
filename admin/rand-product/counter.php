<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
$id_arr = json_decode($_POST["idArray"]);

if(CModule::IncludeModule("iblock")){ 

	$IBLOCK_ID = 8;										// id инфоблока
	$PROPERTY_CODE = "SHOW_COUNTER";  // код свойства

	foreach($id_arr as $id){
		$db_props = CIBlockElement::GetProperty( $IBLOCK_ID, $id, array("sort" => "asc"), array("CODE"=>"$PROPERTY_CODE") );
		
		if($ar_props = $db_props->fetch()) {
			$count = IntVal($ar_props["VALUE"]) + 1;

			// Установим новое значение для данного свойства данного элемента
			CIBlockElement::SetPropertyValuesEx($id, $IBLOCK_ID, array($PROPERTY_CODE => $count));
		}  

	}
	
}
?>

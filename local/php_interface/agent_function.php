<?
function SearchNewUsers() {

	// фильтр по дате регистрации реализованый в классе CUser работает только на дату, но не на время
	// полученые даные надо фильтровать ещё
	
	// фильтр на предыдущий день
	$s1 = strtotime("-1 day");
	$s2 = strtotime("today");
	$filter = array(
		 "DATE_REGISTER_1" => date('d.m.Y H:i:s', $s1),
		 "DATE_REGISTER_2" => date('d.m.Y H:i:s', $s2),
		 'ACTIVE' => 'Y'
	);
	
	$arParameters = array(
		"FIELDS" => array(
			"LOGIN", "EMAIL", "DATE_REGISTER"
		)
	);

	// почта по умолчанию
	$SMTP_MAIL = COption::GetOptionString("main", "email_from");
	
	// текст письма (список пользователей по фильтру)
	$buf = "";

	$elementsResult = CUser::GetList(($by="ID"), ($order="ASC"), $filter, $arParameters);
	while ($rsUser = $elementsResult->Fetch()) 
	{
		// фильтр на 24 часа
		if(strtotime($rsUser["DATE_REGISTER"]) >= $s1 && strtotime($rsUser["DATE_REGISTER"]) <= $s2)
			$buf .= $rsUser["LOGIN"] . " - " . $rsUser["EMAIL"] . " - " . $rsUser["DATE_REGISTER"] . "\n";
	}

	if($buf != "")
		mail($SMTP_MAIL, 'Зарегистрированные за последние 24 часа', $buf);

	return "SearchNewUsers();";

}
?>
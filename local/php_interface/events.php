<?
// добавляем обработчик события при регистрации
AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
// а заодно и при обновлении данных пользователем
AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserRegisterHandler");

// описываем саму функцию 
function OnBeforeUserRegisterHandler($args){
	// выборка из бд с заданной почтой
	$b = $o = "";
	$res = CUser::GetList($b, $o,
		array(
			"=EMAIL" => $args["EMAIL"]
		),
		array(
			"FIELDS" => array("ID")
		)
	);
	
	// проверка на недопустимые домены
	if (preg_match('/(rambler.ru|list.ru)/', $args['EMAIL'])){
		$GLOBALS['APPLICATION']->ThrowException('Недопустимый домен почты'); 
		return false;   
	}
	// проверка на уникальность почты
	if($ar = $res->Fetch())
	{
		$GLOBALS['APPLICATION']->ThrowException('Недопустимая почта'); 
		return false;
	}
	
  return true;
}
?>
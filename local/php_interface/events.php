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


// обработчик события после регистрации
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");

function OnAfterUserRegisterHandler($arFields){
	
	$backUrl = ($_REQUEST["backurl"]) ?: 'нет информации';
	
	// если регистрация успешна, то отправить письмо (шаблон настроен на #DEFAULT_EMAIL_FROM#)
	if($arFields["USER_ID"]>0)
	{
		Bitrix\Main\Mail\Event::sendImmediate( array(
			"EVENT_NAME" => "MY_NEW_USER",
			"LID" => SITE_ID,
			"C_FIELDS" => array(
				"USER_ID"	=> $arFields['USER_ID'],
				"DATE" 		=> date("d.m.Y H:i:s"),
				"LOGIN"		=> $arFields['LOGIN'],
				"EMAIL"		=> $arFields['EMAIL'],
				"PAGE"		=> $backUrl
			)
		)); 
	}
	
}


// Отключение стандартного уведомления о регистрации пользователя с почтой в домене yandex.ru
AddEventHandler("main", "OnBeforeEventAdd", "DoNotSendMail");
function DoNotSendMail ($event, $lid, $arFields) {
	// определяем ID заказа

	if ($event == 'NEW_USER' && preg_match('/yandex.ru/', $arFields['EMAIL']) )
		return false;
}
?>
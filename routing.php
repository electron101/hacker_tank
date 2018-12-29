<?php
//Маршрутизация
//Подлючение базового файла шаблона и подгрузка основного контента
/*
	Пример:
	$act = isset($_GET['act']) ? $_GET['act'] : "";
	switch($act)
	{
		case "Some variable":
			SomeFunction();
			break;
		default:
			SomeFunction();
			break;
	}
*/
$act = isset($input['act']) ? $input['act'] : "";
	
switch($act)
{
	case "Test":
		load_test();
		break;
	case "get_results":
		get_result();
		break;
	case "logout":
		logout();
		break;
	case "login":
		login();
		break;
	// регистрация
	case "register":
		register();
		break;
	// зарегаться
	case "do_reg":
		do_reg();
		break;
	// загрузить задачи в правую часть листаs
	case "select_subject":
		load_tasks();
		break;
	case "do_login":
		do_login();
		break;
	case "code":
		loadBase();
		break;
	case "compile_this":
		compile_this();
		break;
	case "change_lang":
		change_lang();
		break;
	case "arrays":
		loadStart();
		break;
	default:
		loadStart();
		break;
}
?>

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
	// загрузить задачи в правую часть листа
	case "sel_task":
		load_task_list_to_main_content($str);
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
	case "load_start":
		loadStart($str);
		break;
	/** Загружаем тесты */
	case "admin_tests":
		admin_tests();
		break;
	case "test_add":
		test_add();
		break;
	case "save_test":
		save_test();
		break;
	/** Пользаки */
	case "admin_users":
		admin_users();
		break;
	case "del_users":
		DeleteConfirmation();
		break;
	default:
		loadStart($str);
		break;
}
?>

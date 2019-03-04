<?php
//Маршрутизация
//Подлючение базового файла шаблона и подгрузка основного контента
/*
	Пример:
	$act = isset($input['act']) ? $input['act'] : "";
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

switch ($act) {
	case "Test":
		load_test();
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
	case "apply_this":
		apply_this();
		break;
	case "save_statistic":
		save_statistic();
		break;
	case "change_lang":
		change_lang();
		break;
	case "load_start":
		loadStart($str);
		break;
	case "admin_categories":
		admin_categories();
		break;
	case "category_add":
		category_add();
		break;
	case "lesson_add":
		lesson_add();
		break;
	case "add_new_category":
		add_new_category();
		break;
	case "add_new_lesson":
		add_new_lesson();
		break;
	case "edit_category":
		edit_category();
		break;
	case "edit_lesson":
		edit_lesson();
		break;
	case "update_category":
		update_category();
		break;
	case "update_lesson":
		update_lesson();
		break;
	case "admin_lessons":
		admin_lessons();
		break;
	/** Загружаем тесты */
	case "admin_tests":
		admin_tests();
		break;
	case "test_add":
		test_add();
		break;
	case "edit_test":
		edit_test();
		break;
	case "update_test":
		update_test();
		break;
	case "save_test":
		save_test();
		break;
	/** Пользаки */
	case "admin_users":
		admin_users();
		break;
	case "go_back":
		go_back();
		break;
	case "del_test":
		DeleteConfirmation();
		break;
	case "del_users":
		DeleteConfirmation();
		break;
	case "del_category":
		DeleteConfirmation();
		break;
	case "del_lesson":
		DeleteConfirmation();
		break;
	case "download_file":
		download_file();
		break;
	case "del_file":
		del_file();
		break;
	// подтверждение удаления
	case "confirm_delete":
		Delete();
		break;
	default:
		loadStart($str);
		break;
}
?>
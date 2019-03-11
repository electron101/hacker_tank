<?php
/** Класс отрисовки страниц */
include("classes/render/render.php");
/** класс работы с базой mysql */
include("classes/mysqli/MySqlConnection.php");
/** Подключение к бд */
require_once("classes/ssa/ConnectDb.php");

/** Генератор форм */
include("classes/ssa/moldmaker.php");

/** Разные полезные функции */
include("classes/ssa/AdditionalFunc.php");

/** Компилятор */
include("compiler.php");

/** Глобальные переменные */
$str = "Select t.id_lesson, t.id_task, t.name as task_name, c.name, l.description, t.tex_min, l.name as lesson_name,
			t.rus_name, t.id_category
			From task as t
			Inner Join lessons as l On l.id_lesson = t.id_lesson
			Inner Join category as c On c.id_category = t.id_category";

/** Экземпляр класса подключения */
$ConDB = new ConnectDB();

/** Основные функции */

function load_task_list_for_navbar()
{
    $query = "Select * From lessons order by id_lesson";
    $context = LoadDataFromDB($query);
    return $context;
}

//Стартовая страница
function loadStart($str)
{
    $query = $str . " Where t.id_lesson = (Select id_lesson From lessons order by id_lesson Limit 1)
		Order By t.id_task";
    $context['tasks'] = LoadDataFromDB($query);
    if (isset($_SESSION['id']))
    {
        $query_stat = "Select percent, id_task From statistic Where id_polzov = ".$_SESSION['id']." ORDER BY percent desc LIMIT 1";
        $context['stat'] = LoadDataFromDB($query_stat);
    }
    else
        $context['stat']['data'] = array();
    $render = new Render("templates/start_page.php", $context);
    return $render->renderPage();
}

/** Загрузка заданий по уроку */
function load_task_list_to_main_content($str)
{
    $input = $GLOBALS['input'];
    $id_lesson = isset($input['id']) ? $input['id'] : "";
    $query = $str . " Where t.id_lesson=$id_lesson Order by t.id_task";
    if (isset($_SESSION['id']))
    {
        $query_stat = "Select percent, id_task From statistic Where id_polzov = ".$_SESSION['id']." ORDER BY percent desc LIMIT 1";
        $context['stat'] = LoadDataFromDB($query_stat);
    }
    else
        $context['stat']['data'] = array();
    $context['tasks'] = LoadDataFromDB($query);
    $render = new Render("templates/start_page.php", $context);
    return $render->renderPage();
}

/** ЛИЧНЫЙ КАБИНЕТ */
function show_lk()
{
    $query = "Select p.name, s.percent, t.rus_name, l.name as language From polzov p";
    $query .= " INNER JOIN statistic s ON s.id_polzov = p.id_polzov";
    $query .= " INNER JOIN task t ON t.id_task = s.id_task";
    $query .= " INNER JOIN lang l ON l.id_lang = s.id_lang";
    $query .= " Where p.id_polzov = ".$_SESSION['id'];
    $context = LoadDataFromDB($query);

    $render = new Render("templates/lk.php", $context);
    return $render -> renderPage();
}

function loadBase()
{
    if (!isset($_SESSION['login'])) {
        $render = new Render("service_files/please_login.php");
        return $render->renderPage();
    }
    $input = $GLOBALS['input'];
    $task_name = isset($input['task_name']) ? $input['task_name'] : "";
    $id = isset($input['id']) ? $input['id'] : "";

    /*Корпирование директории*/
    $dir = "data/users/" . $_SESSION['login'] . "/" . $task_name;
    AddFunc::copydirect("data/code_templates/" . $task_name, $dir, 1);

    $query = "Select rus_name, tex_min, text, name, id_task From task Where id_task = " . $id;
    $context['bd'] = LoadDataFromDB($query);

    $snippet = "data/code_templates/" . $task_name . "/c/org_snippet";
    if (file_exists($snippet))
        $context['code'] = file_get_contents($snippet);
    $render = new Render("templates/main.php", $context, "standalone");                         //~standalone			
    return $render->renderPage();
}

//смена языка
function change_lang()
{
    $input = $GLOBALS['input'];
    $lang = isset($input['lang']) ? $input['lang'] : "";
    $task_name = isset($input['task_name']) ? $input['task_name'] : "";

    switch ($lang) {
        case "c":
            $code = file_get_contents("data/code_templates/" . $task_name . "/c/org_snippet");
            break;
        case "sharp":
            $code = file_get_contents("data/code_templates/" . $task_name . "/sharp/org_snippet");
            break;
        default:
            $code = file_get_contents("data/code_templates/" . $task_name . "/c/org_snippet");
            break;
    }
    echo $code;
}

function login()
{
    $render = new Render("templates/login.php");
    return $render->renderPage();
}

function compile_this()
{
    $input = $GLOBALS['input'];
    $val = isset($input['val']) ? $input['val'] : "";
    $code = isset($input['code']) ? $input['code'] : "";
    $lang = isset($input['lang']) ? $input['lang'] : "";
    $task_name = isset($input['task_name']) ? $input['task_name'] : "";

    $Compiler = new Compiler($val, $code, $lang, $task_name);
    $result = $Compiler->compile();
    echo $result['message'];
    echo $result['output'];
    return;
}

/** Сохранение пользовательской статистики */
function save_statistic()
{
    $input = $GLOBALS['input'];
    $percent = isset($input['percent']) ? $input['percent'] : "";
    $lang = isset($input['lang']) ? $input['lang'] : "";
    $id_task = isset($input['id_task']) ? $input['id_task'] : "";

    $query_l = "SELECT id_lang FROM lang Where name = '".$lang."'";
    $context = LoadDataFromDB($query_l);
    $id_lang = $context['data'][0]['id_lang'];

    $query = "INSERT INTO statistic (id_polzov, id_task, percent, id_lang) VALUES (?,?,?,?)";
    $params = array($_SESSION['id'], $id_task, $percent, $id_lang);
    $types = "iiii";

    $res = bd_interaction($query, $params, $types);

    echo $res;
    return;
}

// войти
function do_login()
{
    $input = $GLOBALS["input"];
    if (isset($input['login']) && isset($input['password'])) {
        $login = $input['login'];
        $password = $input['password'];

        $query = "Select id_polzov as id, u.name, u.role From polzov u Where u.name='$login'";
        $context = LoadDataFromDB($query);

        if ($context["status"] == 1 && count($context["data"]) > 0) {
            $login = $context["data"][0]["name"];
            $role = $context["data"][0]["role"];
            $id = $context["data"][0]["id"];
            session_variables_create($login, $role, $id);
            loadStart($GLOBALS["str"]);
        } else {
            $render = new Render("service_files/user_not_found.php", $context);
            return $render->renderPage();
        }
    } else return;
}

// регистрация
function register()
{
    $render = new Render("templates/register.php");
    return $render->renderPage();
}

// обработка данных регистрации
function do_reg()
{
    $input = $GLOBALS["input"];
    $str = isset($input['str']) ? $input['str'] : "";
    $data = array();
    foreach (explode('&', $str) as $val) {
        preg_match_all("#([^,\s]+)=([^\*]+)#s", $val, $out);
        unset($out[0]);
        $out = array_combine($out[1], $out[2]);
        $data = array_merge($data, $out);
    }

    $login = isset($data['login']) ? $data['login'] : "";
    $pass = isset($data['pass']) ? $data['pass'] : "";
    $re_pass = isset($data['re_pass']) ? $data['re_pass'] : "";

    if ($pass != $re_pass) {
        echo 0;
        exit;
    }

    $query = "Select count(id_polzov) as counter From polzov Where name = '$login'";
    $context = LoadDataFromDB($query);
    if ($context["status"] == 1) {
        if ($context["data"][0]["counter"] > 0) {
            echo 1;
            exit;
        }
    }

    $query = "Insert Into polzov (name, pas, role) VALUES (?,?,?)";
    $params = array($login, sha1($pass), 1); //1-обычный пользак
    $types = "ssi";

    $res = bd_interaction($query, $params, $types);
    if ($res["status"] != 1) {
        echo 2;
        exit;
    } else {
        create_file_structure($login, 'users');
        echo 1000;
        exit;
    }
}

// создание переменных сессии
function session_variables_create($login, $role, $id)
{
    $_SESSION['login'] = $login;
    $_SESSION['role'] = $role;
    $_SESSION['id'] = $id;
}

function logout()
{
    unset($_SESSION['login']);
    unset($_SESSION['role']);
    unset($_SESSION['id']);
    session_destroy();
    loadStart($GLOBALS["str"]);
}

/** АДМИНКА 																					*****************/
/** Разбираемся с категориями сложности и темами */
function admin_categories()
{
    $query = "Select * From category";
    $context = LoadDataFromDB($query);
    $render = new Render("templates/categories.php", $context);
    return $render->renderPage();
}

function category_add()
{
    $createView = new moldmaker('Category', 'Добавить категорию', 'add_new_category');
    $createView->CreateView();
}

function add_new_category()
{
    $input = $GLOBALS['input'];
    $name = isset($input['name']) ? $input['name'] : "";
    $query = "INSERT INTO category (name) VALUES (?)";
    $params = array($name);
    $types = 's';
    $res = bd_interaction($query, $params, $types);
    if ($res['status'] == 1)
    admin_categories();
}

function edit_category()
{
    $input = $GLOBALS['input'];
    $id = isset($input['id']) ? $input['id'] : "";
    $query = "Select id_category, name From category Where id_category = $id";
    $context = LoadDataFromDB($query);
    $editView = new moldmaker('Category', 'Редактировать категорию', 'update_category');
    $editView->EditView($context, $unique_key = 'id_category');
}

function update_category()
{
    $input = $GLOBALS['input'];
    if (!isset($input["unique_id"])) return;

    $id = isset($input['unique_id']) ? $input['unique_id'] : "";
    $name = isset($input['name']) ? $input['name'] : "";
    $query = 'Update category SET name = ? Where id_category = ?';
    $params = array($name, $id);
    $types = 'si';
    $res = bd_interaction($query, $params, $types);
    if ($res["status"] == 1) admin_categories();
}

function admin_lessons()
{
    $query = "Select * From lessons";
    $context = LoadDataFromDB($query);
    $render = new Render("templates/lessons.php", $context);
    return $render->renderPage();
}

function lesson_add()
{
    $createView = new moldmaker('Lesson', 'Добавить тему', 'add_new_lesson');
    $createView->CreateView();
}

function add_new_lesson()
{
    $input = $GLOBALS['input'];
    $name = isset($input['name']) ? $input['name'] : "";
    $description = isset($input['description']) ? $input['description'] : "";
    $query = "INSERT INTO lessons (name, description) VALUES (?, ?)";
    $params = array($name, $description);
    $types = 'ss';
    $res = bd_interaction($query, $params, $types);
    if ($res['status'] == 1)
    admin_lessons();
}

function edit_lesson()
{
    $input = $GLOBALS['input'];
    $id = isset($input['id']) ? $input['id'] : "";
    $query = "Select id_lesson, name, description From lessons Where id_lesson = $id";
    $context = LoadDataFromDB($query);
    $editView = new moldmaker('Lesson', 'Редактировать тему', 'update_lesson');
    $editView->EditView($context, $unique_key = 'id_lesson');
}

function update_lesson()
{
    $input = $GLOBALS['input'];
    if (!isset($input["unique_id"])) return;

    $id = isset($input['unique_id']) ? $input['unique_id'] : "";
    $name = isset($input['name']) ? $input['name'] : "";
    $description = isset($input['description']) ? $input['description'] : "";
    $query = 'Update lessons SET name = ?, description = ? Where id_lesson = ?';
    $params = array($name, $description, $id);
    $types = 'ssi';
    $res = bd_interaction($query, $params, $types);
    if ($res["status"] == 1) admin_lessons();
}

// добавляем тесты
function admin_tests()
{
    $query = "Select t.id_task, t.rus_name, l.description lesson, c.name category 
		From task t
		INNER JOIN lessons l on l.id_lesson = t.id_lesson
		INNER JOIN category c on c.id_category = t.id_category
		ORDER BY t.id_lesson, t.id_task";
    $context = LoadDataFromDB($query);
    $render = new Render("templates/tests.php", $context);
    return $render->renderPage();
}

function test_add()
{
    $query_category = "Select id_category, name From category";
    $categories = LoadDataFromDB($query_category);
    $query_lessons = "Select id_lesson, description From lessons";
    $lessons = LoadDataFromDB($query_lessons);
    $context['categories'] = $categories;
    $context['lessons'] = $lessons;
    $render = new Render("templates/add_test.php", $context);
    return $render->renderPage();
}

//Сохранение тестов в бд
function save_test()
{
    $input = $GLOBALS['input'];
    $name = isset($input['name']) ? $input['name'] : "";
    $rus_name = isset($input['rus_name']) ? $input['rus_name'] : "";
    $text = isset($input['editor1']) ? $input['editor1'] : "";
    $category = isset($input['category']) ? $input['category'] : "";
    $text_min = isset($input['text_min']) ? $input['text_min'] : "";
    $lesson = isset($input['lesson']) ? $input['lesson'] : "";
    if (!file_exists("data/code_templates/"))
    mkdir("data/code_templates", 777);

    if (!file_exists("data/code_templates/" . $name . "/"))
    mkdir("data/code_templates/" . $name . "/", 777);

    //Обработка файлов
    $uploaddir = "data/code_templates/" . $name . "/";
    //код на си
    $c_link = '';
    $csharp_link = '';
    $file_name = AddFunc::translit($input['c-files']['name']);
    $uploadfile = $uploaddir . basename($file_name);
    if (move_uploaded_file($input['c-files']['tmp_name'], $uploadfile)) {
        $c_link = $uploaddir . 'c/';
        $zip = new ZipArchive;
        $res = $zip->open($uploadfile);
        if ($res === true) {
            $zip->extractTo($uploaddir);
            $zip->close();
            AddFunc::delete_file($uploadfile);
        }
    }
    //код на шарпе
    $file_name2 = AddFunc::translit($input['csharp-files']['name']);
    $uploadfile2 = $uploaddir . basename($file_name2);
    if (move_uploaded_file($input['csharp-files']['tmp_name'], $uploadfile2)) {
        $csharp_link = $uploaddir . 'sharp/';
        $zip = new ZipArchive;
        $res = $zip->open($uploadfile2);
        if ($res === true) {
            $zip->extractTo($uploaddir);
            $zip->close();
            AddFunc::delete_file($uploadfile2);
        }
    }

    $insert_query = "Insert Into task (name, rus_name, text, id_category, tex_min, id_lesson) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($name, $rus_name, $text, $category, $text_min, $lesson);
    $types = 'sssisi';
    $res = bd_interaction($insert_query, $params, $types);
    if ($res["status"] == 1) {
        $sel_query = 'Select id_task From task ORDER BY id_task desc limit 1';
        $data = LoadDataFromDB($sel_query);
        $id_task = $data['data'][0]['id_task'];
        //Добавляем пути к файлам в бд
        $c_query = "Insert Into task_lang (id_task, id_lang, template_link_folder_code) VALUES (?, 1, ?)";
        $c_params = array($id_task, $c_link);
        $c_types = 'is';
        bd_interaction($c_query, $c_params, $c_types);

        $csharp_query = "Insert Into task_lang (id_task, id_lang, template_link_folder_code) VALUES (?, 2, ?)";
        $csharp_params = array($id_task, $csharp_link);
        $csharp_types = 'is';
        bd_interaction($csharp_query, $csharp_params, $csharp_types);

        loadStart($GLOBALS['str']);
    }
}

/** Редактирование существующего теста */
function edit_test()
{
    $input = $GLOBALS['input'];
    $id = isset($input['id']) ? $input['id'] : "";

    $query = "SELECT id_task, name, rus_name, text, tex_min, id_category, id_lesson From task WHERE id_task = " . $id;
    $tasks = LoadDataFromDB($query);
    $context['task'] = $tasks;
    $query_category = "SELECT id_category, name From category";
    $categories = LoadDataFromDB($query_category);
    $context['categories'] = $categories;
    $query_lessons = "Select id_lesson, description From lessons";
    $lessons = LoadDataFromDB($query_lessons);
    $context['lessons'] = $lessons;

    $render = new Render("templates/edit_test.php", $context);
    return $render->renderPage();
}

function update_test()
{
    $input = $GLOBALS['input'];

    $need_update_c = isset($input['need_update_c']) ? $input['need_update_c'] : "off";
    $need_update_csharp = isset($input['need_update_csharp']) ? $input['need_update_csharp'] : "off";

    $name = isset($input['name']) ? $input['name'] : "";
    $old_name = isset($input['old_name']) ? $input['old_name'] : "";
    $rus_name = isset($input['rus_name']) ? $input['rus_name'] : "";
    $text = isset($input['editor1']) ? $input['editor1'] : "";
    $category = isset($input['category']) ? $input['category'] : "";
    $text_min = isset($input['text_min']) ? $input['text_min'] : "";
    $lesson = isset($input['lesson']) ? $input['lesson'] : "";
    $id_task = isset($input['id_task']) ? $input['id_task'] : "";

    $insert_query = "Update task SET name = ?, rus_name = ?, text = ?, id_category = ?, tex_min = ?, id_lesson = ? Where id_task = ?";
    $params = array($name, $rus_name, $text, $category, $text_min, $lesson, $id_task);
    $types = 'sssisii';
    $res = bd_interaction($insert_query, $params, $types);

    $uploaddir = "data/code_templates/" . $name . "/";
    $old_dir = "data/code_templates/" . $old_name . "/";

    /** Обновляем имя корневой папки теста */
    if (!file_exists($uploaddir))
    {
        if ($uploaddir != $old_dir)
            rename($old_dir, $uploaddir);
    }

    if ($need_update_c == "on") {
        if ($input['c-files']['name'] == "") {
            //Удаляем файлы и запись в бд
            $c_sel_query = "SELECT template_link_folder_code FROM task_lang WHERE id_task = " . $id_task . " and id_lang = 1";
            $c_files = LoadDataFromDB($c_sel_query);
            $c_del_quer = "DELETE FROM task_lang WHERE id_task = ? and id_lang = 1";
            $c_params = array($id_task);
            $c_types = 'i';
            bd_interaction($c_del_quer, $c_params, $c_types);
            AddFunc::delete_directory(substr($c_files['data'][0]['template_link_folder_code'], 0, -1));
        } else {
            //Обновляем файлы в папках и в таблице
            if (!file_exists("data/code_templates/" . $name . "/"))
            mkdir("data/code_templates/" . $name . "/", 777);

            $file_name = AddFunc::translit($input['c-files']['name']);
            $uploadfile = $uploaddir . basename($file_name);
            if (move_uploaded_file($input['c-files']['tmp_name'], $uploadfile)) {
                $c_link = $uploaddir . 'c/';
                $zip = new ZipArchive;
                $res = $zip->open($uploadfile);
                if ($res === true) {
                    $zip->extractTo($uploaddir);
                    $zip->close();
                    AddFunc::delete_file($uploadfile);

                    $check_query = "SELECT count(*) as counter FROM task_lang WHERE id_lang = 1 AND id_task = " . $id_task;
                    $d1 = LoadDataFromDB($check_query);
                    if ($d1['data'][0]['counter'] > 0) {
                        $c_query = "UPDATE task_lang SET template_link_folder_code = ? WHERE id_lang = 1 and id_task = ?";
                        $c_params = array($c_link, $id_task);
                        $c_types = 'si';
                        bd_interaction($c_query, $c_params, $c_types);
                    } else {
                        $c_query = "Insert Into task_lang (id_task, id_lang, template_link_folder_code) VALUES (?, 1, ?)";
                        $c_params = array($id_task, $c_link);
                        $c_types = 'is';
                        bd_interaction($c_query, $c_params, $c_types);
                    }
                }
            }
        }
    }
    if ($need_update_csharp == "on") {
        if ($input['csharp-files']['name'] == "") {
            //Удаляем файлы и запись в бд
            $csharp_sel_query = "SELECT template_link_folder_code FROM task_lang WHERE id_task = " . $id_task . " and id_lang = 2";
            $csharp_files = LoadDataFromDB($csharp_sel_query);
            $csharp_del_quer = "DELETE FROM task_lang WHERE id_task = ? and id_lang = 2";
            $csharp_params = array($id_task);
            $csharp_types = 'i';
            bd_interaction($csharp_del_quer, $csharp_params, $csharp_types);
            AddFunc::delete_directory(substr($csharp_files['data'][0]['template_link_folder_code'], 0, -1));
        } else {
            //Обновляем файлы в папках и в таблице
            if (!file_exists("data/code_templates/" . $name . "/"))
            mkdir("data/code_templates/" . $name . "/", 777);

            $file_name = AddFunc::translit($input['csharp-files']['name']);
            $uploadfile = $uploaddir . basename($file_name);
            if (move_uploaded_file($input['csharp-files']['tmp_name'], $uploadfile)) {
                $csharp_link = $uploaddir . 'sharp/';
                $zip = new ZipArchive;
                $res = $zip->open($uploadfile);
                if ($res === true) {
                    $zip->extractTo($uploaddir);
                    $zip->close();
                    AddFunc::delete_file($uploadfile);

                    $check_query = "SELECT count(*) as counter FROM task_lang WHERE id_lang = 2 AND id_task = " . $id_task;
                    $d1 = LoadDataFromDB($check_query);
                    if ($d1['data'][0]['counter'] > 0) {
                        $csharp_query = "UPDATE task_lang SET template_link_folder_code = ? WHERE id_lang = 2 and id_task = ?";
                        $csharp_params = array($csharp_link, $id_task);
                        $csharp_types = 'si';
                        bd_interaction($csharp_query, $csharp_params, $csharp_types);
                    } else {
                        $csharp_query = "Insert Into task_lang (id_task, id_lang, template_link_folder_code) VALUES (?, 2, ?)";
                        $csharp_params = array($id_task, $csharp_link);
                        $csharp_types = 'is';
                        bd_interaction($csharp_query, $csharp_params, $csharp_types);
                    }
                }
            }
        }
    }

    $dir = "data/code_templates/" . $name . "/";
    if (AddFunc::countDir($dir) == 0) {
        AddFunc::delete_directory(substr($dir, 0, -1));
    }

    admin_tests();
}

function download_file()
{
    $input = $GLOBALS['input'];

    $path = isset($input['path']) ? $input['path'] : "";
    $name = isset($input['name']) ? $input['name'] : "";

    $dir = $path . $name;
    $destination = $path . $name . '.zip';

    AddFunc::toZip($destination, $dir);

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $name . '.zip"');
    readfile($destination);

    if (file_exists($destination))
    AddFunc::delete_file($destination);
}

function del_file()
{
    $input = $GLOBALS['input'];

    $path = isset($input['path']) ? $input['path'] : "";
    $name = isset($input['name']) ? $input['name'] : "";

    $dir = $path . $name;

    AddFunc::delete_directory($dir);

    if (AddFunc::countDir($path) == 0) {
        AddFunc::delete_directory(substr($path, 0, -1));
    }
    go_back(-1);
}

function admin_users()
{
    $query = "Select id_polzov id, name login, role From polzov Order By id_polzov";
    $context = LoadDataFromDB($query);

    if ($context["status"] == 1) {
        $render = new Render("templates/users.php", $context);
        return $render->renderPage();
    } else {
        echo 'Возникли ошибки в ходе выполнения запроса';
    }
}

function go_back($step = -2)
{
    echo '<script>window.history.go(' . $step . ');</script>';
}

/** Подтверждение удаления */
function DeleteConfirmation()
{
    $input = $GLOBALS['input'];
    $id = isset($input['id']) ? $input['id'] : "";
    $act = isset($input['act']) ? $input['act'] : "";
    $name = isset($input['name']) ? $input['name'] : "имя не установлено";
    $context = ["id" => $id, "act" => $act, "name" => $name];
    $render = new Render("templates/delete_view.php", $context);
    return $render->renderPage();
}
/** Удалить */
function Delete()
{
    $input = $GLOBALS['input'];
    $id = isset($input['id']) ? $input['id'] : "";
    $from = isset($input['from']) ? $input['from'] : "";
    $pass = 0;

    switch ($from) {
        case "del_users":
            $query = "Delete From polzov Where id_polzov = ?";
            break;
        case "del_category":
            $query = "Delete From category Where id_category = ?";
            break;
        case "del_lesson":
            $query = "Delete From lessons Where id_lesson = ?";
            break;
        case "del_test":
            Del_Test($id);
            $pass = 1;
            break;
    }
    if ($pass == 0) {
        $params = array($id);
        $types = 'i';
        bd_interaction($query, $params, $types);
    }
    switch ($from) {
        case "del_users":
            admin_users();
        case "del_category":
            admin_categories();
        case "del_lesson":
            admin_lessons();
        case "del_test":
            admin_tests();
    }
}

function Del_Test($id)
{
    $query = "SELECT name FROM task WHERE id_task = " . $id;
    $data = LoadDataFromDB($query);
    $name = $data['data'][0]['name'];

    $dir = 'data/code_templates/' . $name;
    $query_del1 = "DELETE FROM task WHERE id_task = ?";
    $params1 = array($id);
    $types1 = 'i';
    bd_interaction($query_del1, $params1, $types1);

    $query_del2 = "DELETE FROM task_lang WHERE id_task = ?";
    $params2 = array($id);
    $types2 = 'i';
    bd_interaction($query_del2, $params2, $types2);

    AddFunc::delete_directory($dir);

    return true;
}
/** АДМИНКА КОНЕЦ */

//создание файловой структуры пользовательских папок
function create_file_structure($name, $loc)
{
    switch ($loc) {
        case "users":
            mkdir("data/users/$name", 777);
            break;
    }
}

/** ОПЕРАЦИИ С БД */
// выборка из бд
function LoadDataFromDB($query)
{
    if ($query == "")
    return;

    $CONN = $GLOBALS["ConDB"]->connect();
    $mySqlCommand = new MySQLCommand($CONN, $query);
    $context = $mySqlCommand->requestExecute();

    return $context;
}

/** Вставка, удаление, обновление */
function bd_interaction($query, $params, $types)
{
    $CONN = $GLOBALS["ConDB"]->connect();
    $mySqlCommand = new MySQLCommand($CONN, $query, "non_query", $params, $types);
    $cmd = $mySqlCommand->requestExecute();

    return $cmd;
}
/** КОНЕЦ ОПЕРАЦИИ С БД */
 

<?php

if (!extension_loaded('zip')) {
	echo '<script>alert("Не загружено расширение ZIP!")</script>';
}

/** Класс отрисовки страниц */
include("classes/render/render.php");
/** класс работы с базой mysql */
include("classes/mysqli/MySqlConnection.php");
/** Подключение к бд */
require_once("classes/ssa/ConnectDb.php");

/** Генератор форм */
include("classes/ssa/moldmaker.php");

/** Дополнительные функции */
include("classes/ssa/AdditionalFunc.php");

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
	$context = LoadDataFromDB($query);
	$render = new Render("templates/start_page.php", $context);
	return $render->renderPage();
}

/** Загрузка заданий по уроку */
function load_task_list_to_main_content($str)
{
	$input = $GLOBALS['input'];
	$id_lesson = isset($input['id']) ? $input['id'] : "";
	$query = $str . " Where t.id_lesson=$id_lesson Order by t.id_task";
	$context = LoadDataFromDB($query);
	$render = new Render("templates/start_page.php", $context);
	return $render->renderPage();
}

function loadBase()
{
	if (!isset($_SESSION['login'])) {
		$render = new Render("service_files/please_login.php");
		return $render->renderPage();
	}
	$input = $GLOBALS['input'];
	$task_name = isset($input['task_name']) ? $input['task_name'] : "";
	
	/*Корпирование директории*/
	$dir = "data/users/" . $_SESSION['login'] . "/" . $task_name;
	copydirect("data/code_templates/" . $task_name, $dir, 1);

	$query = "Select rus_name, tex_min, text, name, id_task From task";
	$context['bd'] = LoadDataFromDB($query);

	$snippet = "data/code_templates/" . $task_name . "/c/org_snippet";
	if (file_exists($snippet))
		$context['code'] = file_get_contents($snippet);
	$render = new Render("templates/main.php", $context, "standalone"); 						//~standalone			
	return $render->renderPage();
}

//смена языка
function change_lang()
{
	$input = $GLOBALS['input'];
	$lang = isset($input['lang']) ? $input['lang'] : "";

	switch ($lang) {
		case "c":
			$code = file_get_contents("data/code_templates/cyclic_rotation/c/org_snippet");
			break;
		case "sharp":
			$code = file_get_contents("data/code_templates/cyclic_rotation/sharp/org_snippet");
			break;
		default:
			$code = file_get_contents("data/code_templates/cyclic_rotation/c/org_snippet");
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

	$root_path = "data/users/" . $_SESSION['login'] . "/" . $task_name . "/" . $lang . "/";
	switch ($val) {
		case "example":
			compile_example_test($code, $lang, $task_name, $root_path);
			break;

		case "extend":
			compile_extend_test($code, $lang, $task_name, $root_path);
			break;
	}
}

function compile_example_test($code, $lang, $task_name, $root_path)
{
	if ($lang == "c") {
		// $ext = "c";
		// $tail_test_example = '_test_example.'.$lang;
		$file_examle_test = $root_path . $task_name . '_test_example.c';

		clean_file($root_path . 'done_code.c');
		file_put_contents($root_path . 'done_code.c', file_get_contents($file_examle_test) . $code);
		
		// gcc cyclic_rotation_test_example.c general.c -lm -o example
		clean_file($root_path . 'done_test.out');
		$output = passthru("sh -c 'gcc " . $root_path . "done_code.c " . $root_path . "general.c -lm -o " . $root_path . "done_test.out 2>&1'", $ret_val);
		
		// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
		
		/* не удачная компиляция */
		if ($ret_val == 1) {
			// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
			echo "Ошибка компиляции\n\n";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) {
			echo "Успешная компиляция\n\n";

			$output = passthru("sh -c '" . $root_path . "./done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

	if ($lang == "sharp") {
		// mcs -out:done_test.out cyclic_rotation_test_example.cs cyclic_rotation_test.cs general.cs
		$file_examle_test = $root_path . $task_name . '_test_example.cs';

		clean_file($root_path . 'done_code.cs');
		file_put_contents($root_path . 'done_code.cs', file_get_contents($file_examle_test) . $code);

		clean_file($root_path . 'done_test.out');
		$output = passthru("sh -c 'mcs -out:" . $root_path . "done_test.out " . $root_path . "done_code.cs " . $root_path . $task_name . "_test.cs " . $root_path . "general.cs  2>&1'", $ret_val);
		
		/* не удачная компиляция */
		if ($ret_val == 1) {
			// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
			echo "Ошибка компиляции\n\n";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) {
			echo "Успешная компиляция\n\n";

			$output = passthru("sh -c 'mono " . $root_path . "done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

}

function compile_extend_test($code, $lang, $task_name, $root_path)
{
	if ($lang == "c") {
		$file_extend_test = $root_path . $task_name . '_test_extend.c';

		clean_file($root_path . 'done_code.c');
		file_put_contents($root_path . 'done_code.c', file_get_contents($file_extend_test) . $code);

		clean_file($root_path . 'done_test.out');
		$output = passthru("sh -c 'gcc " . $root_path . "done_code.c " . $root_path . "general.c -lm -o " . $root_path . "done_test.out 2>&1'", $ret_val);
		
		// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
		
		/* не удачная компиляция */
		if ($ret_val == 1) {
			echo "error|";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) {
			$output = passthru("sh -c '" . $root_path . "./done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

	if ($lang == "sharp") {
		// mcs -out:done_test.out cyclic_rotation_test_example.cs cyclic_rotation_test.cs general.cs
		$file_extend_test = $root_path . $task_name . '_test_extend.cs';

		clean_file($root_path . 'done_code.cs');
		file_put_contents($root_path . 'done_code.cs', file_get_contents($file_extend_test) . $code);

		clean_file($root_path . 'done_test.out');
		$output = passthru("sh -c 'mcs -out:" . $root_path . "done_test.out " . $root_path . "done_code.cs " . $root_path . $task_name . "_test.cs " . $root_path . "general.cs  2>&1'", $ret_val);
		
		/* не удачная компиляция */
		if ($ret_val == 1) {
			echo "error|";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) {
			$output = passthru("sh -c 'mono " . $root_path . "done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

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

//Ф-ция в которую будут получены результаты
function get_result()
{
//     Первое занчени {0 - example, 1 - correct, 2 - perform} | Наименование теста | подсказка для теста | пройден ли тест (0 - непройден или 1) | Консольный вывод
	$str_result = "
0 | example1 | first example test | 0 | WRONG ANSWER (got [0, 0, 0, 0, 0] expected [9, 7, 6, 3, 8]) |

0 | example2 | second example test | 0 | WRONG ANSWER (got [0, 0, 4195958] expected [0, 0, 0]) |

0 | example3 | third example test | 1 | OK |
 
1 | extreme_empty | empty array | 1 | OK |

1 | single | one element, 0 <= K <= 5 | 1 | OK |

1 | single | one element, 0 <= K <= 5 | 1 | OK |

1 | single | one element, 0 <= K <= 5 | 1 | OK |

1 | double | two elements, K <= N | 0 | WRONG ANSWER (got [-1000, 0] expected [-1000, 5]) |

1 | double | two elements, K <= N | 1 | OK |

1 | small1 | small functional tests, K < N | 0 | WRONG ANSWER (got [4195958, 0, 612122896, 2, 0, 0, 4195958] expected [6, 7, 1, 2, 3, 4, 5]) |

1 | small1 | small functional tests, K < N | 0 | WRONG ANSWER (got [4195958, 0, 612122896, 7, 0, 0, 4195958] expected [-2, -3, -4, -5, -6, -7, -1]) |

1 | small2 | small functional tests, K >= N | 0 | WRONG ANSWER (got [4195958, 0, 612122896, 7, 0, 0, 4195958] expected [1, 2, 3, 4, 5, 6, 7]) |

1 | small2 | small functional tests, K >= N | 0 | WRONG ANSWER (got [0, 0, 612122896, 7, 0, 0] expected [-3, -4, -5, -6, -1, -2]) |

1 | small2 | small functional tests, K >= N | 1 | OK |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [9, 0, 4196206, 5, -445856448, 32765, -445856416, 32765, 0, 0, 612122896, 5, 0, 0, 4195958] expected [9, 1, -1, 8, 6, 7, 4, 4, 1, -8, 5, 9, -3, -1, 0]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445856384, 15, -445856320, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [6, 10, -7, 1, 4, -6, 6, -7, 9, 4, 3, 4, 9, 4, -8]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445856256, 15, -445856192, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [0, -4, -9, -5, 2, 8, 5, 5, 9, 2, 4, -7, -3, 5, 6]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445856128, 15, -445856064, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [-4, 7, 0, -9, 1, -2, 7, 10, -1, 10, 10, 10, 3, -8, -9]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445856000, 15, -445855936, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [-2, 5, 9, 4, 10, 7, -9, -6, 10, 3, 3, 10, 3, 0, 4]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855872, 15, -445855808, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [8, -5, -4, 7, -4, 1, -9, 0, 3, -2, -2, -5, -2, -7, 1]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855744, 15, -445855680, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [1, -5, -9, 8, 1, -1, 9, 5, 9, -4, -8, -6, 5, 4, -8]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855616, 15, -445855552, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [0, 4, 9, 6, -5, 6, -8, 2, 9, -4, 10, 0, -7, 6, -8]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855488, 15, -445855424, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [-4, 10, -8, -1, 2, -8, 10, 0, -6, 6, -1, -9, 7, -5, -6]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855360, 15, -445855296, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [-6, 8, -7, 3, 9, 5, -8, -2, 10, 7, 2, 6, 1, -1, -7]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855232, 15, -445855168, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [10, 2, 8, 10, 1, -1, 7, 7, 0, -9, -9, -9, -5, 0, 1]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445855104, 15, -445855040, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [7, -4, 7, -9, 7, -1, -7, -5, 5, 6, 8, -6, -8, 1, 4]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445854976, 15, -445854912, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [-4, 3, 6, -4, 7, -6, -6, -3, -8, -9, 3, -6, 10, -5, 3]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 0 | WRONG ANSWER (got [4195958, 0, 4196206, 0, -445854848, 15, -445854784, 32765, 0, 0, 612122896, 15, 0, 0, 4195958] expected [9, 10, 2, 0, 10, 5, 3, 4, 4, -5, -9, -7, 9, -6, 5]) |

1 | small_random_all_rotations | small random sequence, all rotations, N = 15 | 1 | OK |

1 | medium_random | medium random sequence, N = 100 | 0 | WRONG ANSWER (got [15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 905969664, 959525937, 892418357, 1538883328, -1848235966, 0, 0, 0, 0, 4195520, 0, -445851024, 32765, 0, 822083584, 1538883328, -1848235966, -445858592, 32765, 0, 0, 4195520, 0, -445851024, 32765, 0, 0, 0, 0, -445858544, 32765, 606315894, 32718, 8, 48, -445858576, 32765, -445858768, 32765, 1538883328, -1848235966, 0, 0, 31776, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 612122896, 32718, 0, 0, 4196206, 15, -445854592, 32765, -445854528, 32765, 0, 0, 612122896, 15] expected [-126, -836, 2, 280, -112, 84, -996, -368, 408, 969, -671, 785, -161, -240, -524, -338, -595, 642, -938, 441, -963, -265, 209, 93, -988, 604, -669, 122, -530, 284, -28, 344, 5, 531, -820, 894, -829, -816, -475, 579, 711, -589, -80, -451, 171, 396, -232, 134, 37, -169, -94, 620, 201, 395, 215, -526, 579, 833, 231, 715, -267, -340, -839, -374, 68, -282, -85, 273, -702, -993, 211, 152, -594, 167, -475, -276, 745, -677, -593, 697, -623, 314, -126, 135, -735, 646, 609, 401, 479, -604, 116, -789, 56, 277, -606, 681, 553, 310, -47, 851]) |

1 | medium_random | medium random sequence, N = 100 | 0 | WRONG ANSWER (got [100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 909180928, 842084913, 825571378, 1538883328, -1848235966, 0, 0, 0, 0, 4195520, 0, -445851024, 32765, 0, 0, 0, 0, -445858592, 32765, 606315894, 32718, 16, 48, -445858624, 32765, -445858816, 32765, 1538883328, -1848235966, -445858544, 32765, 851, 0, 396, 0, 0, 0, 0, 0, 0, 0, 0, 0, 93, 0, 609851520, 32718, 0, 0, 93, 0, 611927232, 32718, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 612122896, 32718, 0, 0, 4196206, 0, -445854464, 100, -445854064, 32765, 0, 0, 612122896, 100] expected [-51, 795, -130, 34, 140, 886, 946, -82, 611, -827, -901, 199, -547, -195, 121, 173, -368, 260, -810, -80, -727, -480, -664, -804, 815, 857, -476, -286, -350, -454, 274, 599, -660, -857, -811, 37, 586, 692, 955, 197, 866, -946, -605, 876, -584, 516, -395, 48, -225, -205, 525, 49, 316, 861, -198, -313, 274, 326, 402, 925, 429, -325, 80, 327, -624, -173, -637, 962, -925, -682, -285, 498, 930, 111, 373, 355, -779, -832, -329, 625, -969, -721, -295, 922, -280, -730, -418, 460, -713, 14, -227, 860, 923, 295, 521, -672, 343, 237, -979, 3]) |

1 | medium_random | medium random sequence, N = 100 | 0 | WRONG ANSWER (got [100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 909180928, 842084913, 859257138, 1538883328, -1848235966, 0, 0, 0, 0, 4195520, 0, -445851024, 32765, 0, 0, 0, 0, -445858592, 32765, 606315894, 32718, 16, 48, -445858624, 32765, -445858816, 32765, 1538883328, -1848235966, -445858544, 32765, 3, 0, 396, 0, 0, 0, 0, 0, 0, 0, 0, 0, 93, 0, 609851520, 32718, 0, 0, 93, 0, 611927232, 32718, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 612122896, 32718, 0, 0, 4196206, 0, -445853664, 100, -445853264, 32765, 0, 0, 612122896, 100] expected [-51, 795, -130, 34, 140, 886, 946, -82, 611, -827, -901, 199, -547, -195, 121, 173, -368, 260, -810, -80, -727, -480, -664, -804, 815, 857, -476, -286, -350, -454, 274, 599, -660, -857, -811, 37, 586, 692, 955, 197, 866, -946, -605, 876, -584, 516, -395, 48, -225, -205, 525, 49, 316, 861, -198, -313, 274, 326, 402, 925, 429, -325, 80, 327, -624, -173, -637, 962, -925, -682, -285, 498, 930, 111, 373, 355, -779, -832, -329, 625, -969, -721, -295, 922, -280, -730, -418, 460, -713, 14, -227, 860, 923, 295, 521, -672, 343, 237, -979, 3]) |";

	$render = new Render("templates\\results.php", $str_result);
	return $render->renderPage();

}

/** АДМИНКА 																					*****************/
/** Разбираемся с категориями сложности и темами */
function admin_categories()
{
	$query = "Select * From category";
	$context = LoadDataFromDB($query);
	$render = new Render("templates\categories.php", $context);
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
	$render = new Render("templates\lessons.php", $context);
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
			delete_file($uploadfile);
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
			delete_file($uploadfile2);
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
		//Добавляем пути к файла в бд
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
	if ($need_update_c == "on") {
		if ($input['c-files']['name'] == "") {
			//Удаляем файлы и запись в бд
			$c_sel_query = "SELECT template_link_folder_code FROM task_lang WHERE id_task = " . $id_task . " and id_lang = 1";
			$c_files = LoadDataFromDB($c_sel_query);
			$c_del_quer = "DELETE FROM task_lang WHERE id_task = ? and id_lang = 1";
			$c_params = array($id_task);
			$c_types = 'i';
			bd_interaction($c_del_quer, $c_params, $c_types);
			delete_directory(substr($c_files['data'][0]['template_link_folder_code'], 0, -1));
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
					delete_file($uploadfile);

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
			delete_directory(substr($csharp_files['data'][0]['template_link_folder_code'], 0, -1));
		} else {
			//Обновляем файлы в папках и в таблице
			if (!file_exists("data/code_templates/" . $name . "/"))
				mkdir("data/code_templates" . $name . "/", 777);

			$file_name = AddFunc::translit($input['csharp-files']['name']);
			$uploadfile = $uploaddir . basename($file_name);
			if (move_uploaded_file($input['csharp-files']['tmp_name'], $uploadfile)) {
				$csharp_link = $uploaddir . 'sharp/';
				$zip = new ZipArchive;
				$res = $zip->open($uploadfile);
				if ($res === true) {
					$zip->extractTo($uploaddir);
					$zip->close();
					delete_file($uploadfile);

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
	if (countDir($dir) == 0) {
		delete_directory(substr($dir, 0, -1));
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

	toZip($destination, $dir);

	header('Content-Type: application/zip');
	header('Content-Disposition: attachment; filename="' . $name . '.zip"');
	readfile($destination);

	if (file_exists($destination))
		delete_file($destination);
}

function del_file()
{
	$input = $GLOBALS['input'];

	$path = isset($input['path']) ? $input['path'] : "";
	$name = isset($input['name']) ? $input['name'] : "";

	$dir = $path . $name;

	delete_directory($dir);

	if (countDir($path) == 0) {
		delete_directory(substr($path, 0, -1));
	}
	echo '<script>window.history.back();</script>';
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
	}
	$params = array($id);
	$types = 'i';
	bd_interaction($query, $params, $types);
	switch ($from) {
		case "del_users":
			admin_users();
		case "del_category":
			admin_categories();
		case "del_lesson":
			admin_lessons();
	}
}
/** АДМИНКА КОНЕЦ */

/***  ДЕЙСТВИЯ С ФАЙЛАМИ И ДИРЕКТОРИЯМИ                                                         *****************/

/** Упаковать файл в архив */
function toZip($destination, $dir)
{
	$dir = str_replace('\\', '/', realpath($dir));

	$zip = new ZipArchive();
	if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
		return false;
	}

	if (is_dir($dir) === true) {
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);

		foreach ($files as $file) {
			$file = str_replace('\\', '/', $file);
			if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
				continue;

			$file = realpath($file);
			$file = str_replace('\\', '/', $file);

			if (is_dir($file) === true) {
				$zip->addEmptyDir(str_replace($dir . '/', '', $file . '/'));
			} else if (is_file($file) === true) {
				$zip->addFromString(str_replace($dir . '/', '', $file), file_get_contents($file));
			}
		}
	}

	return $zip->close();
}

/** Посчитать кол-во директорий */
function countDir($dir)
{
	$i = 0;
	$dir_list = scandir($dir);
	foreach ($dir_list as $d) {
		if ($d != '.' && $d != '..') {
			$i++;
		}
	}
	return $i;
}

/** КОПИРОВАНИЕ ДИРЕКТОРИЙ */
function copydirect($source, $dest, $over = false)
{
	if (!is_dir($dest))
		mkdir($dest);
	if ($handle = opendir($source)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				$path = $source . '/' . $file;
				if (is_file($path)) {
					if (!is_file($dest . '/' . $file || $over))
						if (!@copy($path, $dest . '/' . $file)) {
						echo "('.$path.') Ошибка!!! ";
					}
				} elseif (is_dir($path)) {
					if (!is_dir($dest . '/' . $file))
						mkdir($dest . '/' . $file);
					copydirect($path, $dest . '/' . $file, $over);
				}
			}
		}
		closedir($handle);
	}
}

//создание файловой структуры пользовательских папок
function create_file_structure($name, $loc)
{
	switch ($loc) {
		case "users":
			mkdir("data/users/$name", 777);
			break;
	}
}

// удалить существующий файл
function delete_file($filename)
{
	if (file_exists($filename)) {
		unlink($filename);
	}
}

// удаление директории
function delete_directory($dir)
{
	if (!file_exists($dir)) {
		return true;
	}

	if (!is_dir($dir)) {
		return unlink($dir);
	}

	foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') {
			continue;
		}

		if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
			return false;
		}

	}

	return rmdir($dir);
}

// очистить существующий файл
function clean_file($filename)
{
	if (file_exists($filename)) {
		file_put_contents($filename, "");
	}
}
/***  ДЕЙСТВИЯ С ФАЙЛАМИ И ДИРЕКТОРИЯМИ КОНЕЦ   */

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
?>

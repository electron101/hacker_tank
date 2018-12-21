<?php

/** Генератор форм */
include ("classes/ssa/moldmaker.php");

/** Основные функции */
function loadStart()
{
	$query = "Select * From lessons order by id_lesson";
	$context = LoadDataFromDB($query);
    $render = new Render("templates/start_page.php", $context);
	return $render -> renderPage();
}

/** Загрузка заданий по уроку */
function load_tasks()
{
	$input = $GLOBALS['input'];
	$id_lesson = isset($input['subj']) ? $input['subj'] : "";
	$query = "Select t.id_lesson, t.id_task, t.name as task_name, c.name, l.description, t.tex_min, l.name as lesson_name From task as t
		Inner Join lessons as l On l.id_lesson = t.id_lesson
		Inner Join category as c On c.id_category = t.id_category
		Where t.id_lesson=$id_lesson Order by t.id_task";
	$context = LoadDataFromDB($query);


	$html = '<div class="box box-solid">';
	$html .= '<div class="box-header with-border">';
	$html .= '<h3 class="box-title">'.$context['data'][0]['description'].'</h3>';
	$html .= '<div class="box-tools">';
	$html .=  '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>';
	$html .= '</button>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="box-body no-padding">';
	if (isset($context['data'][0]['id_task']))
	{
		$html .= '<ul class="nav nav-pills nav-stacked">';
			for ($i=0; $i<count($context['data']); $i++)
			{
				$html .= '<li class="active"><a href="?act=code&task='.$context['data'][$i]['id_task'].'"><i class="fa fa-circle"></i>';
				$html .=  $context['data'][$i]['tex_min'].' ['.$context['data'][$i]['name'].']</a></li>';
			}
		$html .= '</ul>';
	}
	$html .= '</div>';
	$html .= '</div>';

	echo $html;
}

function loadBase()
{
	if (!isset($_SESSION['login']))
    {
        $render = new Render("service_files/please_login.php");
        return $render -> renderPage();
    }
	$input = $GLOBALS['input'];
	$task_id = isset($input['task']) ? $input['task'] : "";
	$query = "Select tex_min, text, name, id_task From task";
	$context['bd'] = LoadDataFromDB($query);
	$context['code'] = file_get_contents("data/code_templates/cyclic_rotation/c/org_snippet");
    $render = new Render("templates/main.php", $context);
    return $render -> renderPage();
}

//смена языка
function change_lang()
{
	$input = $GLOBALS['input'];
	$lang = isset($input['lang']) ? $input['lang'] : "";

	switch($lang)
	{
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
    return $render -> renderPage();
}

function compile_this()
{
    $input = $GLOBALS['input'];
    $val       = isset($input['val']) ? $input['val'] : "";
    $code      = isset($input['code']) ? $input['code'] : "";
    $lang      = isset($input['lang']) ? $input['lang'] : "";
    $task_name = isset($input['task_name']) ? $input['task_name'] : "";

	$root_path = "data/users/".$_SESSION['login']."/".$task_name."/".$lang."/";
	switch ($val) 
	{
		case "example" :
			compile_example_test($code ,$lang, $task_name, $root_path);
			break;

		case "extend" :
			compile_extend_test($code, $lang, $task_name, $root_path);
			break;
	}
}

function compile_example_test($code, $lang, $task_name, $root_path)
{
	if ($lang == "c")
	{
		// $ext = "c";
		// $tail_test_example = '_test_example.'.$lang;
		$file_examle_test = $root_path.$task_name.'_test_example.c';
		
		clean_file($root_path.'done_code.c');
		file_put_contents($root_path.'done_code.c', file_get_contents($file_examle_test).$code);
		
		// gcc cyclic_rotation_test_example.c general.c -lm -o example
		clean_file($root_path.'done_test.out');
		$output = passthru("sh -c 'gcc ".$root_path."done_code.c ".$root_path."general.c -lm -o ".$root_path."done_test.out 2>&1'", $ret_val);
		
		// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
		
		/* не удачная компиляция */
		if ($ret_val == 1) 
		{
			// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
			echo "Ошибка компиляции\n\n";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) 
		{
			echo "Успешная компиляция\n\n";

			$output = passthru("sh -c '".$root_path."./done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

	if ($lang == "sharp")
	{
		// mcs -out:done_test.out cyclic_rotation_test_example.cs cyclic_rotation_test.cs general.cs
		$file_examle_test = $root_path.$task_name.'_test_example.cs';

		clean_file($root_path.'done_code.cs');
		file_put_contents($root_path.'done_code.cs', file_get_contents($file_examle_test).$code);

		clean_file($root_path.'done_test.out');
		$output = passthru("sh -c 'mcs -out:".$root_path."done_test.out ".$root_path."done_code.cs ".$root_path.$task_name."_test.cs ".$root_path."general.cs  2>&1'", $ret_val);
		
		/* не удачная компиляция */
		if ($ret_val == 1) 
		{
			// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
			echo "Ошибка компиляции\n\n";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) 
		{
			echo "Успешная компиляция\n\n";

			$output = passthru("sh -c 'mono ".$root_path."done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

}

function compile_extend_test($code, $lang, $task_name, $root_path)
{
	if ($lang == "c")
	{
		$file_extend_test = $root_path.$task_name.'_test_extend.c';
		
		clean_file($root_path.'done_code.c');
		file_put_contents($root_path.'done_code.c', file_get_contents($file_extend_test).$code);
		
		clean_file($root_path.'done_test.out');
		$output = passthru("sh -c 'gcc ".$root_path."done_code.c ".$root_path."general.c -lm -o ".$root_path."done_test.out 2>&1'", $ret_val);
		
		// return $result_array = ['ret_val' => $ret_val, 'out_to_console' => $out_to_console];
		
		/* не удачная компиляция */
		if ($ret_val == 1) 
		{
			echo "error|";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) 
		{
			$output = passthru("sh -c '".$root_path."./done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}
	
	if ($lang == "sharp")
	{
		// mcs -out:done_test.out cyclic_rotation_test_example.cs cyclic_rotation_test.cs general.cs
		$file_extend_test = $root_path.$task_name.'_test_extend.cs';
		
		clean_file($root_path.'done_code.cs');
		file_put_contents($root_path.'done_code.cs', file_get_contents($file_extend_test).$code);
		
		clean_file($root_path.'done_test.out');
		$output = passthru("sh -c 'mcs -out:".$root_path."done_test.out ".$root_path."done_code.cs ".$root_path.$task_name."_test.cs ".$root_path."general.cs  2>&1'", $ret_val);
		
		/* не удачная компиляция */
		if ($ret_val == 1) 
		{
			echo "error|";
			echo $output;
			exit();
		}
		/* удачная компиляция */
		if ($ret_val == 0) 
		{
			$output = passthru("sh -c 'mono ".$root_path."done_test.out'", $ret_val);
			echo $output;
			exit();
		}
	}

}

// удалить существующий файл
function delete_file($filename)
{
	if (file_exists($filename))
	{
		unlink($filename);
	}
}

// очистить существующий файл
function clean_file($filename)
{
	if (file_exists($filename))
	{
		file_put_contents($filename, "");
	}
}

// войти
function do_login()
{
    $input = $GLOBALS["input"];
    if (isset($input['login']) && isset($input['password']))
    {
        $login = $input['login'];
        $password = $input['password'];

        $query = "Select id_polzov as id, u.name, u.role From polzov u Where u.name='$login'";
        $context = LoadDataFromDB($query);

        if ($context["status"] == 1 && count($context["data"]) > 0)
        {
            $login = $context["data"][0]["name"];
            $role = $context["data"][0]["role"];
            $id = $context["data"][0]["id"];
            session_variables_create($login, $role, $id);
            loadStart();
        }
        else 
        {
            $render = new Render("service_files/user_not_found.php", $context);
            return $render -> renderPage();
        }
    }
    else return;
}

// регистрация
function register()
{
    $render = new Render("templates/register.php");
    return $render -> renderPage();
}

// обработка данных регистрации
function do_reg()
{
    $input = $GLOBALS["input"];
    $str = isset($input['str']) ? $input['str'] : "";
    $data = array();
    foreach (explode('&', $str) as $val)
    {
        preg_match_all("#([^,\s]+)=([^\*]+)#s",$val,$out);
        unset($out[0]);
        $out = array_combine($out[1], $out[2]);
        $data = array_merge($data, $out);
    }

    $login = isset($data['login']) ? $data['login'] : "";
    $pass = isset($data['pass']) ? $data['pass'] : "";
    $re_pass = isset($data['re_pass']) ? $data['re_pass'] : "";

    if ($pass != $re_pass)
    {
        echo 0;
        exit;
    }

    $query = "Select count(id_polzov) as counter From polzov Where name = '$login'";
    $context = LoadDataFromDB($query);
    if ($context["status"] == 1)
    {
        if ($context["data"][0]["counter"] > 0)
        {
            echo 1;
            exit;
        }
    }

    $query = "Insert Into polzov (name, pas, role) VALUES (?,?,?)";
    $params = array($login, $pass, 1); //1-обычный пользак
    $types = "ssi";

    $res = bd_interaction($query, $params, $types);
    if ($res["status"] != 1)
    {
        echo 2;
        exit;
    }
    else
    {
		create_file_structure($login, 'users');
        echo 1000;
        exit;
    }
}

//создание файловой структуры пользовательских папок
function create_file_structure($name, $loc)
{
	switch($loc)
	{
		case "users":
			// mkdir("data/users/$name", 0700);
			mkdir("data/users/$name", 777);
			break;
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
    loadBase();
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
return $render -> renderPage();

}

/** ОПЕРАЦИИ С БД */
// выборка из бд
function LoadDataFromDB($query)
{
    if ($query == "")
        return;
    
    $CONN = $GLOBALS["CONN"];
    $mySqlCommand = new MySQLCommand($CONN, $query);
    $context = $mySqlCommand -> requestExecute();
    
    return $context;
}

/** Вставка, удаление, обновление */
function bd_interaction($query, $params, $types)
{
    $CONN = $GLOBALS["CONN"];
	$mySqlCommand = new MySQLCommand($CONN, $query, "non_query", $params, $types);
    $cmd = $mySqlCommand -> requestExecute();
    
    return $cmd;
}
/** КОНЕЦ ОПЕРАЦИИ С БД */
?>

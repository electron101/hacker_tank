<?php
 // Отправляем на компиляцию и получаем результат
class Compiler
{

    private $val;
    private $code;
    private $lang;
    private $task_name;

    function __construct($val, $code, $lang, $task_name)
    {
        $this->val = $val;
        $this->code = $code;
        $this->lang = $lang;
        $this->task_name = $task_name;
    }

    function compile()
    {
        $root_path = "data/users/" . $_SESSION['login'] . "/" . $this->task_name . "/" . $this->lang . "/";

        if ($this->val == 'example') {
            $exampleCompile = new ExampleCompile();
            $result = $exampleCompile->run($this->lang, $root_path, $this->task_name, $this->code);
        }

        if ($this->val == 'extend') {
            $extendCompile = new ExtendedCompile();
            $result = $extendCompile->run($this->lang, $root_path, $this->task_name, $this->code);
        }

        return $result;
    }
}

/** Компиляция на тестовом наборе данных */
class ExampleCompile
{

    function run($lang, $root_path, $task_name, $code)
    {

        $file_test = $root_path . $task_name;
        $file_test .= $lang == "c" ? '_test_example.c' : '_test_example.cs';
        $done_code = $lang == "c" ? 'done_code.c' : 'done_code.cs';

        AddFunc::clean_file($root_path . $done_code);
        file_put_contents($root_path . $done_code, file_get_contents($file_test) . $code);
        AddFunc::clean_file($root_path . 'done_test.out');

        if ($lang == 'c')
        $output = passthru("sh -c 'gcc " . $root_path . $done_code . " " . $root_path . "general.c -lm -o " . $root_path . "done_test.out 2>&1'", $ret_val);
        else
        $output = passthru("sh -c 'mcs -out:" . $root_path . "done_test.out " . $root_path . $done_code . " " . $root_path . $task_name . "_test.cs " . $root_path . "general.cs  2>&1'", $ret_val);

        /** Ошибка компиляции */
        if ($ret_val == 1) {
            $result['status'] = 1;
            $result['message'] = "Ошибка компиляции\n\n";
            $result['output'] = $output;
        }

        /** Успешная компиляция */
        if ($ret_val == 0) {
            $result['status'] = 0;
            $result['message'] = "Успешная компиляция\n\n";
            if ($lang == 'c')
            $result['output'] = passthru("sh -c '" . $root_path . "./done_test.out'", $ret_val);
            else
            $result['output'] = passthru("sh -c 'mono " . $root_path . "done_test.out'", $ret_val);
        }

        return $result;
    }
}

/** Компиляция на полном наборе тестов */
class ExtendedCompile
{

    function run($lang, $root_path, $task_name, $code)
    {

        $file_test = $root_path . $task_name;
        $file_test .= $lang == "c" ? '_test_extend.c' : '_test_extend.cs';
        $done_code = $lang == "c" ? 'done_code.c' : 'done_code.cs';

        AddFunc::clean_file($root_path . $done_code);
        file_put_contents($root_path . $done_code, file_get_contents($file_test) . $code);
        AddFunc::clean_file($root_path . 'done_test.out');

        if ($lang == 'c')
        $output = passthru("sh -c 'gcc " . $root_path . $done_code . " " . $root_path . "general.c -lm -o " . $root_path . "done_test.out 2>&1'", $ret_val);
        else
        $output = passthru("sh -c 'mcs -out:" . $root_path . "done_test.out " . $root_path . $done_code . " " . $root_path . $task_name . "_test.cs " . $root_path . "general.cs  2>&1'", $ret_val);

        /** Ошибка компиляции */
        if ($ret_val == 1) {
            $result['status'] = 1;
            $result['message'] = "error|";
            $result['output'] = $output;
        }

        /** Успешная компиляция */
        if ($ret_val == 0) {
            $result['status'] = 0;
            $result['message'] = "Успешная компиляция\n\n";
            if ($lang == 'c')
            $result['output'] = passthru("sh -c '" . $root_path . "./done_test.out'", $ret_val);
            else
            $result['output'] = passthru("sh -c 'mono " . $root_path . "done_test.out'", $ret_val);
        }

        return $result;
    }
}
 
<?php
ini_set('display_errors', 1);
session_start();

if (!extension_loaded('zip')) {
	echo '<script>alert("Не загружено расширение ZIP! Ничего работать не будет!")</script>';
}
/*
Объявляем глобальные переменные, если они нужны
Последовательно подключаем файл настроек, файл функций и
файл обработчика
*/
if (isset($_POST) || isset($_GET) || isset($_FILES)) $input = array_merge($_GET, $_POST, $_FILES);
/** Настройки */
include_once ("settings.php");
/** Загрузчик внешних скриптов */
include_once ("Esl.php");
/** Функции */
include_once ("functions.php");

include_once ("routing.php");
?>
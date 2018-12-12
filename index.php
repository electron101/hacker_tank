<?php
session_start();
/*
Объявляем глобальные переменные, если они нужны
Последовательно подключаем файл настроек, файл рендеринга страниц,
файл для соединения с бд,
файл с функциями, файл маршрутизации
*/

if (isset($_POST) || isset($_GET)) $input = array_merge($_GET, $_POST);

/** Основные файлы */
include ("settings.php");
include ("classes/render/render.php");
include ("classes/mysqli/MySqlConnection.php");
require_once("bdConnect.php");
include ("functions.php");
include ("routing.php");
?>

<?php
/** Подключаемся к базе данных */
$mySqlConnection = new MySqlConnection($GLOBALS["DATABASES"], "MySql");
$CONN = $mySqlConnection -> OpenConnection();
?>
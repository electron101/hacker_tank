<?php
//Настройки подключения к базе
//Пример подключения
// $DATABASES = [
	// "DEFAULT" => [
		// "NAME" => "equipment_test",
		// "HOST" => "s04-sp04",
		// "USER" => "sa",
		// "PASSWORD" => "sa",
		// "CHARSET" => "UTF-8"
	// ]
// ];

$DATABASES = [
	"MySql" => [
		"NAME" => "cod",
		"HOST" => "localhost",
		"USER" => "root",
		"PASSWORD" => "",
		"CHARSET" => "UTF-8"
	]
];

//Базовый файл шаблона
$BASE_FILE = 'base.php';
?>
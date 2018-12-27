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
		"NAME" => "hacker_tank",
		"HOST" => "localhost",
		"USER" => "root",
		"PASSWORD" => "",
		"CHARSET" => "utf8"
	]
];

//Базовый файл шаблона
$BASE_FILE = 'base.php';
?>

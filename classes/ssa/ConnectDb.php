<?php
/** Класс подключения к бд */
class ConnectDB
{
    static function connect()
    {
        /** Подключаемся к базе данных */
        $mySqlConnection = new MySqlConnection($GLOBALS["DATABASES"], "MySql");
        $CONN = $mySqlConnection -> OpenConnection();
        return $CONN;
    }
}
?>
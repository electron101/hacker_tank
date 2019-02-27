<?php
/** Класс, в котором осуществляется инициализация классов обработчиков глобальных массивов POST и SERVER */
include ("router.php");
include ("PostHandler.php");

class Handler
{
    static function init()
    {
        router :: start();
        PostHandler :: start();
    }
}
?>
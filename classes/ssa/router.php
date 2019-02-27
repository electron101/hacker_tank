<?php
/** МАРШРУТИЗАТОР */
class Router
{
    static function start()
    {
        /** Паттерн ссылки: root/action/[variable(s)] */
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        unset($routes[0]);
        /** Корень */
        $root = array_shift($routes);
        /** Действие */
        $action = array_shift($routes);
        /** Переменные */
        $variables = $routes;

        switch($action)
        {
            case "Test":
                load_test($variables);
                break;
        }
    }
}
?>

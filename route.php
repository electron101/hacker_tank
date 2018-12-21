<?php
//Маршрутизватор
class Route
{
    static function start()
    {        
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $action_name = !empty($routes[2]) ? $routes[2] : 'index';

        switch($action_name)
        {
	        case "get_results":
		        get_result();
		        break;
	        case "logout":
		        logout();
		        break;
	        case "login":
		        login();
		        break;
	        // регистрация
	        case "register":
		        register();
		        break;
	        // зарегаться
	        case "do_reg":
		        do_reg();
		        break;
	        case "do_login":
		        do_login();
		        break;
	        case "code":
		        loadBase();
		        break;
	        case "compile_this":
		        compile_this();
		        break;
	        case "change_lang":
		        change_lang();
		        break;
	        case "loadStart":
		        loadStart();
                break;
            case "index":
                loadStart();
                break;
        }
    }
}
?>
<?php
/**
 * Создание подключения к БД mysql
 *  $mySqlConnection = new MySqlConnection($GLOBALS["DATABASES"]);
 *	$CONN = $mySqlConnection -> OpenConnection();
 *	DATABASES - глобальный массив с настройками подключения к бд
 */

 class MySqlConnection
 {
     //Параметры подключения к бд
     var $DATABASES;

     //Указываем какой профиль настроек подтягиваем из settings.php DEFAULT - по умолчанию
     var $DATABASE_PROFILE_NAME;

     function __construct()
     {
        $a = func_get_args();
        $i = func_num_args();
        
        switch($i)
		{
			case 1:
				$this -> DATABASES = $a[0];
				$this -> DATABASE_PROFILE_NAME = "DEFAULT";
				break;
			case 2:
				$this -> DATABASES = $a[0];
				$this -> DATABASE_PROFILE_NAME = $a[1];
				break;
		}
     }

     //Подключаемся к БД
     function OpenConnection()
     {
        $Database = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["NAME"];
        $serverName = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["HOST"];
        $CharacterSet = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["CHARSET"];
		$UID = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["USER"];
        $PWD = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["PASSWORD"];
        
        $conn = mysqli_connect($serverName, $UID, $PWD, $Database);
        $conn->set_charset($CharacterSet);

        if (!$conn)
        {
            die('Ошибка подключения ('.mysqli_connect_errno().') '
                . mysqli_connect_error());
        }

        return $conn;
    }
 }

 //Работа с данными
 class MySQLCommand
 {
    var $conn; //connection
	var $sql; //Запрос или массив запросов
    var $type; //Тип запроса: null-обычный select; non_query-не возвращающие табличных значений; transaction-транзакции
    var $params; //параметры
    var $types; //типы параметров (s,i,d)
    
    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        
        switch($i)
		{
			case 2:
				$this -> conn = $a[0];
				$this -> sql = $a[1];
				$this -> type = null;
                $this -> params = null;
                $this -> types = null;
				break;
			case 5:
				$this -> conn = $a[0];
				$this -> sql = $a[1];
                $this -> type = $a[2];
                $this -> types = $a[4];
				//массив
				$this -> params = $a[3];
				break;
		}
    }

    //Выполняем запрос
    function requestExecute()
    {
        //Получаем переменные класса
		$conn = $this -> conn;
		$sql = $this -> sql;
		$type = null;
        $params = null;
        $types = null;
		if ($this -> type != null)
			$type = $this -> type;
		if ($this -> params != null)
            $params = $this -> params;
        if ($this -> types != null)
            $types = $this -> types;
            
        //Обработка полученных данных
        //Запрос на выборку
        if ($type == null)
        {
            //Если на вход поступил одиночный запрос
            if (!is_array(($sql)))
            {
               if ($stmt = $conn->query($sql))
               {
                   $result["status"] = 1;
                   $result["message"] = "Запрос успешно выполнен";
                   $res = array();
                   $i = 0;
                   while ($data = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
                   {
                       $res[$i] = $data;
                       $i++;
                   }
                   $result["data"] = $res;
               }
            }
        }
        // Запросы на вставку/удаление
        else if ($type != null && $type="non_query")
        {
            if (!is_array($sql))
            {
                //подготовка
                if (!$stmt = $conn->prepare($sql))
                {
                    $result["status"] = 0;
                    $result["message"] = "Не удалось подготовить запрос: (" . $conn->errno . ") " . $conn->error;
                }
                //привязка
                if (!$stmt->bind_param($types, ...$params)) //... - распаковка массива
                {
                    $result["status"] = 0;
                    $result["message"] = "Не удалось привязать параметры: (" . $conn->errno . ") " . $conn->error;
                }
                //выполнение
                if (!$stmt->execute())
                {
                    $result["status"] = 0;
                    $result["message"] = "Не удалось выполнить запрос: (" . $conn->errno . ") " . $conn->error;
                }

                $result["status"] = 1;
                $result["message"] = "Запрос успешно выполнен";
            }
        }

        return $result;
    }
 }
?>
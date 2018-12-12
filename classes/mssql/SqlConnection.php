<?php
//Подключение к бд
class SqlConnection 
{
	//Параметры подключения к бд
	var $DATABASES;
	//Указываем какой профиль настроек подтягиваем из settings.php DEFAULT - по умолчанию
	var $DATABASE_PROFILE_NAME;
		
	function __construct ()
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
	
	//Подключаемся к Microsoft SQL Server
	//Открываем соединение с бд, используя параметры подключение из settings.DATABASES
	function OpenConnection()
	{
		$Database = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["NAME"];
		$CharacterSet = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["CHARSET"];
		$serverName = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["HOST"];
		$UID = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["USER"];
		$PWD = $this -> DATABASES[$this -> DATABASE_PROFILE_NAME]["PASSWORD"];
		
		$connectionInfo = array("Database"=>$Database, "CharacterSet"=>$CharacterSet, "UID"=>$UID, "PWD"=>$PWD);
		$conn = sqlsrv_connect($serverName, $connectionInfo);
		
		return $conn;
	}
	
	function isExist()
	{
		if ($this -> OpenConnection())
			return true;
		else
			return false;
	}
}

//Получение данных из бд
class SqlCommand
{
	var $conn;
	var $sql;
	var $type;
	var $params;
	
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
				break;
			case 4:
				$this -> conn = $a[0];
				$this -> sql = $a[1];
				$this -> type = $a[2];
				//массив
				$this -> params = $a[3];
				break;
		}
	}
	
	function requestExecute()
	{		
		//Получаем переменные класса
		$conn = $this -> conn;
		$sql = $this -> sql;
		$type = null;
		$params = null;
		if ($this -> type != null)
			$type = $this -> type;
		if ($this -> params != null)
			$params = $this -> params;
		
		// Для вставки нельзя передавать массив
		//Если получили массив
		//Не запрос на выборку
		if ($type != null && $type == "non_query")
		{
			//на вход поступают con, sql, non_query и массив params
			if (!is_array($sql))
			{
				$stmt = sqlsrv_query($conn, $sql, $params);
				if ($stmt === false)
				{
					die( print_r( sqlsrv_errors(), true));
					$result["status"] = 0;
					$result["message"] = sqlsrv_errors();
				}
				else
				{
					$result["status"] = 1;
					$result["message"] = "Запрос успешно выполнен";
				}
				
				return $result;
			}
			else
			{
				$result["status"] = 0;
				$result["message"] = "Получен неверный перечень параметров";
				return $result;
			}
		}
		//Запрос на выборку данных
		else
		{
			if (is_array($sql))
			{
				$err = false;
				$i = 0;
				foreach ($sql as $key => $val)
				{
					$stmt = sqlsrv_query($conn, $val);
					if ($stmt === false)
					{
						$err = true;
						$result["message"][$key] = sqlsrv_errors();
					}
					$res = array();
					$i = 0;
			
					while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
					{
						$res[$i] = $data;
						$i++;
					}				
					
					$result["data"][$key] = $res;
					$i++;
				}
				if ($err)
				{
					$result["status"] = 0;
				}
				else
				{
					$result["status"] = 1;
					$result["message"] = "Запрос успешно выполнен";
				}
			}
			//Если одиночный запрос
			else
			{
				$stmt = sqlsrv_query($conn, $sql);
				if ($stmt === false)
				{
					$result["status"] = 0;
					$result["message"] = sqlsrv_errors();
				}
				else 
				{
					$result["status"] = 1;
					$result["message"] = "Запрос успешно выполнен";
				}
				//Получаем данные из бд
				$res = array();
				$i = 0;
				while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
				{
					$res[$i] = $data;
					$i++;
				}
				$result["data"] = $res;
			}
			//Возвращаем результат
			return $result;
		}
	}
}
?>
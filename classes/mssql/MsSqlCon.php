<?php
//Подключение к бд
/*
	Создание подключения к БД
	$sqlConnection = new MsSqlCon($GLOBALS["DATABASES"]);
	if ($sqlConnection -> isExist())
		$CONN = $sqlConnection -> OpenConnection();
	
	DATABASES - глобальный массив с настройками подключения к бд
*/
class MsSqlCon
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
class MsSqlCom
{
	var $conn; //connection
	var $sql; //Запрос или массив запросов
	var $type; //Тип запроса: null-обычный select; non_query-не возвращающие табличных значений; transaction-транзакции
	var $params; //параметры
	
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
				$this -> params = $a[3];
				break;
		}
	}
	
	function requestExecute()
	{
		/*
			Выполнение одиночного запроса:
				$query = "some query";
				$sqlCommand = new MsSqlCom([database connection], $query);
			Выполнение массива запросов:
				$query1 = "some query";
				$query2 = "some query";
				$query3 = "some query";
				$sql = ["query1" => $query1, "query2" => $query2, "query3" => $query3];
				$sqlCommand = new MsSqlCom([database connection], $sql);
			Выполнение запроса вставки - обновления - удаления
				$sql = "some query";
				$params = ["some params"];
				("non_query", "t(transatcion)") - дополнительные параметры типа запроса
												  может быть указан только один дополнительный параметров
												  по умолчанию осуществляется запрос на выборку
				$sqlCommand = new MsSqlCom($conn, $sql, "non_query", $params);
		*/
		//Возвращаемый массив
		$result = array();
		//Получаем переменные класса
		$conn = $this -> conn;
		$sql = $this -> sql;
		$type = null;
		$params = null;
		if ($this -> type != null)
			$type = $this -> type;
		if ($this -> params != null)
			$params = $this -> params;
		
		//Запрос на выборку
		/* 
				Массив $result имеет следующую структуру:
					для одиночного запроса
					$result[status][message][data]
						status  - статус запроса 1 - исполнен 0 - ошибка
						message - сообщение пользователю
						data    - возвращаемые данные
					
					для массива запросов
					$result[status][message => [key => data]][data => [key => data]]
						status  - статус запроса 1 - исполнен 0 - ошибка
						message - если каждый запрос из массива исполнен, то формируется элемент массива message с одиночным сообщение об успехе операции
								  если хотя бы один запрос не выполнился, то формируется массив внутри message, содержащий в себе ключ, который является наименование запроса в массиве запросов 
								  и идет сопоставление ключу данных об ошибке
						data    - включает в себя новый массив res на каждой итерации цикла, формируется подобно message
		*/
		if ($type == null) 
		{
			//массив на входе
			if (is_array($sql))
			{
				$errors = false;
				$i = 0;
				foreach ($sql as $key => $val)
				{
					$stmt = sqlsrv_query($conn, $val);
					if ($stmt === false)
					{
						$errors = true;
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
				if ($errors)
				{
					$result["status"] = 0;
				}
				else
				{
					$result["status"] = 1;
					$result["message"] = "Запрос успешно выполнен";
				}
			}
			//Один запрос на выходе
			else if (!is_array($sql))
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
		//Запрос на вставку - обновление - удаление 
		/*
			Если на входе получаем массив запросов, то параметры нужно передавать
			в массиве массивов параметров, например: 
										$parameter1 = array(param1, param2); 
										$parameter2 = array(param1, param2); 
										$parameters = [$parameter1, $parameter2];
			В случае одного запроса необходимо передавать просто массив параметров
		*/
		
		else if ($type != null && $type == "non_query")
		{
			//Если на вход поступил массив запросов
			if (is_array($sql))
			{
				if (count($sql) != count($params))
				{
					$result["status"] = 0;
					$result["message"] = "Количество элементов массива параметров и массива запросов не совпадает";
					return $result;
				}
				
				$err = false;
				$i = 0;
				foreach ($sql as $key => $val)
				{
					$stmt = sqlsrv_query($conn, $val, $params[$i]);
					if ($stmt === false)
					{
						$err = true;
						$result["message"][$key] = sqlsrv_errors();
					}
					$i++;
				}
				if ($err)
				{
					$result["status"] = 0;
				}
				else
				{
					$result["status"] = 1;
					$result["message"] = "Выполнение запросов завершено успешно";
				}
				
				return $result;
			}
			else if (!is_array($sql))
			{
				$stmt = sqlsrv_query($conn, $sql, $params);
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
				
				return $result;
			}
		}
		//Если необходимо выполнить транзакцию
		//По умолчанию принимает массив запросов и параметров
		/*
		Пример создания транзакции:
			$query1 = "SELECT * FROM item";
			$sql1 = ['s' => $query1];
			$query2 = "INSERT INTO item (id, item) VALUES (?, ?)";
			$params2 = array(1, 111);
			$sql2 = ['i' => [$query2, $params2]];
			$query3 = "UPDATE item SET item = ? WHERE id = 1";
			$params3 = array(222, 1);
			$sql3 = ['u' => [$query3, $params3]];
			$sql = [$sql1, $sql2, $sql3];
		*/
		else if ($type != null && $type == "t")
		{
			if (sqlsrv_begin_transaction($conn) === false)
			{
				$result["status"] = 0;
				$result["message"] = "Ошибка создания транзакции";
				return $result;
			}
			
			$success = true;
			
			
		}
	}	
}
?>
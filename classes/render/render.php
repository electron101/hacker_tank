<?php
//Отрисовка страницы
class Render
{
	//контекст данных
	var $CONTEXT;
	//Страница, которая будет загружена
	var $CONTENT;
	//тип содержимого по умолчанию file
	var $TYPE_CONTENT;

	function __construct()
	{
		$a = func_get_args();
		$i = func_num_args();
		switch ($i) {
			case 0:
				$this->CONTENT = "";
				$this->CONTEXT = null;
				$this->TYPE_CONTENT = 'file';
				break;
			case 1:
				$this->CONTENT = $a[0];
				$this->CONTEXT = null;
				$this->TYPE_CONTENT = 'file';
				break;
			case 2:
				$this->CONTENT = $a[0];
				$this->CONTEXT = $a[1];
				$this->TYPE_CONTENT = 'file';
				break;
			case 3:
				$this->CONTENT = $a[0];
				$this->CONTEXT = $a[1];
				$this->TYPE_CONTENT = $a[2];
				break;
		}
	}

	function renderPage()
	{
		$CONTENT = $this->CONTENT;
		$TYPE_CONTENT = $this->TYPE_CONTENT;
		
		//Контекст данных
		$context = null;
		if ($this->CONTEXT != null)
			$context = $this->CONTEXT;
		
		//Смотрим на то, нужно ли нам подключать файл в контексте базового
		if ($TYPE_CONTENT != "standalone") {
		//Подлючение базового файла шаблона и подгрузка основного контента
			$FILENAME = "templates/" . $GLOBALS["BASE_FILE"];
			if (file_exists($FILENAME))
				include("templates/" . $GLOBALS["BASE_FILE"]);
			else
				include("service_files/start_project.php");
		}
		else
			include($CONTENT);
	}
}
?>
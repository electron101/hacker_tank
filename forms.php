<?php
/** Модели сущностей */

/** Подключаем классы моделей */
include ("models.php");

/** Базовое объявление текстового поля */
// class ClassName
// {
    // var $form_presentation = [
        // "some_field" => ["type"=>"text", "label_text" => "label_text"]
    // ];
// }

class office_form
{
    var $form_presentation = [
        "name" => ["type"=>"text", "label_text" => "Наименование", "id" => "office_name", "r_" => "required", "sp_attr" => "autofocus"]
    ]; 
}

class user_form
{
    function form_presentation()
    {
        $query = "Select null id, '' name UNION ALL Select id, name From offices order by name";
        $CONN = $GLOBALS["CONN"];
        $mySqlCommand = new MySQLCommand($CONN, $query);
        $context = $mySqlCommand -> requestExecute();
        for ($i=0; $i<count($context["data"]); $i++)
        {
            $data[$context["data"][$i]["id"]] = $context["data"][$i]["name"];
        }
    
        $form_presentation = [
            "name" => ["type"=>"text", "label_text" => "Имя", "sp_attr" => "autofocus required"],
            "fam" => ["type"=>"text", "label_text" => "Фамилия", "sp_attr" => "autofocus required"],
            "otch" => ["type"=>"text", "label_text" => "Отчество", "sp_attr" => "autofocus"],
            "email" => ["type"=>"text", "label_text" => "Почта", "sp_attr" => "autofocus required"],
            "tel" => ["type"=>"text", "label_text" => "Телефон", "sp_attr" => "autofocus required"],
            "role" => ["type"=>"select_assoc", "label_text" => "Роль пользователя в системе", "id" => "user_role", "class" => "form-control select", "data" => [
                0 => "Администратор",
                1 => "Обычный пользователь",
                2 => "Врач"
            ]],
            "status" => ["type"=>"select_assoc", "label_text" => "Статус", "id" => "user_status", "class" => "form-control select", "data" => [
                1 => "Активный",
                0 => "Отключен"
            ]],
            "office_id" => ["type"=>"select_assoc", "label_text" => "Категория", "id" => "user_status", "class" => "form-control select2", "data" => $data],
            "info" => ["type"=>"textarea", "label_text" => "Информация", "sp_attr" => "rows='10' cols='45' style='resize: none;' autofocus"],
        ]; 
        return $form_presentation;
    }
}

?>
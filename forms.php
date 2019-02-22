<?php

/** Модели сущностей */

/** Базовое объявление текстового поля */
// class ClassName
// {
    // var $form_presentation = [
        // "some_field" => ["type"=>"text", "label_text" => "label_text"]
    // ];
// }

class Users
{
    function form_presentation()
    {
        $form_presentation = [
            "name" => ["type" => "text", "label_text" => "Логин", "id" => "login", "sp_attr" => "autofocus"],
            "pas" => ["type" => "password", "label_text" => "Пароль", "id" => "pas", "sp_attr" => "autofocus"],
            "role" => ["type" => "select_assoc", "label_text" => "Статус", "id" => "role", "class" => "form-control select", "data" => [
                1 => "Пользователь",
                0 => "Администратор"
            ]]
        ];
        return $form_presentation;
    }
}
?>
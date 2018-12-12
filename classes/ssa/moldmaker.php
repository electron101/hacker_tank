<?php
/** КРАЙНЯЯ ВЕРСИЯ 28.11.2018 */
/** Создание формы на основании класса из forms.php */

/** Формы */
include ("forms.php");

class MoldMaker
{
    /** класс формы */
    var $_class;
    var $_header;
    var $_model_name;

    function __construct()
    {
        $objects = func_get_args();
        $i = func_num_args();
        if ($i > 0)
        {
            $this -> _class = new $objects[0];
            $this -> _header = $objects[1];
            $this -> _model_name = $objects[2];
        }
    }

    /** Конструирование формы создания */
    function CreateView()
    {
        if (isset($this-> _class -> form_presentation))
            $form_presentation = $this -> _class -> form_presentation;
        else 
            $form_presentation = $this -> _class -> form_presentation();

        $count = count($form_presentation);

        if ($count > 0)
        {
            $top = '<div class="row">' .
                        '<div class="col-md-6">' .
                            '<div class="box box-primary">' .
                                '<div class="box-header with-border">' .
                                    '<h3 class="box-title">' . $this->_header . '</h3>' .
                                '</div>' .
                                '<form action="" role="form" method="POST">';

            $middle = '<div class="box-body">';
            foreach ($form_presentation as $key => $val)
            {
                $special_attribute =  isset($val['sp_attr']) ? $val['sp_attr'] : "";
                $default_val = isset($val['default_val']) ? $val['default_val'] : "";
                $a_ = isset($val['autofocus_']) ? $val['autofocus_'] : "";
                $r_ = isset($val['required_']) ? $val['required_'] : "";
                $id = isset($val['id']) ? $val['id'] : "";
                if ($val["type"] == "text")
                {
                    $middle .= '<div class="form-group">';
                    $middle .= '<label for='.$key.'>'.$val["label_text"].'</label>';
                    $middle .= '<input type="'.$val["type"].'" name="'.$key.'" class="form-control" id="'.$id.'" value="'.$default_val.'" '.$special_attribute.' '.$a_.' '.$r_.'> ';
                    $middle .= '</div>';
                }
                if ($val["type"] == "textarea")
                {
                    $middle .= '<div class="form-group">';
                    $middle .= '<label for='.$key.'>'.$val["label_text"].'</label>';
                    $middle .= '<textarea name="'.$key.'" class="form-control" id="'.$id.'" '.$special_attribute.' '.$a_.' '.$r_.'>'.$default_val.'</textarea>';
                    $middle .= '</div>';
                }
                else if ($val["type"] == "select_assoc")
                {
                    $middle .= '<select name="'.$key.'" id="'.$val["id"].'" class="'.$val["class"].'">';
                    foreach ($val["data"] as $k => $v)
                    {
                        $middle .= '<option value="'.$k.'">'.$v.' | '.$k.'</option>';
                    }
                    $middle .= '</select>';
                }
                else if ($val["type"] == "hidden")
                {
                    $middle .= '<input type="'.$val["type"].'" name="'.$key.'" id="'.$key.'" value="'.$default_val.'">';
                }
            }
            $middle .= '</div>';
            $middle .= '<div class="box-footer">';
            $middle .= '<button type="submit" class="btn btn-primary" name="act" value="'.$this->_model_name.'">Добавить</button>';
            $middle .= '</div>';

            $bottom = '</form>' .
                        '</div>' .
                        '</div>' .
                        '</div>';

            $content = $top . $middle . $bottom;
            
            $render = new Render($content, null, "html");
            $render -> renderPage();
        }
        else
            echo 'Не удается найти класс формы';
    }

     /** Конструирование формы редактирования */
     function EditView($context, $unique_key = 'id')
     {
        if (isset($this-> _class -> form_presentation))
            $form_presentation = $this -> _class -> form_presentation;
        else 
            $form_presentation = $this -> _class -> form_presentation();

        $count = count($form_presentation);

        if ($count > 0)
        {
            $top = '<div class="row">' .
                        '<div class="col-md-6">' .
                            '<div class="box box-primary">' .
                                '<div class="box-header with-border">' .
                                    '<h3 class="box-title">' . $this->_header . '</h3>' .
                                '</div>' .
                                '<form action="" role="form" method="POST">';

            $middle = '<div class="box-body">';
            $middle .= '<input type="hidden" name="unique_id" value='.$context["data"][0][$unique_key].'>';
            foreach ($form_presentation as $key => $val)
            {
                $special_attribute =  isset($val['sp_attr']) ? $val['sp_attr'] : "";
                $a_ = isset($val['autofocus_']) ? $val['autofocus_'] : "";
                $r_ = isset($val['required_']) ? $val['required_'] : "";
                $id = isset($val['id']) ? $val['id'] : "";

                if ($val["type"] == "text")
                {
                    $middle .= '<div class="form-group">';
                    $middle .= '<label for='.$key.'>'.$val["label_text"].'</label>';
                    $middle .= '<input type="'.$val["type"].'" name="'.$key.'" class="form-control" id="'.$id.'" value="'.$context["data"][0][$key].'" '.$special_attribute.' '.$a_.' '.$r_.'>';
                    $middle .= '</div>';
                }
                else if ($val["type"] == "select_assoc")
                {
                    $middle .= '<div class="form-group">';
                    $middle .= '<label for='.$key.'>'.$val["label_text"].'</label>';
                    $middle .= '<select name="'.$key.'" id="'.$id.'" class="'.$val["class"].'">';
                    foreach ($val["data"] as $k => $v)
                    {
                        if ($k == $context["data"][0][$key])
                            $middle .= '<option value="'.$k.'" selected>'.$v.'</option>';
                        else
                            $middle .= '<option value="'.$k.'">'.$v.'</option>';
                    }
                    $middle .= '</select>';
                    $middle .= '</div>';
                }
                else if ($val["type"] == "textarea")
                {
                    $middle .= '<div class="form-group">';
                    $middle .= '<label for='.$key.'>'.$val["label_text"].'</label>';
                    $middle .= '<textarea name="'.$key.'" class="form-control" id="'.$id.'" '.$special_attribute.' '.$a_.' '.$r_.'>'.$context["data"][0][$key].'</textarea>';
                    $middle .= '</div>';
                }
                else if ($val["type"] == "hidden")
                {
                    $middle .= '<input type="'.$val["type"].'" name="'.$key.'" id="'.$key.'" value="'.$context["data"][0][$key].'">';
                }
            }
            $middle .= '</div>';
            $middle .= '<div class="box-footer">';
            $middle .= '<button type="submit" class="btn btn-primary" name="act" value="'.$this -> _model_name.'">Обновить</button>';
            $middle .= '</div>';

            $bottom = '</form>' .
                        '</div>' .
                        '</div>' .
                        '</div>';

            $content = $top . $middle . $bottom;
            
            $render = new Render($content, null, "html");
            $render -> renderPage();
        }
        else
            echo 'Не удается найти класс формы';
     }
}
?>
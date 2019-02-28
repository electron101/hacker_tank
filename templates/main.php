<!-- Основная страница редактора кода -->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="static/img/ico.ico" type="image/png">
        <title>HackerTank</title>
        <!-- Стили CSS -->
        <?php 
        Esl::LoadCodeMirrorCss();
        Esl::LoadMyCss();
        Esl::BootstrapCSS();
        Esl::LoadDashboardCSS();
        ?>
    </head>
<style>
    .CodeMirror {border-top: 1px solid #888; border-bottom: 1px solid #888;}
</style>
<body>
    <!-- Хедер -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="?act=load_base">HackerTank</a>
        </div>
      </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-5 sidebar">
                <!-- Левая часть -->
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 5px;"> <b><?= $context['bd']['data'][0]['rus_name'] ?></b> </div>
                    <div class="col-md-12"><?= $context['bd']['data'][0]['text'] ?></div>
                </div>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-5 main">
                <!-- Шапка -->
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 5px;">
                    <table>
                        <tr>
                            <td>
                                <select name="keymap" id="keymap" class="form-control select" style="width: 120px;">
                                    <option value="0" selected>Обычный</option>
                                    <option value="1">VIM</option>
                                </select>
                                <input type="hidden" id="task_name" name="task_name" value="<?= $context['bd']['data'][0]['name'] ?>">
                            </td>
                            <td>
                                <select name="lang" id="lang" class="form-control select" style="width: 120px; margin-left:15px;">
                                    <option value="c" selected>C</option>
                                    <option value="sharp">C#</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" id="apply" value="extend" style="margin-left:15px;"><i class="fa fa-check"></i> Подтвердить</button>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <!-- Редактор кода -->
                    <div class="col-md-12">
                        <textarea id="c-code">
<?=$context['code']?>                            
                        </textarea>
                        <div style="font-size: 13px; width: 300px; height: 30px; display: none;">Key buffer: <span id="command-display"></span></div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6" style="background-color: #eeeeee; min-height: 40px; padding: 2px;"><b>Вывод</b></div>
                        <div class="col-md-6" style="background-color: #eeeeee; min-height: 40px;  padding: 2px;"><button type="button" class="btn btn-success" id="run" value="example" style="margin-left:15px; margin-right: 15px; float: right;"><i class="fa fa-play"></i> Запуск</button></div>
                    </div>
                    <!-- Вывод результатов -->
                    <div class="col-md-12" id="output"></div>
                </div>
            </div>
            
        </div>
    </div>

              
    
<?php
Esl::BootstrapJS();
Esl::LoadDtCodemirrorJS();
Esl::LoadCodeMirrorJS();
?>
</body>
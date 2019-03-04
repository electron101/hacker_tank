$(document).ready(function () {
    /** Кнопки компиляции и запуска теста */
    $('#run').on('click', function (e) {
        e.preventDefault();
        $("#output").html("");
        var val = ($(this).attr('value'));
        var code = cEditor.getValue();
        var lang = ($('#lang').val());
        var task_name = $('#task_name').val();
        $.ajax({
            url: "",
            type: "POST",
            data: { 'act': "compile_this", 'val': val, 'code': code, 'lang': lang, 'task_name': task_name },
            cache: false
        }).done(function (msg) {
            if (msg.indexOf("Успешная") != -1) {
                $("#output").append("<p style='color: #00aa00;'>Успешная компиляция</p>")
                var result_array = msg.split("|");
                result_array.pop();
                var length = result_array.length;
                for (i=0; i<length; i+=3)
                {
                    $("#output").append(result_array[i] + " " + result_array[i+1] + " " + result_array[i+2] + "<br>");
                }
            }
            else {
                $("#output").append(msg);
            }
        });
    });

    /** Подтвердить */
    $("#apply").on('click', function(e) {
        e.preventDefault();
        $("#output").html("");
        var val = ($(this).attr('value'));
        var code = cEditor.getValue();
        var lang = ($('#lang').val());
        var task_name = $('#task_name').val();
        $.ajax({
            url: "",
            type: "POST",
            data: { 'act': "compile_this", 'val': val, 'code': code, 'lang': lang, 'task_name': task_name },
            cache: false
        }).done(function (msg) {
            var result_array = msg.split("|");
            result_array.pop();
            length = result_array.length;
            var count_of_correct_answers = 0;
            var total_count = 0;
            var html1 = "<table class='table table-condensed' style='padding-bottom: 10px; width: 100%;'>";
            html1 += "<tr><th style='background-color: lightgrey;'><h5><b>ПРОСТЫЕ ТЕСТЫ</b></h5></th><th style='background-color: lightgrey;'> </th></tr>";
            for (i=0; i<length; i+=6)
            {
                if (result_array[i].indexOf("EXAMPLE") != -1)
                {
                    html1 += "<tr>";
                    html1 += "<td style='width: 45%'><h6><b>" + result_array[i+1] + "</b></h6>" +
                       "<small><i>" + result_array[i+2] + "</i></small></td>" + 
                       "<td><p>" + result_array[i+3] + "s ";
                    if (result_array[i+5].indexOf("OK") != -1)
                    {
                        count_of_correct_answers++;
                        total_count ++;
                        html1 += "<i style='color: green;'>" + result_array[i+5] + "</i></p></td>";
                    }
                    else
                    {
                        total_count ++;
                        html1 += "<i style='color: red;'>" + result_array[i+5] + "</i></p></td>";
                    }
                    html1 += "</tr>";
                }
            } 
            html1 += "</table>"
            $("#output").append("<br>");
            $("#output").append(html1 + "<hr>");
            var html2 = "<table class='table table-condensed' style='padding-bottom: 10px; width: 100%;'>";
            html2 += "<tr><th style='background-color: lightgrey;'><h5><b>КОРРЕКТНОСТЬ</b></h5></th><th style='background-color: lightgrey;'> </th></tr>";
            for (i=0; i<length; i+=6)
            {
                if (result_array[i].indexOf("CORRECT") != -1)
                {
                    html2 += "<tr>";
                    html2 += "<td style='width: 45%'><h6><b>" + result_array[i+1] + "</b></h6>" +
                       "<small><i>" + result_array[i+2] + "</i></small></td>" + 
                       "<td><p>" + result_array[i+3] + "s ";
                    if (result_array[i+5].indexOf("OK") != -1)
                    {
                        count_of_correct_answers++;
                        total_count++;
                        html2 += "<i style='color: green;'>" + result_array[i+5] + "</i></p></td>";
                    }
                    else
                    {
                        total_count++;
                        html2 += "<i style='color: red;'>" + result_array[i+5] + "</i></p></td>";
                    }
                    html2 += "</tr>";
                }
            } 
            html2 += "</table>"
            $("#output").append(html2 + "<hr>");

            var percent = (count_of_correct_answers / total_count) * 100;
            var answer = "<h2>РЕЗУЛЬТАТ: " + percent + "%</h2>"
            $("#output").append(answer + "<hr>");
            Save_statistic(percent);
            console.log(result_array);
        });
    });

    /** Сохранение статистики пользователя */
    function Save_statistic(percent)
    {
        var lang = ($('#lang').val());
        var id_task = $('#id_task').val();
        $.ajax({
            url: "",
            type: "POST",
            data: { 'act': "save_statistic", 'percent': percent, 'lang': lang, 'id_task': id_task },
            cache: false,
            async: true
        }).done(function (msg) {
            console.log(msg);
        })
    }

    /** CODEMIRROR                                                                     ****/
    /** МЕНЯЕМ ЯЗЫК И ПОДКЛЮЧАЕМ НУЖНЫЙ СНИППЕТ */
    $('#lang').on('change', function () {
        var lang = $(this).val();
        if (lang == "c")
            cEditor.setOption("mode", "text/x-csrc");
        if (lang == "sharp")
            cEditor.setOption("mode", "text/x-csharp");

        task_name = $('#task_name').val();
        // подгружаем файл сниппета
        $.ajax({
            url: "",
            type: "POST",
            data: { 'act': 'change_lang', 'lang': lang, 'task_name': task_name },
            cache: false
        }).done(function (answ) {
            cEditor.setValue(answ);
        })
    });
    /** КОНЕЦ МЕНЯЕМ ЯЗЫК И ПОДКЛЮЧАЕМ НУЖНЫЙ СНИППЕТ */


    var cEditor = CodeMirror.fromTextArea(document.getElementById("c-code"), {
        matchBrackets: true,
        theme: "dracula",
        keyMap: "default",
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-csrc",
    });

    $('#keymap').on('change', function () {
        var mod = $(this).val();
        if (mod == 0)
            cEditor.setOption("keyMap", "default");
        if (mod == 1)
            cEditor.setOption("keyMap", "vim");
    });

    var commandDisplay = document.getElementById('command-display');
    var keys = '';
    CodeMirror.on(cEditor, 'vim-keypress', function (key) {
        keys = keys + key;
        commandDisplay.innerHTML = keys;
    });
    CodeMirror.on(cEditor, 'vim-command-done', function (e) {
        keys = '';
        commandDisplay.innerHTML = keys;
    });
});
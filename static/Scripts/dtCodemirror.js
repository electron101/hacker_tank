$(document).ready(function () {
    /** Кнопки компиляции и запуска теста */
    $('#apply, #run').on('click', function (e) {
        e.preventDefault();
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
            alert(msg);
        });
    });
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
            data: { 'act': 'change_lang', 'lang': lang , 'task_name': task_name},
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
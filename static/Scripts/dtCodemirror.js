$(document).ready(function () {
    /** CODEMIRROR                                                                     ****/
    /** МЕНЯЕМ ЯЗЫК И ПОДКЛЮЧАЕМ НУЖНЫЙ СНИППЕТ */
    $('#lang').on('change', function () {
        var lang = $(this).val();
        if (lang == "c")
            cEditor.setOption("mode", "text/x-csrc");
        if (lang == "sharp")
            cEditor.setOption("mode", "text/x-csharp");
        // подгружаем файл сниппета
        $.ajax({
            url: "",
            type: "POST",
            data: { 'act': 'change_lang', 'lang': lang },
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
$(document).ready(function () {

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

    /** РЕГИСТРАЦИЯ */
    $('#do_reg').click(function (event) {
        event.preventDefault();
        var formValid = true;

        $('#register_form input').each(function () {

            var formGroup = $(this).parents('.form-group');
            var glyphicon = formGroup.find('.form-control-feedback');

            if (!this.checkValidity()) {
                formGroup.addClass('has-error').removeClass('has-success');
                glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
                formValid = false;
            }
            else {
                formGroup.addClass('has-success').removeClass('has-error');
                glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove');
            }
        });

        if (formValid) {
            var str = $('#register_form').serialize();
            str = decodeURI(str);
            $.ajax({
                url: "",
                type: "POST",
                data: { 'act': 'do_reg', 'str': str },
                cache: false
            }).done(function (msg) {
                if (msg == 0) {
                    $('#pass-danger').removeClass('hidden');
                    hide_input_icons();
                }
                if (msg == 1) {
                    $('#login-danger').removeClass('hidden');
                    hide_input_icons();
                }
                if (msg == 2) {
                    alert("Проблемы при вставке значений");
                }
                if (msg == 1000) {
                    window.location.href = "?act=login";
                }
            })
        }

        // скрываем значки в инпутах формы
        function hide_input_icons() {
            $('#register_form input').each(function () {
                var formGroup = $(this).parents('.form-group');
                var glyphicon = formGroup.find('.form-control-feedback');
                formGroup.removeClass('has-success');
                glyphicon.removeClass('glyphicon-ok');
            });
        }
    });
    /** РЕГИСТРАЦИЯ КОНЕЦ */
});

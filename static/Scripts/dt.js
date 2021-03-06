$(document).ready(function () {

    // CKEditor
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1', {
            height: 500
        });
    })

    $(function () {
        $('.select2').select()
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

    /** Таблицы */

    if ($.fn.dataTable.isDataTable('#tests_table')) {
        tests_table = $('#tests_table').DataTable();
    }
    else {
        tests_table = $('#tests_table').DataTable({
            "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Все"]],
            "deferRender": true,
            'stateSave': false,
            'select': true,
            'paging': true,
            'lengthChange': true,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false
        });
    }
});

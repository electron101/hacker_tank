<?php
/** Загрузчик внешних скриптов (External Scripts Loader) */
Class Esl
{
    static function LoadBaseCss()
    {
        echo '<link rel="stylesheet" href="static/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/dist/css/AdminLTE.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/dist/css/skins/skin-green.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/bower_components/select2/dist/css/select2.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">';
		echo '<link rel="stylesheet" href="static/AdminLTE/dist/css/skins/_all-skins.min.css">';
        echo '<link rel="stylesheet" href="static/AdminLTE/plugins/iCheck/square/blue.css">';
        /** Свои стили */
        echo '<link rel="stylesheet" href="static/css/mycss.css">';
    }

    static function LoadMyCss()
    {
        echo '<link rel="stylesheet" href="static/css/mycss.css">';
    }

    static function BootstrapCSS()
    {
        echo '<link rel="stylesheet" href="static/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">';
    }

    static function LoadDashboardCSS()
    {
        echo '<link rel="stylesheet" href="static/css/dashboard.css">';
    }

    static function LoadCodeMirrorCss()
    {
        echo '<link rel="stylesheet" href="static/codemirror/doc/docs.css">';
		echo '<link rel="stylesheet" href="static/codemirror/lib/codemirror.css">';
		echo '<link rel="stylesheet" href="static/codemirror/addon/hint/show-hint.css">';
		echo '<link rel="stylesheet" href="static/codemirror/theme/darcula.css">';
        echo '<link rel="stylesheet" href="static/codemirror/theme/dracula.css">';
    }

    static function LoadBaseJS()
    {
        echo '<script src="static/AdminLTE/bower_components/jquery/dist/jquery.js"></script>';
		echo '<script src="static/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js"></script>';
		echo '<script src="static/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>';
		echo '<script src="static/AdminLTE/dist/js/adminlte.min.js"></script>';
		echo '<script src="static/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
		echo '<script src="static/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
		echo '<script src="static/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>';
		echo '<script src="static/AdminLTE/plugins/iCheck/icheck.min.js"></script>';
        echo '<script src="static/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>';
        /** Свои скрипты */
        echo '<script src="static/Scripts/dt.js"></script>';
    }

    static function LoadDtJs()
    {
        echo '<script src="static/Scripts/dt.js"></script>';
    }

    static function LoadDtCodemirrorJS()
    {
        echo '<script src="static/Scripts/dtCodemirror.js"></script>';
    }

    static function BootstrapJS()
    {
        echo '<script src="static/AdminLTE/bower_components/jquery/dist/jquery.js"></script>';
        echo '<script src="static/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>';
    }

    static function LoadCodeMirrorJS()
    {
        // codemirror
		echo '<script src="static/codemirror/lib/codemirror.js"></script>';
        echo '<script src="static/codemirror/addon/hint/show-hint.js"></script>';
        echo '<script src="static/codemirror/addon/hint/xml-hint.js"></script>';
        echo '<script src="static/codemirror/addon/hint/html-hint.js"></script>';
        echo '<script src="static/codemirror/mode/xml/xml.js"></script>';
        echo '<script src="static/codemirror/mode/javascript/javascript.js"></script>';
        echo '<script src="static/codemirror/mode/css/css.js"></script>';
        echo '<script src="static/codemirror/mode/htmlmixed/htmlmixed.js"></script>';
		echo '<script src="static/codemirror/mode/clike/clike.js"></script>';
		echo '<script src="static/codemirror/keymap/vim.js"></script>';
    }
}
?>
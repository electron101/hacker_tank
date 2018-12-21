<!-- Base -->
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>New Codility</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<link rel="stylesheet" href="static/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="static/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="static/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="static/AdminLTE/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="static/AdminLTE/dist/css/skins/skin-green.min.css">
		<link rel="stylesheet" href="static/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="static/AdminLTE/bower_components/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="static/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="static/AdminLTE/dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="static/AdminLTE/plugins/iCheck/square/blue.css">

		<!-- codemirror -->
		<link rel="stylesheet" href="static/codemirror/doc/docs.css">
		<link rel="stylesheet" href="static/codemirror/lib/codemirror.css">
		<link rel="stylesheet" href="static/codemirror/addon/hint/show-hint.css">
		<link rel="stylesheet" href="static/codemirror/theme/darcula.css">
		<link rel="stylesheet" href="static/codemirror/theme/dracula.css">

		<!-- собственные стили -->
		<link rel="stylesheet" href="static/css/mycss.css">
	</head>
	<body class="hold-transition skin-black sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<!-- Header Navbar -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="?act=loadStart" style="color: #000; font-family: consolas; font-size: 24; padding-left: 25%;"><b>HACKER TANK</b></a>
					<!-- Пользователь -->
					<div class="navbar-custom-menu">
						<?php if (isset($_SESSION['login'])): ?>
							<ul class="nav navbar-nav">
								<li class="dropdown user user-menu">
            						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<img src="static/img/test_avatar.jpg" class="user-image" alt="User Image">
              							<span class="hidden-xs"><?=$_SESSION['login']?></span>
            						</a>
            						<ul class="dropdown-menu">
              							<li class="user-footer">
										  <?php if($_SESSION['role'] == 0): ?>
	                						<div class="pull-left">
                  								<a href="?act=lk" class="btn btn-default btn-flat">Личный кабинет</a>												
                							</div>
										  <?php endif; ?>
                							<div class="pull-right">
	                  							<a href="?act=logout" class="btn btn-default btn-flat">Выйти</a>
                							</div>
              							</li>
            						</ul>
          						</li>
							</ul>
							<?php else: ?>
							<ul class="nav navbar-nav">
								<li class="dropdown user user-menu">
            						<a href="?act=login">
              							<span class="hidden-xs">Войти</span>
            						</a>
          						</li>
							</ul>
							<?php endif; ?>
					</div>
				</nav>
			</header>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
				<section class="content container-fluid">
				<?php 
					if ($CONTENT != "") 
					{
						if ($TYPE_CONTENT == "html")
							echo $CONTENT;
						else if ($TYPE_CONTENT == "file")
							require $CONTENT;
						else
							echo 'Тип содержимого контента не установлен!';
					}
				?>
				</section>
			<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<!-- Main Footer -->
			<footer class="main-footer">
			</footer>
		</div>
		<script src="static/AdminLTE/bower_components/jquery/dist/jquery.js"></script>
		<script src="static/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js"></script>
		<script src="static/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="static/AdminLTE/dist/js/adminlte.min.js"></script>
		<script src="static/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="static/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="static/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="static/AdminLTE/plugins/iCheck/icheck.min.js"></script>
		<script src="static/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

		<!-- codemirror -->
		<script src="static/codemirror/lib/codemirror.js"></script>
  		<script src="static/codemirror/addon/hint/show-hint.js"></script>
  		<script src="static/codemirror/addon/hint/xml-hint.js"></script>
  		<script src="static/codemirror/addon/hint/html-hint.js"></script>
  		<script src="static/codemirror/mode/xml/xml.js"></script>
  		<script src="static/codemirror/mode/javascript/javascript.js"></script>
  		<script src="static/codemirror/mode/css/css.js"></script>
  		<script src="static/codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<script src="static/codemirror/mode/clike/clike.js"></script>
		<script src="static/codemirror/keymap/vim.js"></script>

		<script src="static/Scripts/dt.js"></script>
	</body>
</html>

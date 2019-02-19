<header class="main-header">
    <!-- Лого -->
    <a href="index.php" class="logo">
        <!-- Мини лого 50x50 pixels -->
        <span class="logo-mini"><b>H</b>T</span>
        <!-- Лого в обычном состоянии для мобильных девайсов -->
        <span class="logo-lg">HackerTank</span>
    </a>
    <!-- Хедер навбара -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Вкл/выкл сайдбар-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Пользователь -->
        <div class="navbar-custom-menu">
            <?php if (isset($_SESSION['login'])) : ?>
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="static/img/test_avatar.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $_SESSION['login'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="static/img/test_avatar.jpg" class="img-circle" alt="User Image">
                            <p><?= $_SESSION['login'] ?> <?php if ($_SESSION['role'] == 0) : ?> - администратор сайта <?php endif; ?></p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="?act=lk" class="btn btn-default btn-flat">Личный кабинет</a>
                            </div>
                            <div class="pull-right">
                                <a href="?act=logout" class="btn btn-default btn-flat">Выход</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php else : ?>
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="static/img/test_avatar.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">Гость</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="static/img/test_avatar.jpg" class="img-circle" alt="User Image">
                            <p>Гость</p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="?act=register" class="btn btn-default btn-flat">Регистрация</a>
                            </div>
                            <div class="pull-right">
                                <a href="?act=login" class="btn btn-default btn-flat">Войти</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </nav>
</header>
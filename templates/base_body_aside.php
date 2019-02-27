<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Меню сайдбара -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Доступные задания</li>
            <?php
            $task_list_for_navbar = load_task_list_for_navbar();
            for ($i = 0; $i < count($task_list_for_navbar['data']); $i++) {
                echo "<li class='active'><a href='?act=sel_task&id=" . $task_list_for_navbar['data'][$i]['id_lesson'] . "'>
                <i class='fa fa-circle-thin'></i><span>" . $task_list_for_navbar['data'][$i]['description'] . "</span>
                </a></li>";
            }
            ?>
            <?php if (isset($_SESSION['login']) and $_SESSION['role'] == 0) : ?>
            <!-- Меню для админа -->
            <li class="header">Администрирование</li>
            <li class="active"><a href="?act=admin_tests"><i class="fa fa-clipboard"></i> <span>Тесты</span></a></li>
            <li class="active"><a href="?act=admin_users"><i class="fa fa-users"></i> <span>Пользователи</span></a></li>
            <li class="active"><a href="?act=admin_categories"><i class="fa fa-users"></i> <span>Категории</span></a></li>
            <li class="active"><a href="?act=admin_lessons"><i class="fa fa-edit"></i> <span>Темы</span></a></li>
            <?php endif; ?>
        </ul>
    </section>
</aside>
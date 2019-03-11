<!-- Редактируем тест -->
<?php if (isset($_SESSION['login']) && $_SESSION['role'] == 0) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"> Редактирование теста </h3>
            </div>
            <form action="" role="form" method="POST" enctype="multipart/form-data">
            <div class="box-body pad">

                <input type="hidden" name="id_task" value="<?= $context['task']['data'][0]['id_task'] ?>">

                <div class="form-group">
                    <label for="name">Наименование</label>
                    <input type="text" name="name" id="name" value="<?= $context['task']['data'][0]['name'] ?>" class='form-control' required>
                    <input type="hidden" name="old_name" id="old_name" value="<?= $context['task']['data'][0]['name'] ?>">
                </div>

                <div class="form-group">
                    <label for="rus_name">Локализованное наименование</label>
                    <input type="text" name="rus_name" id="rus_name" value="<?= $context['task']['data'][0]['rus_name'] ?>" class='form-control' required>
                </div>

                <div class="form-group">
                    <label for="editor1">Текст</label>
                    <textarea name="editor1" id="editor1" cols="80" rows="40" required>
                        <?= $context['task']['data'][0]['text'] ?>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="category">Сложность</label>
                    <select name="category" id="category" class="form-control select2">
                        <?php for ($i = 0; $i < count($context['categories']['data']); $i++) : ?>
                            <?php if ($context['categories']['data'][$i]['id_category'] == $context['task']['data'][0]['id_category']) : ?>
                                <option value="<?= $context['categories']['data'][$i]['id_category'] ?>" selected><?= $context['categories']['data'][$i]['name'] ?></option>
                            <?php else : ?>
                                <option value="<?= $context['categories']['data'][$i]['id_category'] ?>"><?= $context['categories']['data'][$i]['name'] ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="text_min">Краткое описание</label>
                    <input type="text" name="text_min" id="text_min" class='form-control' value='<?= $context['task']['data'][0]['tex_min'] ?>' required>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="lesson">Тема</label>
                    <select name="lesson" id="lesson" class="form-control select2">
                        <?php for ($i = 0; $i < count($context['lessons']['data']); $i++) : ?>
                            <?php if ($context['lessons']['data'][$i]['id_lesson'] == $context['task']['data'][0]['id_lesson']) : ?>
                                <option value="<?= $context['lessons']['data'][$i]['id_lesson'] ?>" selected><?= $context['lessons']['data'][$i]['description'] ?></option>
                            <?php else : ?>
                                <option value="<?= $context['lessons']['data'][$i]['id_lesson'] ?>"><?= $context['lessons']['data'][$i]['description'] ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="need_update_c"> Обновлять файлы C
                  </label>
                </div>

                <div class="form-group">
                    <label for="c-files">Загрузить ZIP архив для C</label>
                    <input type="file" name="c-files" id="c-files" accept=".zip" >
                </div>

                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="need_update_csharp"> Обновлять файлы C#
                  </label>
                </div>

                <div class="form-group">
                    <label for="csharp-files">Загрузить ZIP архив для C#</label>
                    <input type="file" name="csharp-files" id="csharp-files" >
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="act" value="update_test">Обновить</button>
                </div>

            </div>
            </form>
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"> Папки связанные с этим тестом</h3>
            </div>
            <div class="box-body">
                <table id="users_table" class="table table-bordered table-hover" style="width: 100%">
                <tbody>
                <?php
                $dir = "data/code_templates/" . $context['task']['data'][0]['name'] . "/";
                if (file_exists($dir)){
                    $dir_list = scandir($dir);
                    foreach ($dir_list as $d) {
                        if ($d != '.' && $d != '..') {
                    ?>
                        <tr>
                            <td><span class="glyphicon glyphicon-folder-open" style="font-size: 50px; color: ##21292d;"></span></td>
                            <td><b><?=$d?></b></td>
                            <td><a href="?act=download_file&name=<?=$d?>&path=<?=$dir?>"><i class="fa fa-download"></i> <span>Скачать</span></a> </td>
                            <td><a href="?act=del_file&name=<?=$d?>&path=<?=$dir?>"><i class="fa fa-trash"></i> <span>Удалить</span></a></td>
                        </tr>
                    <?php
                        }
                    }
                }
                ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
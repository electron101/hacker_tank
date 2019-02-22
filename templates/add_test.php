<!-- Добавляем тест -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"> Добавление теста </h3>
            </div>
            <form action="" role="form" method="POST" enctype="multipart/form-data">
            <div class="box-body pad">
                <div class="form-group">
                    <label for="name">Наименование</label>
                    <input type="text" name="name" id="name" value="" class='form-control' required>
                </div>

                <div class="form-group">
                    <label for="rus_name">Локализованное наименование</label>
                    <input type="text" name="rus_name" id="rus_name" value="" class='form-control' required>
                </div>

                <div class="form-group">
                    <label for="editor1">Текст</label>
                    <textarea name="editor1" id="editor1" cols="80" rows="40" required>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="category">Сложность</label>
                    <select name="category" id="category" class="form-control select2">
                        <?php for ($i=0; $i<count($context['categories']['data']); $i++): ?>
                            <option value="<?=$context['categories']['data'][$i]['id_category']?>"><?=$context['categories']['data'][$i]['name']?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="text_min">Краткое описание</label>
                    <input type="text" name="text_min" id="text_min" class='form-control' value='' required>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="lesson">Тема</label>
                    <select name="lesson" id="lesson" class="form-control select2">
                        <?php for ($i=0; $i<count($context['lessons']['data']); $i++): ?>
                            <option value="<?=$context['lessons']['data'][$i]['id_lesson']?>"><?=$context['lessons']['data'][$i]['description']?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="c-files">Загрузить ZIP архив для C</label>
                    <input type="file" name="c-files" id="c-files" accept=".zip" required>
                </div>

                <div class="form-group">
                    <label for="csharp-files">Загрузить ZIP архив для C#</label>
                    <input type="file" name="csharp-files" id="csharp-files" required>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="act" value="save_test">Сохранить</button>
                </div>

            </div>
            </form>
        </div>
    </div>
</div>
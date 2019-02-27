<!-- Справочник модулей -->
<?php if (isset($_SESSION['login']) && $_SESSION['role'] == 0): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Тесты</h3>
            </div>
            <div class="box-body">
                <table id="tests_table" class="table table-bordered table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Тема</th>
                            <th>Название</th>
                            <th>Сложность</th>
                            <th class="text-center">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i<count($context["data"]); $i++): ?>
                        <tr class="table-data">
                            <td><?=$i+1?></td>
                            <td><?=$context["data"][$i]["lesson"]?></td>
                            <td><?=$context["data"][$i]["rus_name"]?></td>
                            <td><?=$context["data"][$i]["category"]?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="?act=edit_test&id=<?=$context["data"][$i]["id_task"]?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="?act=del_test&id=<?=$context["data"][$i]["id_task"]?>&name=<?=$context["data"][$i]["rus_name"]?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <a class="btn btn-md btn-primary btn_in_bottom" href="?act=test_add" role="button" style="margin: 12px;">
			    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Добавить тест</a>
        </div>
    </div>
</div>

<?php endif; ?>
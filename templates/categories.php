<!-- Справочник пользователей -->
<?php if (isset($_SESSION['login']) && $_SESSION['role'] == 0): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Категории сложности</h3>
            </div>
            <div class="box-body">
                <table id="categories_table" class="table table-bordered table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Наименование</th>
                            <th class="text-center">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i<count($context["data"]); $i++): ?>
                        <tr class="table-data">
                            <td><?=$i+1?></td>
                            <td><?=$context["data"][$i]["name"]?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="?act=edit_category&id=<?=$context["data"][$i]["id_category"]?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="?act=del_category&id=<?=$context["data"][$i]["id_category"]?>&name=<?=$context["data"][$i]["name"]?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <a class="btn btn-md btn-primary btn_in_bottom" href="?act=category_add" role="button" style="margin: 12px;">
			    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Добавить категорию</a>

        </div>
    </div>
</div>
<?php endif; ?>
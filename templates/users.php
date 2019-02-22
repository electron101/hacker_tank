<!-- Справочник пользователей -->
<?php if (isset($_SESSION['login']) && $_SESSION['role'] == 0): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Пользователи</h3>
            </div>
            <div class="box-body">
                <table id="users_table" class="table table-bordered table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Логин</th>
                            <th>Роль</th>
                            <th class="text-center">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i<count($context["data"]); $i++): ?>
                        <tr class="table-data">
                            <td><?=$i+1?></td>
                            <td><?=$context["data"][$i]["login"]?></td>
                            <td><?=$context["data"][$i]["role"]?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="?act=edit_users&id=<?=$context["data"][$i]["id"]?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="?act=del_users&id=<?=$context["data"][$i]["id"]?>&name=<?=$context["data"][$i]["login"]?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- удаление -->
<?php if (isset($_SESSION['login'])): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> Вы действительно хотите удалить выбранный элемент (<?=$context["name"]?>)</h3>
            </div>
            <div class="box-body">
            <a class="btn btn-md btn-danger btn_in_bottom" href="?act=confirm_delete&id=<?=$context["id"]?>&from=<?=$context["act"]?>" role="button" style="margin: 12px;">
			    <span class="fa fa-trash" aria-hidden="true"></span> Удалить</a>
            <a class="btn btn-md btn-default btn_in_bottom" href="?act=go_back" role="button" style="margin: 12px;">Отменить</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
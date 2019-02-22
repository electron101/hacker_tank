<!-- Стартовая страница -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$context['data'][0]['description']?></h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-condensed" id="task_list">
                            <tr>
                                <th style="width: 2px"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php for ($i=0; $i<count($context['data']); $i++): ?>
                            <tr>
                                <td <?php switch ($context['data'][$i]['id_category'])
                                {
                                    case 1:
                                        echo 'style="background-color: green;"';
                                }
                                ?>></td>
                                <td>
                                    <?=$context['data'][$i]['rus_name']?>
                                    <br>
                                    <small style="color: grey;"><?=$context['data'][$i]['tex_min']?></small>
                                </td>
                                <td><?=$context['data'][$i]['name']?></td>
                                <td><span class="badge bg-red">0%</span></td>
                                <td>
                                    <a href="" class="btn btn-block btn-default btn-xs">Просмотр</a>
                                    <a href="?act=code&task_name=<?=$context['data'][$i]['task_name']?>&id=<?=$context['data'][$i]['id_task']?>" class="btn btn-block btn-primary btn-xs">Старт</a>
                                </td>
                            </tr>
                            <?php endfor; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
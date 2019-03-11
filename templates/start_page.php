<!-- Стартовая страница -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <?php 
                            if (count($context['tasks']['data']) > 0) 
                            {
                                echo $context['tasks']['data'][0]['description'];
                            }
                            else
                            {  
                                echo '<p>Тесты еще не добавлены</p>'; 
                            }
                            ?></h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-condensed" id="task_list" style="padding-bottom: 10px;">
                            <tr>
                                <th style="width: 2px"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php for ($i=0; $i<count($context['tasks']['data']); $i++): ?>
                            <tr>
                                <td <?php switch ($context['tasks']['data'][$i]['id_category'])
                                {
                                    case 1:
                                        echo 'style="background-color: green;"';
                                    case 2:
                                        echo 'style="background-color: orange;"';
                                    case 3:
                                        echo 'style="background-color: darkred;"';
                                }
                                ?>></td>
                                <td style="vertical-align: middle;">
                                    <?=$context['tasks']['data'][$i]['rus_name']?>
                                    <br>
                                    <small style="color: grey;"><?=$context['tasks']['data'][$i]['tex_min']?></small>
                                </td>
                                <td style="vertical-align: middle;"><?=$context['tasks']['data'][$i]['name']?></td>
                                
                                <td style="vertical-align: middle;">
                                    <?php if (count($context['stat']['data']) > 0){ ?>
                                        <?php for ($j=0; $j<count($context['stat']['data']); $j++){ ?> 
                                            <span 
                                            <?php if ($context['tasks']['data'][$i]['id_task'] == $context['stat']['data'][$j]['id_task']){
                                                if ($context['stat']['data'][$j]['percent'] < 50)
                                                {
                                                    echo 'class="badge bg-red"';
                                                }
                                                if ($context['stat']['data'][$j]['percent'] >= 50 && $context['stat']['data'][$j]['percent'] < 75)
                                                {
                                                    echo 'class="badge bg-yellow"';
                                                }
                                                if ($context['stat']['data'][$j]['percent'] >= 75)
                                                {
                                                    echo 'class="badge bg-green"';
                                                }
                                            }
                                            else {
                                                echo 'class="badge bg-red"'; 
                                            } ?>
                                            >
                                                <?php if ($context['tasks']['data'][$i]['id_task'] == $context['stat']['data'][$j]['id_task']){ ?>
                                                    <?=$context['stat']['data'][$j]['percent']?>%
                                                <?php } else echo '0%'; ?>
                                            </span>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                
                                <td>
                                    <a href="" class="btn btn-block btn-default btn-md">Просмотр</a>
                                    <a href="?act=code&task_name=<?=$context['tasks']['data'][$i]['task_name']?>&id=<?=$context['tasks']['data'][$i]['id_task']?>" class="btn btn-block btn-primary btn-md">Старт</a>
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
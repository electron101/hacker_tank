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
                                    <a href="?act=code&task_name=<?=$context['data'][$i]['task_name']?>" class="btn btn-block btn-primary btn-xs">Старт</a>
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
                    <!-- <div class="box-body no-padding">
  	if (isset($context['data'][0]['id_task']))
  	{
  		 <ul class="nav nav-pills nav-stacked">
  			for ($i=0; $i<count($context['data']); $i++)
  			{
  				 <li class="active"><a href="?act=code&task='.$context['data'][$i]['id_task'].'&task_name='.$context['data'][$i]['task_name'].'"><i class="fa fa-circle"></i>';
  				$html .=  $context['data'][$i]['tex_min'].' ['.$context['data'][$i]['name'].']</a></li>
  			}
  		 </ul>
  	}
  	 </div>
  	 </div>
            </div>
        </div>
    </div>
</div> -->
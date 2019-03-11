<!-- Cтраница предпросмотра -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <?php 
                            if (count($context['data']) > 0) 
                            {
                                echo $context['data'][0]['rus_name'];
                            }
                            else
                            {  
                                echo '<p>Тесты еще не добавлены</p>'; 
                            }
                            ?></h3>
                    </div>
                    <div class="box-body no-padding">
                            <?php if (count($context['data']) > 0) 
                            {
                                echo $context['data'][0]['text'];
                            }
                            ?>
                             <a href="?act=code&task_name=<?=$context['data'][0]['name']?>&id=<?=$context['data'][0]['id_task']?>" class="btn btn-block btn-primary btn-md">Начать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
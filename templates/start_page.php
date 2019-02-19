<!-- Стартовая страница -->
<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-3" id="list">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Доступные задания</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <?php if (count($context['data']) > 0): ?>
                        <ul class="nav nav-pills nav-stacked">
                            <?php for ($i=0; $i<count($context['data']); $i++): ?>
                                <?php if ($i == 0): ?>
                                    <li class="active" subj="<?=$context['data'][$i]['id_lesson']?>"><a href="" id="no_click"><i class="fa fa-circle"></i> 
                                        <?=$context['data'][$i]['description']?></a></li>
                                <?php else: ?>
                                    <li subj="<?=$context['data'][$i]['id_lesson']?>"><a href="" id="no_click"><i class="fa fa-circle"></i> 
                                        <?=$context['data'][$i]['description']?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($_SESSION['id']) && $_SESSION['role'] == 0): ?>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Администрирование</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked"> 
                        <li><a href="" id=""><i class="fa fa-circle"></i>Тесты</a></li>
                        <li><a href="" id="no_click"><i class="fa fa-circle"></i>Пользователи</a></li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-xs-9" id="right_part">
        </div>
        <!-- <a href="Test/aa">Тестовая ссылка</a> -->
    </div>
</div>
<!-- Личный кабинет -->
<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-user"></i> Личный кабинет
          </h2>
        </div>
        <!-- /.col -->
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Задача</th>
              <th>Язык</th>
              <th>Показатель</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0; $i<count($context['data']); $i++): ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$context['data'][$i]['rus_name']?></td>
                    <td><?=$context['data'][$i]['language']?></td>
                    <td><?=$context['data'][$i]['percent']?>%</td>
                </tr>
            <?php endfor;?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
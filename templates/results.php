<!-- Основная страница -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?php 
                    $res = explode("|", $context);
                    array_pop($res);
                    //5 эл-тов
                    $res = array_chunk($res, 5, FALSE);
                    $i = 0;

                    foreach($res as $el)
                    {
                        if ($el[0] == 0)
                            $example_tests[$i] = $el;
                        $i++;
                    }
                    $i = 0;
                    foreach($res as $el)
                    {
                        if ($el[0] == 1)
                            $correct_tests[$i] = $el;
                        $i++;
                    }
                    $i = 0;
                    foreach($res as $el)
                    {
                        if ($el[0] == 2)
                            $perform_tests[$i] = $el;
                        $i++;
                    }
                ?>

                <?php if(count($example_tests) > 0): ?>
                <ul>
                    <li><b>Example Tests</b></li>
                    <?php foreach($example_tests as $item): ?>
                        <li><?=$item[1]?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <?php if(count($correct_tests) > 0): ?>
                <ul>
                    <li><b>Correct Tests</b></li>
                    <?php foreach($correct_tests as $item): ?>
                        <li><?=$item[1]?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if(isset($perform_tests)): ?>
                <?php if(count($perform_tests) > 0): ?>
                <ul>
                    <li>Perform Tests</li>
                    <?php foreach($perform_tests as $item): ?>
                        <li><?=$item[1]?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
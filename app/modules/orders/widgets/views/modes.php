<?php
use yii\helpers\Url;

$currService = Yii::$app->request->get('mode');

$params = Yii::$app->request->get();
?>
<th class="dropdown-th">
    <div class="dropdown">
        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <?= \Yii::t('app', 'orders.list.table.column.mode') ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <?php foreach ($modes as $id => $mode) { ?>
                <li>
                    <a href="<?= Url::to(array_merge(['/orders/list'], $params, ['mode' => $id])) ?>">
                        <?= Yii::t('app', $mode) ?>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</th>
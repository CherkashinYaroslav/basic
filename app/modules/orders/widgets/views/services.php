<?php
use yii\helpers\Url;

$currService = Yii::$app->request->get('service_id');

$params = Yii::$app->request->get();
?>
<th class="dropdown-th">
    <div class="dropdown">
        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <?= \Yii::t('app', 'orders.list.table.column.service') ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active">
                <?php
?>
                <a href="<?= Url::to(array_merge(['orders/list'], $params, ['service_id' => ''])) ?>">
                    <?= \Yii::t('app', 'orders.list.helpers.total') ?><?= " ($countServices)" ?>
                </a>
            </li>

            <?php foreach ($services as $service) { ?>
                <li>
                <a href="<?= Url::to(array_merge(['/orders/list'], $params, ['service_id' => $service['service_id']])) ?>">
                <span class="label-id">
                    <?= $service['cnt'] ?>
                </span><?= Yii::t('app',
                    'orders.list.service.name.'.str_replace(' ', '_', strtolower($service['name'])))?>
                </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</th>
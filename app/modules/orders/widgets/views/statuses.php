<?php

use yii\helpers\Url;

$params = Yii::$app->request->get();
unset($params['status']);

?>

<?php foreach ($statuses as $key => $status) { ?>
    <?php if ($status === Yii::$app->request->get('status')) { ?>
        <li class="active">
    <?php } else { ?>
        <li>
    <?php } ?>
        <a href="<?= Url::to(array_merge(["/orders/list/$status"], $params)) ?>">
            <?= Yii::t('app', $key) ?>
        </a>
    </li>
<?php } ?>
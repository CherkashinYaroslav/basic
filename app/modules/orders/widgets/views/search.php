<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'action' => ['/orders/list'],
    'method' => 'get',
    'options' => [
        'class' => 'form-inline',
    ],
    'fieldConfig' => [
        'template' => '{input}',
        'options' => ['tag' => false],
    ],
]);

?>
<div class="input-group">

    <?= $form->field($model, 'search')
        ->textInput(['class' => 'form-control', 'placeholder' => Yii::t('app', 'orders.list.search.input.placeholder'), 'name' => 'search'])
        ->label(false)
?>

    <span class="input-group-btn search-select-wrap">

            <?= $form->field($model, 'search_type')->dropDownList([
                $model::ID_SEARCH_PARAM_MAPPING => Yii::t('app', 'orders.list.search.type.order'),
                $model::LINK_SEARCH_PARAM_MAPPING => Yii::t('app', 'orders.list.search.type.link'),
                $model::USER_SEARCH_PARAM_MAPPING => Yii::t('app', 'orders.list.search.type.username'),
            ], ['class' => 'form-control search-select', 'name' => 'search_type'])->label(false) ?>
            <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-default']) ?>
         </span>
</div>

<?php ActiveForm::end(); ?>

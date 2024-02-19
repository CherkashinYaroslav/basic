
<nav class="navbar navbar-fixed-top navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Orders</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
    <?php

    use orders\widgets\languageSwitcher;
    use orders\widgets\ModeFilterWidget;
    use orders\widgets\pageCounterWidget;
    use orders\widgets\ServiceFilterWidget;
    use orders\widgets\TableVIewWidget;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\widgets\LinkPager;

    ?>
    <?= languageSwitcher::widget() ?>
  <table class="table order-table">
    <thead>
    <tr>
      <th>ID</th>
      <th><?php echo Yii::t('app', 'orders.list.table.column.user'); ?></th>
      <th><?php echo Yii::t('app', 'orders.list.table.column.link'); ?></th>
      <th><?php echo Yii::t('app', 'orders.list.table.column.quantity'); ?></th>
        <?= ServiceFilterWidget::widget(['counterSer' => $counterSer]) ?>

      <th><?php echo Yii::t('app', 'orders.list.table.column.status'); ?></th>
        <?= ModeFilterWidget::widget(['model' => $model]) ?>
      <th><?php echo Yii::t('app', 'orders.list.table.column.created'); ?></th>
    </tr>
    </thead>
    <tbody>
        <?= TableVIewWidget::widget(['provider' => $provider]) ?>
    </tbody>
  </table>
  <div class="row">
    <div class="col-sm-8">
        <?php
    $form = ActiveForm::begin([
        'method' => 'GET',
        'action' => Url::to(['csv/export'.'?'.http_build_query(Yii::$app->request->queryParams)]),
        'enableClientScript' => true,
    ]);
    ?>
        <?= Html::submitButton(Yii::t('app', 'orders.list.button.export_csv'), ['class' => 'btn btn-default']) ?>
        <?php ActiveForm::end(); ?>
      <nav>
          <?= LinkPager::widget(['pagination' => $pages]); ?>
      </nav>


    </div>
    <div class="col-sm-4 pagination-counters">
        <?= PageCounterWidget::widget(['provider' => $provider]) ?>
</div>
  </div>
</div>

<script src=<?php echo '"';
    echo Yii::getAlias('@web/js/jquery.min.js');
    echo '"' ?>></script>
    <script src=<?php echo '"';
    echo Yii::getAlias('@web/js/bootstrap.min.js');
    echo '"' ?>></script>

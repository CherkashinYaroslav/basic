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
    use orders\widgets\ServiceFilterWidget;
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
        <?php
        foreach ($provider->getModels() as $m) {
            $status = Yii::t('app',
                'orders.list.status.'.str_replace(' ', '_',strtolower($m->statusMapping()[$m->status])));
            $mode = Yii::t('app', 'orders.list.mode.'.strtolower($m->modeMapping()[$m->mode]));
            $name = $m->users->first_name;
            $surname = $m->users->last_name;
            $serviceName = Yii::t('app',
                'orders.list.service.name.'.str_replace(' ', '_', strtolower($m->services->name)));
            $serviceId = $m->services->id;
            $date = date('Y-m-d', $m->created_at);
            $clock = date('H:m:s', $m->created_at);
            echo "<tr>
                      <td>$m->id</td>
                      <td>$name $surname</td>
                      <td class=\"link\">$m->link</td>
                      <td>$m->quantity</td>
                      <td class=\"service\">
                        <span class=\"label-id\">$serviceId</span>$serviceName
                      </td>
                      <td>$status </td>
                      <td>$mode</td>
                      <td><span class=\"nowrap\">$date</span><span class=\"nowrap\">$clock</span></td>
                    </tr>
                    ";
        }
    ?>
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
        <?php
    if ($provider->totalCount > 100) {
        echo $provider->pagination->page * $provider->pagination->limit.' to';
        echo ($provider->pagination->page + 1) * $provider->pagination->limit.'of';
    }
    ?>
        <?php echo $provider->totalCount ?>
</div>
  </div>
</div>

<script src=<?php echo '"';
    echo Yii::getAlias('@web/js/jquery.min.js');
    echo '"' ?>></script>
    <script src=<?php echo '"';
    echo Yii::getAlias('@web/js/bootstrap.min.js');
    echo '"' ?>></script>

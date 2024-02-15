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

    use app\widgets\languageSwitcher;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\widgets\LinkPager;
    use yii\widgets\Menu;

    echo Menu::widget([
        'items' => [
            ['label' => \Yii::t('app', 'All'), 'url' => ['orders/list']],
            ['label' => \Yii::t('app', 'Pending'), 'url' => ['orders/list/Pending']],
            ['label' => \Yii::t('app', 'In progress'), 'url' => ['orders/list/In progress']],
            ['label' => \Yii::t('app', 'Completed'), 'url' => ['orders/list/Completed']],
            ['label' => \Yii::t('app', 'Canceled'), 'url' => ['orders/list/Canceled']],
            ['label' => \Yii::t('app', 'Error'), 'url' => ['orders/list/Error']],
        ],
        'options' => [
            'class' => 'nav nav-tabs p-b',
        ],
        'linkTemplate' => '<a href="{url}"><span>{label}</span></a>',

    ]);
    ?>
  <ul class="nav nav-tabs p-b">

    <li class="pull-right custom-search">
        <?php
        ActiveForm::begin([
            'method' => 'GET',
            'action' => Url::to(['orders/list', 'status' => isset(Yii::$app->request->queryParams['status']) ? Yii::$app->request->queryParams['status'] : '']),
            'enableClientScript' => true,
            'class' => 'form-inline',
        ]); ?>

        <?= Html::input('text', 'search', '', ['placeholder' => \Yii::t('app', 'Search orders'), 'class' => 'form-control search-select']) ?>
        <?= Html::dropDownList('search-type', [],
            [
                \Yii::t('app', 'Order'),
                \Yii::t('app', 'Link'),
                \Yii::t('app', 'Username'),
            ],
            ['label' => 'Please select']) ?>
        <?= Html::submitButton('', ['value' => 'print', 'class' => 'btn btn-default glyphicon glyphicon-search']) ?>
        <?php ActiveForm::end(); ?>
    </li>
  </ul>
    <?= languageSwitcher::Widget() ?>




  <table class="table order-table">
    <thead>
    <tr>
      <th>ID</th>
      <th><?php echo \Yii::t('app', 'User'); ?></th>
      <th><?php echo \Yii::t('app', 'Link'); ?></th>
      <th><?php echo \Yii::t('app', 'Quantity'); ?></th>
      <th class="dropdown-th">
        <div class="dropdown">
          <?php echo \Yii::t('app', 'Service'); ?>

          <?php
          echo " <br> <span>Total $provider->totalCount</span>"; ?>
          <?php
          usort($counter_ser, function ($a, $b) {
              return (int) ($a['cnt'] < $b['cnt']);
          });
    $itemArr = [];
    foreach ($counter_ser as $serv) {
        $name = \Yii::t('app', $serv['name']);
        $ctn = $serv['cnt'];
        $itemArr[$serv['service_id']] = $ctn.' '.$name;
    }

    ActiveForm::begin([
        'method' => 'GET',
        'action' => Url::to(['orders/list']),
        'enableClientScript' => true,
    ]); ?>


        <?= Html::dropDownList('service_id', [],
            $itemArr,
            ['label' => 'Please select']) ?>
        </div>
      </th>
      <th><?php echo \Yii::t('app', 'Status'); ?></th>
      <th class="dropdown-th">
        <div class="dropdown">
              <?php echo \Yii::t('app', 'Mode'); ?>
              <?= Html::dropDownList('mode', [],
                  array_map(function ($mode) {
                      return \Yii::t('app', $mode);
                  }, $model->modeMapping()),
                  ['label' => 'Please select']) ?>
        </div>
      </th>
      <th><?php echo \Yii::t('app', 'Created'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
                  foreach ($provider->getModels() as $m) {
                      $status = \Yii::t('app', $m->statusMapping()[$m->status]);
                      $mode = Yii::t('app', $m->modeMapping()[$m->mode]);
                      $name = $m->users->first_name;
                      $surname = $m->users->last_name;
                      $serviceName = \Yii::t('app', $m->services->name);
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
    <?= Html::submitButton(\Yii::t('app', 'Search'), ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>
  <div class="row">
    <div class="col-sm-8">
        <?php
    $form = ActiveForm::begin([
        'method' => 'GET',
        'action' => Url::to(['csv/export'.'?'.http_build_query(Yii::$app->request->queryParams)]),
        'enableClientScript' => true,
    ]); ?>

        <?= Html::submitButton('Export CSV', ['name' => 'print', 'class' => 'btn btn-default']) ?>
        <?php ActiveForm::end(); ?>
      <nav>

          <?= LinkPager::widget([
              'pagination' => $pages,
          ]); ?>
      </nav>


    </div>
    <div class="col-sm-4 pagination-counters">
        <?php
        if ($provider->totalCount > 100) {
            echo $provider->pagination->page * $provider->pagination->limit.' to';
            echo ($provider->pagination->page + 1) * $provider->pagination->limit.'of';
        }?>
        <?php echo $provider->totalCount ?>
</div>
x
  </div>
</div>

<script src=<?php echo '"';
    echo Yii::getAlias('@web/js/jquery.min.js');
    echo '"' ?>></script>
    <script src=<?php echo '"';
    echo Yii::getAlias('@web/js/bootstrap.min.js');
    echo '"' ?>></script>

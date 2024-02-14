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
  <ul class="nav nav-tabs p-b">
    <li class="active"><a href="#"><?php echo \Yii::t('app', 'All orders'); ?></a></li>
    <li><a href="#"><?php echo \Yii::t('app', 'Pending'); ?></a></li>
    <li><a href="#"><?php echo \Yii::t('app', 'In progress'); ?></a></li>
    <li><a href="#"><?php echo \Yii::t('app', 'Completed'); ?></a></li>
    <li><a href="#"><?php echo \Yii::t('app', 'Canceled'); ?></a></li>
    <li><a href="#"><?php echo \Yii::t('app', 'Error'); ?></a></li>
    <li class="pull-right custom-search">
      <form class="form-inline" action="/admin/orders" method="get">
        <div class="input-group">
          <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
          <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="1" selected=""><?php echo \Yii::t('app', 'Order'); ?> ID</option>
              <option value="2"><?php echo \Yii::t('app', 'Link'); ?></option>
              <option value="3"><?php echo \Yii::t('app', 'Username'); ?></option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
      </form>
    </li>
  </ul>
    <div class="dropdown">
        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <?php echo \Yii::t('app', 'Lang'); ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="">Русский</a></li>
            <li><a href="">Английский</a></li>
        </ul>
    </div>
  <table class="table order-table">
    <thead>
    <tr>
      <th>ID</th>
      <th><?php echo \Yii::t('app', 'User'); ?></th>
      <th><?php echo \Yii::t('app', 'Link'); ?></th>
      <th><?php echo \Yii::t('app', 'Quantity'); ?></th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <?php echo \Yii::t('app', 'Service'); ?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <?php
          echo "<li class=\"active\"><a href=\"\">All $provider->totalCount</a></li>";
    foreach ($counter_ser as $serv) {
        $name = \Yii::t('app', $serv['name']);
        $ctn = $serv['cnt'];
        echo "<li><a href=\"\"><span class=\"label-id\">$ctn</span>$name</a></li>";
    }

    ?>
          </ul>
        </div>
      </th>
      <th><?php echo \Yii::t('app', 'Status'); ?></th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <?php echo \Yii::t('app', 'Mode'); ?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="">All</a></li>
            <li><a href="">Manual</a></li>
            <li><a href="">Auto</a></li>
          </ul>
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
  <div class="row">
    <div class="col-sm-8">

      <nav>
        <ul class="pagination">
          <li class="disabled"><a href="" aria-label="Previous">&laquo;</a></li>
          <li class="active"><a href="">1</a></li>
          <li><a href="">2</a></li>
          <li><a href="">3</a></li>
          <li><a href="">4</a></li>
          <li><a href="">5</a></li>
          <li><a href="">6</a></li>
          <li><a href="">7</a></li>
          <li><a href="">8</a></li>
          <li><a href="">9</a></li>
          <li><a href="">10</a></li>
          <li><a href="" aria-label="Next">&raquo;</a></li>
        </ul>
      </nav>


    </div>
    <div class="col-sm-4 pagination-counters">
        <?php echo $provider->pagination->page * $provider->pagination->limit ?> to <?php echo ($provider->pagination->page + 1) * $provider->pagination->limit ?> of <?php echo $provider->totalCount ?>
</div>

  </div>
</div>

<script src=<?php echo "\""; echo Yii::getAlias('@web/js/jquery.min.js'); echo "\"" ?>></script>
    <script src=<?php echo "\""; echo Yii::getAlias('@web/js/bootstrap.min.js'); echo "\"" ?>></script>

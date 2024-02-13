<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    .label-default{
    border: 1px solid #ddd;
      background: none;
      color: #333;
      min-width: 30px;
      display: inline-block;
    }
  </style>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
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
    <li class="active"><a href="#">All orders</a></li>
    <li><a href="#">Pending</a></li>
    <li><a href="#">In progress</a></li>
    <li><a href="#">Completed</a></li>
    <li><a href="#">Canceled</a></li>
    <li><a href="#">Error</a></li>
    <li class="pull-right custom-search">
      <form class="form-inline" action="/admin/orders" method="get">
        <div class="input-group">
          <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
          <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="1" selected="">Order ID</option>
              <option value="2">Link</option>
              <option value="3">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
      </form>
    </li>
  </ul>
  <table class="table order-table">
    <thead>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Link</th>
      <th>Quantity</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Service
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
<!--          --><?php
//          echo "<li class=\"active\"><a href=\"\">All $counter->all</a></li>";
//          foreach ($counter->unique as $k => $serv) {
//              echo "<li><a href=\"\"><span class=\"label-id\">$serv</span>$k</a></li>";
//          }
//
//          ?>
          </ul>
        </div>
      </th>
      <th>Status</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Mode
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="">All</a></li>
            <li><a href="">Manual</a></li>
            <li><a href="">Auto</a></li>
          </ul>
        </div>
      </th>
      <th>Created</th>
    </tr>
    </thead>
    <tbody>
    <?php
              foreach ($provider->models as $m) {
                  $status = $m->statusMapping()[$m->status];
                  $mode = $m->modeMapping()[$m->mode];
                  $name = $m->users->first_name;
                  $surname = $m->users->last_name;
                  $date = date('Y-m-d', $m->created_at);
                  $clock = date('H:m:s', $m->created_at);
                  echo "<tr>
      <td>$m->id</td>
      <td>$name $surname</td>
      <td class=\"link\">$m->link</td>
      <td>$m->quantity</td>
      <td class=\"service\">
        <span class=\"label-id\">service</span>service
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
        <?php echo $provider->pagination->page ?> to <?php echo $provider->pagination->limit ?> of <?php echo $provider->totalCount ?>
</div>

  </div
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
<html>

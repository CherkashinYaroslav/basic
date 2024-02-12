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
          <?php
          $s = [];
          $total = 0;
          foreach ($q as $q_s)
          {
              if (array_key_exists($q_s['service_id'], $q_s))
              {
                  $s[$q_s['service_id']] +=1;
              } else
              {
                  $s[$q_s['service_id']] =1;
              }
          }
          $total = $p['totalCount'];
          echo "<li class=\"active\"><a href=\"\">All $total</a></li>";

          foreach ($s as $k=>$v)
          {
              echo "<li><a href=\"\"><span class=\"label-id\">$v</span>$k</a></li>";
          }



          ?>
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
    var_dump($p);
    foreach ($q as $s_q)
    {
        $id = $s_q["id"];
        $user = $s_q['user_id'];
        $link = $s_q['link'];
        $quantity = $s_q['quantity'];
        $service = $s_q['service_id'];
        $status = $s_q['status'];
        $created_at = date("Y-m-d",$s_q['created_at']);
        $created_clock = date("H:m:s",$s_q['created_at']);
        $mode = $s_q['mode'];
        echo "<tr>
      <td>$id</td>
      <td>$user</td>
      <td class=\"link\">$link</td>
      <td>$quantity</td>
      <td class=\"service\">
        <span class=\"label-id\">$service</span>$service
      </td>
      <td>$status</td>
      <td>$mode</td>
      <td><span class=\"nowrap\">$created_at</span><span class=\"nowrap\">$created_clock</span></td>
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
        <?php echo $p['offset'] ?> to <?php echo $p['offset'] + 100 ?> of <?php echo $p['totalCount'] ?>
</div>

  </div
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
<html>

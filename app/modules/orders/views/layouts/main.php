<?php

use app\assets\AppAsset;

?>

<?php AppAsset::register($this); ?>

<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->title ?></title>
        <style>
            .label-default{
                border: 1px solid #ddd;
                background: none;
                color: #333;
                min-width: 30px;
                display: inline-block;
            }
        </style>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>


    <div class="container-fluid">

        <?= $this->render('filters'); ?>


        <?= $content ?>

    </div>

    <?php $this->endBody(); ?>
    </body>
    <html>
<?php $this->endPage(); ?>
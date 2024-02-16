<?php

namespace orders;

use Yii;

class OrderModule extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__.'/config.php');
    }
}

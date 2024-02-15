<?php

namespace modules\orders;

use Yii;
use yii\base\BootstrapInterface;

class OrderModule extends \yii\base\Module implements BootstrapInterface
{
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__.'/config.php');
    }

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\web\UrlRule',
                'pattern' => 'orders/list/<status>',
                'route' => 'orders/list',
            ],
        ]);
    }
}

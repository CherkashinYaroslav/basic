<?php

namespace orders\widgets;

use orders\models\Orders;
use orders\models\search\OrdersSearch;
use yii\base\Widget;

class ModeFilterWidget extends Widget
{
    /**
     * @var OrdersSearch
     */
    public $model;

    public function run()
    {

        return $this->render('modes', [
            'modes' => [
                Orders::AUTO_ID => 'orders.list.mode.auto',
                Orders::MANUAL_ID => 'orders.list.mode.manual',
            ],
        ]);
    }
}

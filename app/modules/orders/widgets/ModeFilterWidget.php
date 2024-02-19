<?php

namespace orders\widgets;

use orders\models\search\OrdersSearch;
use yii\base\Widget;

class ModeFilterWidget extends Widget
{
    /**
     * @var OrdersSearch asd
     */
    public $model;

    public function run()
    {

        return $this->render('modes', [
            'modes' => [
                $this->model->getModel()::AUTO_ID => 'orders.list.mode.auto',
                $this->model->getModel()::MANUAL_ID => 'orders.list.mode.manual',
            ],
        ]);
    }
}

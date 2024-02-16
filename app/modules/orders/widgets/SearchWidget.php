<?php

namespace orders\widgets;

use orders\models\search\OrdersSearch;
use Yii;
use yii\base\Widget;

class SearchWidget extends Widget
{
    public function run()
    {
        $model = new OrdersSearch();
        $model->loadParams(Yii::$app->request->queryParams);

        return $this->render('search', [
            'model' => $model,
        ]);
    }
}

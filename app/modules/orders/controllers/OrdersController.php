<?php

namespace orders\controllers;

use orders\models\search\OrdersSearch;
use Yii;

/**
 * Класс контроллера заказов
 */
class OrdersController extends BaseAccessController
{
    /**
     * На основе переданных параметров запроса status, mode, service_id, search, search-type возращает вьб с данными
     *
     * @return string
     */
    public function actionList()
    {
        $model = new OrdersSearch();

        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', ['model' => $model, 'provider' => $dataProvider,
            'counterSer' => $model->searchFoCounter(Yii::$app->request->queryParams)->asArray()->all(),
            'pages' => $dataProvider->pagination]);
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}

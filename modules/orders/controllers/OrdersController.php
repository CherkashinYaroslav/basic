<?php

namespace modules\orders\controllers;

use modules\orders\models\search\OrdersSearch;
use Yii;

/**
 * Класс контроллера заказов
 */
class OrdersController extends BaseAccessController
{
    /**
     * На основе переданных параметров запроса status, mode, service_id, search, search-type возращает вьб с данными
     * @return string
     */
    public function actionList()
    {
        $model = new OrdersSearch();

        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('orders', ['model' => $model, 'provider' => $dataProvider,
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}

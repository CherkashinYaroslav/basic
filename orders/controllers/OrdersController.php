<?php

namespace orders\controllers;

use orders\models\search\OrdersSearch;
use Yii;

class OrdersController extends BaseAccessController
{
    public function actionList()
    {
        $model = new OrdersSearch();

        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('orders', ['model' => $model, 'provider' => $dataProvider,
            'counterSer' => $model->searchFoCounter(Yii::$app->request->queryParams)->asArray()->all(),
            'pages' => $dataProvider->pagination]);
    }

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

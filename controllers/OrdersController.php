<?php

namespace app\controllers;

use app\models\OrderModel;
use app\models\search\OrdersSearch;
use Yii;
use yii\data\Pagination;

class OrdersController extends BaseAccessController
{
    public function actionBase()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $a = new OrderModel();
        $q = $a->initQuery()->applyFilters()->applySorter()->applySearcher()->getQuery();
        $pagination = new Pagination(['totalCount' => $q->count(), 'pageSizeLimit' => [1, 100], 'defaultPageSize' => 100]);

        return array_map(function ($row) {
            $row['status'] = OrderModel::$STATUS_MAPPING[(int) $row['status']];
            $row['mode'] = OrderModel::$MODE_MAPPING[(int) $row['mode']];

            return $row;
        },
            $q->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->all());

    }

    //
    public function actionIndex()
    {
        $model = new OrdersSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('orders', ['model' => $model, 'provider' => $dataProvider,
            'counter_ser' => $model->searchFoCounter(Yii::$app->request->queryParams)->asArray()->all(),
            'pages' => $dataProvider->pagination]);
    }

    public function beforeAction($action)
    {
        if (Yii::$app->request->get('lang') != null) {
            Yii::$app->language = Yii::$app->request->get('lang');
        }

        return true;
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

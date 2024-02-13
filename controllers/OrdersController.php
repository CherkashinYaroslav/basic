<?php

namespace app\controllers;

use app\models\OrderModel;
use app\models\search\OrdersSearch;
use app\counter\Counter;
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

    public function actionGetStatuses()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return OrderModel::$STATUS_MAPPING;
    }

    public function actionGetModes()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return OrderModel::$MODE_MAPPING;
    }

    //
    public function actionIndex()
    {
        $model = new OrdersSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $counter = new Counter();
        $counter->countUniqueSum($dataProvider->query, 'service_id');

        return $this->render('orders', ['model' => $model, 'provider' => $dataProvider]);
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

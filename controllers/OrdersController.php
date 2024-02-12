<?php

namespace app\controllers;

use app\models\OrderModel;
use app\models\ServiceModel;
use app\models\UserModel;
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

    public function actionIndex()
    {
        $model = new OrderModel();
        $q = $model->initQuery()->applyFilters()->applySorter()->applySearcher()->getQuery();
        $pagination = new Pagination(['totalCount' => $q->count(), 'pageSizeLimit' => [1, 100], 'defaultPageSize' => 100]);

        $pagVal['offset'] = $pagination->offset;
        $pagVal['limit'] = $pagination->limit;
        $pagVal['totalCount'] = $q->count();


        $q = array_map(function ($row) {
            $row['status'] = OrderModel::$STATUS_MAPPING[(int) $row['status']];
            $row['mode'] = OrderModel::$MODE_MAPPING[(int) $row['mode']];
            $row['service_id'] = ServiceModel::find()->where(['id' => $row['service_id']])->asArray()->all()[0]['name'];
            $u = UserModel::find()->where(['id' => $row['user_id'] ])->asArray()->all()[0];
            $row['user_id'] = $u['first_name'] . " " . $u['last_name'];
            return $row;
        },
            $q->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->all());




        return $this->render('orders', ["q" => $q, 'p' => $pagVal]);
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

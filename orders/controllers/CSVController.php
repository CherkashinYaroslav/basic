<?php

namespace orders\controllers;

use orders\models\search\OrdersSearch;
use orders\services\CSVService;
use Yii;

class CsvController extends BaseAccessController
{
    public function actionExport()
    {

        $model = new OrdersSearch();
        $csvFileName = date('Y-m-d H:-m-s').'.csv';
        header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.$csvFileName);
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');

        return CSVService::createCSV($model->search(Yii::$app->request->queryParams)->query, ['id' => ['Raw'],
            'mode' => ['Raw'],
            'user_id' => ['Raw'],
            'link' => ['Raw'],
            'quantity' => ['Raw'],
            'service_id' => ['Raw'],
            'status' => ['Raw'],
            'created_at' => ['Datetime']], $csvFileName);
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

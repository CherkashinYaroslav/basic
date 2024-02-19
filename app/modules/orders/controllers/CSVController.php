<?php

namespace orders\controllers;

use orders\models\search\OrdersSearch;
use orders\services\CSVService;
use Yii;

/**
 * Класс контроллера CSV генератора
 */
class CsvController extends BaseAccessController
{
    /**
     * Создает csv документ на основе переданных параметров запроса
     *
     * @return string
     */
    public function actionExport()
    {

        $model = new OrdersSearch();
        $csvFileName = date('Y-m-d H:-m-s').'.csv';
        header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.$csvFileName);
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        $model->loadParams(Yii::$app->request->queryParams);

        return CSVService::createCSV($model->search()->query, ['id' => ['Raw'],
            'mode' => ['Raw'],
            'user_id' => ['Raw'],
            'link' => ['Raw'],
            'quantity' => ['Raw'],
            'service_id' => ['Raw'],
            'status' => ['Raw'],
            'created_at' => ['Datetime']]);
    }
}

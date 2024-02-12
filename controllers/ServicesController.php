<?php

namespace app\controllers;

use app\models\ServiceModel;

class ServicesController extends BaseAccessController
{
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ServiceModel::find()->where(['name' => \Yii::$app->request->get('service')])->asArray()->all();
    }
}

<?php

namespace app\controllers;

use app\models\UserModel;

class UserController extends BaseAccessController
{
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return UserModel::find()->where(['first_name' => \Yii::$app->request->get('first_name'),
            'last_name' => \Yii::$app->request->get('last_name')])->asArray()->all();
    }
}

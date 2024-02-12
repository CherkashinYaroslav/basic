<?php

namespace app\filters;

use yii\db\ActiveQuery;

class ServiceFilter implements FilterInterface
{
    public static function column(): string
    {
        return 'service_id';
    }

    public static function requestKey(): string
    {
        return 'service_id';
    }

    public static function apply(ActiveQuery $model): ActiveQuery
    {
        if (\Yii::$app->request->get(self::requestKey()) == null) {
            return $model;
        }

        return $model->andWhere([self::column() => (int) \Yii::$app->request->get(self::requestKey())]);
    }
}

<?php

namespace app\filters;

use yii\db\ActiveQuery;

class StatusFilter implements FilterInterface
{
    public static function column(): string
    {
        return 'status';
    }

    public static function requestKey(): string
    {
        return 'status';
    }

    public static function apply(ActiveQuery $model): ActiveQuery
    {
        if (\Yii::$app->request->get(self::requestKey()) == null) {
            return $model;
        }

        return $model->andWhere([self::column() => \Yii::$app->request->get(self::requestKey())]);
    }
}

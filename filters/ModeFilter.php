<?php

namespace app\filters;

use yii\db\ActiveQuery;

class ModeFilter implements FilterInterface
{
    public static function column(): string
    {
        return 'mode';
    }

    public static function requestKey(): string
    {
        return 'mode';
    }

    public static function apply(ActiveQuery $model): ActiveQuery
    {
        if (\Yii::$app->request->get(self::requestKey()) == null) {
            return $model;
        }

        return $model->andWhere([self::column() => (int) \Yii::$app->request->get(self::requestKey())]);
    }
}

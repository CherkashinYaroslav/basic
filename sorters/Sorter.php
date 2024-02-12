<?php

namespace app\sorters;

use yii\db\ActiveQuery;

final class Sorter
{
    public const string KEY = 'sort';

    public static function run(ActiveQuery $query): ActiveQuery
    {
        $sortData = self::sortData();
        if ($sortData == null) {
            return $query;
        }
        $orderRules = [];
        foreach ($sortData as $sortField) {
            $orderRules[str_replace('-', '', $sortField)] = str_contains($sortField, '-') ? SORT_DESC : SORT_ASC;
        }

        return $query->orderBy($orderRules);
    }

    public static function key(): string
    {
        return self::KEY;
    }

    public static function sortData()
    {
        if (\Yii::$app->request->get(self::key()) == null) {
            return null;
        } else {
            return explode(';', \Yii::$app->request->get(self::key()));
        }
    }
}

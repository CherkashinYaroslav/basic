<?php

namespace app\searcher;

use yii\db\ActiveQuery;

final class Searcher
{
    public const string KEY = 'search';

    public static function run(ActiveQuery $query): ActiveQuery
    {
        $searchData = self::sortData();
        if ($searchData == null) {
            return $query;
        }
        $searchRules = [];
        foreach ($searchData as $sortField) {
            $exploded = explode('=', $sortField);
            $searchRules[$exploded[0]] = $exploded[1];
        }

        return $query->where($searchRules);
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

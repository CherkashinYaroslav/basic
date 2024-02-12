<?php

namespace app\filters;

use yii\db\ActiveQuery;

interface FilterInterface
{
    public static function column(): string;

    public static function requestKey(): string;

    public static function apply(ActiveQuery $model): ActiveQuery;
}

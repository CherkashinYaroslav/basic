<?php

namespace app\models;

use yii\db\ActiveRecord;

class ServiceModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'services';
    }
}

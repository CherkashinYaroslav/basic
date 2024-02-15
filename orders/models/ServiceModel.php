<?php

namespace orders\models;

use yii\db\ActiveRecord;

/**
 * Класс модели сервисов
 */
class ServiceModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'services';
    }
}

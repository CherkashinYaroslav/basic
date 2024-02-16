<?php

namespace orders\models;

use yii\db\ActiveRecord;

/**
 * Класс модели пользователей
 */
class Users extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'users';
    }
}

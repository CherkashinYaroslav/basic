<?php

namespace modules\orders\models;

use yii\db\ActiveRecord;

/**
 * Класс модели пользователей
 */
class UserModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'users';
    }
}

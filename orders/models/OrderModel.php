<?php

namespace orders\models;

use yii\db\ActiveRecord;

class OrderModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [
                ['service_id'],
                'exist', 'skipOnError' => true,
                'targetClass' => ServiceModel::class,
                'targetAttribute' => ['service_id' => 'id'],
            ],
            [
                ['user_id'],
                'exist', 'skipOnError' => true,
                'targetClass' => UserModel::class,
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }

    public function getUsers()
    {
        return $this->hasOne(UserModel::class, ['id' => 'user_id']);
    }

    public function getServices()
    {
        return $this->hasOne(ServiceModel::class, ['id' => 'service_id']);
    }

    public function statusMapping()
    {
        return [0 => 'Pending', 1 => 'In progress',
            2 => 'Completed', 3 => 'Canceled', 4 => 'Error'];
    }

    public function modeMapping()
    {
        return [0 => 'Manual', 1 => 'Auto'];
    }
}

<?php

namespace orders\models;

use yii\db\ActiveRecord;

/**
 * Класс модели заказов
 */
class OrderModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * Устанавливает связь с таблицей пользователей
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(UserModel::class, ['id' => 'user_id']);
    }

    /**
     * Устанавливает свзяь с таблицей сервисов
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(ServiceModel::class, ['id' => 'service_id']);
    }

    /**
     * Возвращает сопоставление айди status  к названиюы
     * @return string[]
     */
    public function statusMapping()
    {
        return [0 => 'Pending', 1 => 'In progress',
            2 => 'Completed', 3 => 'Canceled', 4 => 'Error'];
    }

    /**
     * Возвращает сопастовление айди mode к названию
     * @return string[]
     */
    public function modeMapping()
    {
        return [0 => 'Manual', 1 => 'Auto'];
    }
}

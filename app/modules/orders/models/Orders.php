<?php

namespace orders\models;

use yii\db\ActiveRecord;

/**
 * Класс модели заказов
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status
 * @property int $created_at
 * @property int $mode
 */
class Orders extends ActiveRecord
{
    /**
     * @var int айди статуса pending
     */
    public const int PENDING_ID = 0;

    /**
     * @var int айди статуса In progress
     */
    public const int IN_PROGRESS_ID = 1;

    /**
     * @var int айди статуса Completed
     */
    public const int COMPLETED_ID = 2;

    /**
     * @var int айди статуса Canceled
     */
    public const int CANCELED_ID = 3;

    /**
     * @var int айди статуса Error
     */
    public const int ERROR_ID = 4;

    /**
     * @var int айди мода Manual
     */
    public const int MANUAL_ID = 0;

    /**
     * @var int айди мода Auto
     */
    public const int AUTO_ID = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * Устанавливает связь с таблицей пользователей
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Устанавливает свзяь с таблицей сервисов
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * Возвращает сопоставление айди status  к названиюы
     *
     * @return string[]
     */
    public static function statusMapping()
    {
        return [self::PENDING_ID => 'Pending', self::IN_PROGRESS_ID => 'In progress',
            self::COMPLETED_ID => 'Completed', self::CANCELED_ID => 'Canceled', self::ERROR_ID => 'Error'];
    }

    /**
     * Возвращает сопастовление айди mode к названию
     *
     * @return string[]
     */
    public static function modeMapping()
    {
        return [self::MANUAL_ID => 'Manual', self::AUTO_ID => 'Auto'];
    }
}

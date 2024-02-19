<?php

namespace orders\models;

use Yii;
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
     * Возврщает текущий статус модели
     * @return string
     */
    public function getStatus()
    {
        return Yii::t('app', $this->statusMapping()[$this->status]);
    }

    /**
     * Возвращает текущий способ управления модели
     * @return string
     */
    public function getMode()
    {
        return Yii::t('app', $this->modeMapping()[$this->mode]);
    }

    /**
     * Возвращает полное имя пользователя
     * @return string
     */
    public function getUserFullName()
    {
        return $this->users->last_name.' '.$this->users->first_name;
    }

    /**
     * Возврщает текущее имя сервиса модели
     * @return string
     */
    public function getServiceNane()
    {
        return Yii::t('app',
            'orders.list.service.name.'.str_replace(' ', '_', strtolower($this->services->name)));
    }

    /**
     * Возвращает дайеттайм создания
     * @return string
     */
    public function getFullDatetime()
    {
        return date('Y-m-d', $this->created_at).' '.date('H:m:s', $this->created_at);
    }

    /**
     * Возвращает айди сервиса
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->services->id;
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
        return [
            self::PENDING_ID => 'orders.list.status.pending',
            self::IN_PROGRESS_ID => 'orders.list.status.in_progress',
            self::COMPLETED_ID => 'orders.list.status.completed',
            self::CANCELED_ID => 'orders.list.status.canceled',
            self::ERROR_ID => 'orders.list.status.error',
        ];
    }

    /**
     * Возвращает сопастовление айди mode к названию
     *
     * @return string[]
     */
    public static function modeMapping()
    {
        return [
            self::MANUAL_ID => 'orders.list.mode.manual',
            self::AUTO_ID => 'orders.list.mode.auto',
        ];
    }
}

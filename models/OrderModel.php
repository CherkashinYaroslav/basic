<?php

namespace app\models;

use app\filters\ModeFilter;
use app\filters\ServiceFilter;
use app\filters\StatusFilter;
use app\searcher\Searcher;
use app\sorters\Sorter;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class OrderModel extends ActiveRecord
{
    //серч модели
    //дата провайдеры
    //что тогда деать с хтмл
    //виджеты?
    //
    //    private array $filters = [ModeFilter::class, ServiceFilter::class, StatusFilter::class];

    //    private $sorter = Sorter::class;

    //    private ActiveQuery $query;

    //    private $counter = Searcher::class;

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
    //    public function initQuery()
    //    {
    //        $this->query = $this::find();
    //
    //        return $this;
    //    }
    //
    //    public function applyFilters()
    //    {
    //        foreach ($this->filters as $filter) {
    //            $this->query = $filter::apply($this->query);
    //        }
    //
    //        return $this;
    //    }
    //
    //    public function applySorter()
    //    {
    //        $this->sorter::run($this->query);
    //
    //        return $this;
    //    }
    //
    //    public function applySearcher()
    //    {
    //        $this->counter::run($this->query);
    //
    //        return $this;
    //    }
    //
    //    public function getQuery()
    //    {
    //        return $this->query;
    //    }
}

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
    private array $filters = [ModeFilter::class, ServiceFilter::class, StatusFilter::class];

    private $sorter = Sorter::class;

    private ActiveQuery $query;

    private $searcher = Searcher::class;

    public static array $STATUS_MAPPING = [0 => 'Pending', 1 => 'In progress',
        2 => 'Completed', 3 => 'Canceled', 4 => 'Error'];

    public static array $MODE_MAPPING = [0 => 'Manual', 1 => 'Auto'];

    public static function tableName()
    {
        return 'orders';
    }

    public function getUsers()
    {
        return $this->hasOne(UserModel::class, ['user_id' => 'id']);
    }

    public function getServices()
    {
        return $this->hasOne(ServiceModel::class, ['service_id' => 'id']);
    }

    public function initQuery()
    {
        $this->query = $this::find();

        return $this;
    }

    public function applyFilters()
    {
        foreach ($this->filters as $filter) {
            $this->query = $filter::apply($this->query);
        }

        return $this;
    }

    public function applySorter()
    {
        $this->sorter::run($this->query);

        return $this;
    }

    public function applySearcher()
    {
        $this->searcher::run($this->query);

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }
}

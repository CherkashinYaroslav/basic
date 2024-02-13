<?php

namespace app\models\search;

use app\models\OrderModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class OrdersSearch extends OrderModel
{
    public $mode;

    public $service_id;

    public $status;

    public $user;

    public function search($params)
    {
        $query = OrderModel::find();
        $query->joinWith('users', 'services');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => $this->sort(),
            ],
        ]);
        $this->loadParams($params);

        $query->andFilterWhere([
            'mode' => $this->mode,
            'service_id' => $this->service_id,
            'status' => $this->status,
        ]);

        if (! Yii::$app->request->get('page')) {
            $dataProvider->pagination->page = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize) - 1;
        }

        return $dataProvider;
    }

    private function loadParams($params)
    {
        $attributes = array_flip($this->attributes());
        foreach ($params as $name => $value) {
            if (isset($attributes[$name])) {
                $this->$name = $value;
            }
        }
    }

    private function paginate()
    {
        return new Pagination(['pageSizeLimit' => [1, 100], 'defaultPageSize' => 100]);
    }

    private function tran()
    {

    }

    private function sort(): array
    {
        return ['id' => SORT_DESC];
    }
}

<?php

namespace orders\models\search;

use orders\models\OrderModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class OrdersSearch extends OrderModel
{
    public $mode;

    public $id;

    public $status;

    public $user;

    public $link;

    public $username;

    public function search($params)
    {
        $query = OrderModel::find();
        $query->joinWith(['users', 'services']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => $this->sort(),
            ],
        ]);
        $params = $this->prepareParams($params);
        $this->loadParams($params);

        $query->andFilterWhere([
            'mode' => $this->mode,
            'service_id' => $this->service_id,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'orders.id', $this->id])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'users.first_name', $this->user_id]);

        if (! Yii::$app->request->get('page')) {
            $dataProvider->pagination->page = 0;
        }

        return $dataProvider;
    }

    public function searchFoCounter($params)
    {
        //        select count(service_id), services.name, service_id  from orders
        //                      JOIN services ON orders.service_id=services.id
        //              group by services.name, service_id
        $query = OrderModel::find()->select(['COUNT(service_id) AS cnt', 'services.name', 'service_id']);
        $query->joinWith(['services']);

        $this->loadParams($params);

        $query->andFilterWhere([
            'mode' => $this->mode,
            'service_id' => $this->service_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'orders.id', $this->id])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'users.first_name', $this->user_id]);

        $query->groupBy(['services.name', 'service_id']);

        return $query;

    }

    private function prepareParams($params)
    {
        $paramSearchMapping = [0 => 'id', 1 => 'link', 2 => 'user_id'];
        if (isset($params['search-type'])) {
            $params[$paramSearchMapping[$params['search-type']]] = $params['search'];
        }

        return $params;
    }

    private function loadParams($params)
    {
        $attributes = array_flip($this->attributes());
        foreach ($params as $name => $value) {
            if (isset($attributes[$name])) {
                if ($name == 'status') {
                    $statusFlip = array_flip($this->statusMapping());
                    $this->$name = $statusFlip[$value];
                } else {
                    $this->$name = $value;
                }
            }
        }
    }

    private function paginate()
    {
        return new Pagination(['pageSizeLimit' => [1, 100], 'defaultPageSize' => 100]);
    }

    private function sort(): array
    {
        return ['id' => SORT_DESC];
    }
}

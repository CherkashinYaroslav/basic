<?php

namespace modules\orders\models\search;

use modules\orders\models\OrderModel;
use modules\orders\models\ServiceModel;
use modules\orders\models\UserModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\db\QueryInterface;

/**
 *  Класс модели поиска заказов
 *
 */
class OrdersSearch extends OrderModel
{
    /**
     * @var int айди типа управления заказа
     */
    public $mode;

    /**
     * @var int айди заказа
     */
    public $id;

    /**
     * @var string наименование статуса заказа
     */
    public $status;

    /**
     * @var int айди пользователя, к которому привязан заказ
     */
    public $user;

    /**
     * @var string ссылка на заказ
     */
    public $link;

    /**
     * @var string имя пользователя к которому пирвязан заказ
     */
    public $username;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [
                ['service_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ServiceModel::class,
                'targetAttribute' => ['service_id' => 'id'],
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => UserModel::class,
                'targetAttribute' => ['user_id' => 'id'],
            ],
            [
                ['status'],
                'in' => $this->statusMapping()
            ],
            [
                ['mode'],
                'in' => array_keys($this->modeMapping())
            ]
        ];
    }


    /**
     * На основе переданных параметров осущесвтялет выборку из базы и заполняет ДатаПроавйдер
     * @param array $params
     * @return ActiveDataProvider
     */
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

        $query = $this->baseQueryFiltre($query);


        if (! Yii::$app->request->get('page')) {
            $dataProvider->pagination->page = 0;
        }

        return $dataProvider;
    }

    /**
     *  На основе переданных параметров осущесвтялет выборку из базы и заполняет ДатаПроавйдер для подсчета сервисов
     * @param array $params
     * @return \yii\db\ActiveQuery
     */
    public function searchFoCounter($params)
    {
        $query = OrderModel::find()->select(['COUNT(service_id) AS cnt', 'services.name', 'service_id']);
        $query->joinWith(['services']);
        $query = $this->baseQueryFiltre($query);
        $this->loadParams($params);


        $query->groupBy(['services.name', 'service_id']);

        return $query;

    }

    /**
     * Алгоритм базовой фильтрации записей
     * @param ActiveQuery $query
     * @return ActiveQuery
     */
    private function baseQueryFiltre(ActiveQuery $query)
    {
        $query->andFilterWhere([
            'mode' => $this->mode,
            'service_id' => $this->service_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'orders.id', $this->id])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'users.first_name', $this->user_id]);

        return $query;
    }

    /**
     * Форматирует параметры перед их использоваием
     * @param array $params
     * @return mixed
     */
    private function prepareParams($params)
    {
        $paramSearchMapping = [0 => 'id', 1 => 'link', 2 => 'user_id'];
        if (isset($params['search-type'])) {
            $params[$paramSearchMapping[$params['search-type']]] = $params['search'];
        }

        return $params;
    }

    /**
     * Передает параметры в атрибуты модели
     * @param array $params
     * @return void
     */
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

    /**
     * @return Pagination
     */
    private function paginate()
    {
        return new Pagination(['pageSizeLimit' => [1, 100], 'defaultPageSize' => 100]);
    }

    /**
     * @return array
     */
    private function sort(): array
    {
        return ['id' => SORT_DESC];
    }
}

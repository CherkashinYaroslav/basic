<?php

namespace orders\models\search;

use orders\models\Orders;
use orders\models\Services;
use orders\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use function Symfony\Component\String\s;

/**
 *  Класс модели поиска заказов
 */
class OrdersSearch extends Orders
{
    /**
     * @var int айди типа управления заказа
     */
    public $mode;

    public $search;

    public $search_type;

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

    public const int ID_SEARCH_PARAM_MAPPING = 0;

    public const int LINK_SEARCH_PARAM_MAPPING = 1;

    public const int USER_SEARCH_PARAM_MAPPING = 2;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            //            [
            //                ['service_id'],
            //                'exist',
            //                'skipOnError' => true,
            //                'targetClass' => Services::class,
            //                'targetAttribute' => ['service_id' => 'id'],
            //            ],
            //            [
            //                ['user_id'],
            //                'exist',
            //                'skipOnError' => true,
            //                'targetClass' => Users::class,
            //                'targetAttribute' => ['user_id' => 'id'],
            //            ],
            //            [
            //                ['status'], 'in' => $this->statusMapping(),
            //            ],
            //            [
            //                ['mode'], 'in' => array_keys($this->modeMapping()),
            //            ],
        ];
    }

    /**
     * На основе переданных параметров осущесвтялет выборку из базы и заполняет ДатаПроавйдер
     *
     * @param  array  $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();
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
     *
     * @param  array  $params
     * @return \yii\db\ActiveQuery
     */
    public function searchFoCounter($params)
    {
        $query = Orders::find()->select(['COUNT(service_id) AS cnt', 'services.name', 'service_id']);
        $query->joinWith(['services', 'users']);
        $query = $this->baseQueryFiltre($query);
        $this->loadParams($params);

        $query->groupBy(['services.name', 'service_id']);

        return $query;

    }

    /**
     * Алгоритм базовой фильтрации записей
     *
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
            ->andFilterWhere(['like', 'concat(users.first_name, \' \', users.last_name)', $this->user_id]);

        return $query;
    }

    /**
     * Форматирует параметры перед их использоваием
     *
     * @param  array  $params
     * @return mixed
     */
    private function prepareParams($params)
    {
        $paramSearchMapping = [self::ID_SEARCH_PARAM_MAPPING => 'id',
            self::LINK_SEARCH_PARAM_MAPPING => 'link',
            self::USER_SEARCH_PARAM_MAPPING => 'user_id'];
        if (isset($params['search_type'])) {
            $params[$paramSearchMapping[$params['search_type']]] = $params['search'];
        }

        return $params;
    }

    /**
     * Передает параметры в атрибуты модели
     *
     * @param  array  $params
     * @return void
     */
    public function loadParams($params)
    {
        $params = $this->prepareParams($params);
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

    private function sort(): array
    {
        return ['id' => SORT_DESC];
    }
}

<?php

namespace orders\models\search;

use orders\models\Orders;
use orders\models\Services;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use function Symfony\Component\String\s;

/**
 *  Класс модели поиска заказов
 * {@inheritDoc} не определять типы у свойст
 */
class OrdersSearch extends Model
{
    /**
     * @var int айди типа управления заказа
     */
    public $mode;

    /**
     * @var string данные для поиска по одному из полей id, user, link
     */
    public $search;

    /**
     * @var int тип поиска, принимает значения ID_SEARCH_PARAM_MAPPING, USER_SEARCH_PARAM_MAPPING , LINK_SEARCH_PARAM_MAPPING
     */
    public $search_type;

    /**
     * @var int айди заказа
     */
    public $id;

    /**
     * @var int айди сервиса
     */
    public $service_id;

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
     * @var int айди статуса
     */
    public $statusId;

    /**
     * @var int константа соответствия значения типа поиска к типу поиска
     */
    public const int ID_SEARCH_PARAM_MAPPING = 0;

    /**
     * @var int константа соответствия значения типа поиска к типу поиска
     */
    public const int LINK_SEARCH_PARAM_MAPPING = 1;

    /**
     * @var int константа соответствия значения типа поиска к типу поиска
     */
    public const int USER_SEARCH_PARAM_MAPPING = 2;

    public const int PAGE_SIZE = 100;

    public const PENDING_STATUS = 'Pending';
    public const IN_PROGRESS_STATUS = 'In progress';
    public const COMPLETED_STATUS = 'Completed';
    public const CANCELED_STATUS = 'Canceled';
    public const ERROR_STATUS = 'Error';

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [
                ['search_type'], 'in', 'range' => [self::ID_SEARCH_PARAM_MAPPING, self::LINK_SEARCH_PARAM_MAPPING, self::USER_SEARCH_PARAM_MAPPING],
            ],
            [
                ['service_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Services::class,
                'targetAttribute' => ['service_id' => 'id'],
            ],
            [
                ['status'], 'in', 'range' => $this->statusResolve(),
            ],
            [
                ['mode'], 'in', 'range' => array_keys(Orders::modeMapping()),
            ],
        ];
    }

    /**
     * На основе переданных параметров осущесвтялет выборку из базы и заполняет ДатаПроавйдер
     *
     * @param  array  $params
     * @return ActiveDataProvider|false
     */
    public function search()
    {
        if (! $this->validate()) {
            return false;
        }
        $this->transformParams();

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

        $this->baseQueryFiltre($query);

        if (! Yii::$app->request->get('page')) {
            $dataProvider->pagination->page = 0;
        }

        return $dataProvider;
    }

    /**
     *  На основе переданных параметров осущесвтялет выборку из базы и заполняет ДатаПроавйдер для подсчета сервисов
     *
     * @param  array  $params
     * @return \yii\db\ActiveQuery|false
     */
    public function searchFoCounter()
    {
        if (! $this->validate()) {
            return false;
        }
        $this->transformParams();
        $query = Orders::find()->select(['COUNT(service_id) AS cnt', 'services.name', 'service_id']);
        $query->joinWith(['services', 'users']);
        $query = $this->baseQueryFiltre($query);
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
            'status' => $this->statusId,
        ]);

        $query->andFilterWhere(['like', 'orders.id', $this->id])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'concat(users.first_name, \' \', users.last_name)', $this->user]);

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
            self::USER_SEARCH_PARAM_MAPPING => 'user'];
        if (isset($params['search_type'])) {
            $params[$paramSearchMapping[$params['search_type']]] = $params['search'];
        }

        return $params;
    }

    /**
     * Трансформирует параметры модели для дальнейшей работы с ними
     *
     * @return void
     */
    private function transformParams()
    {
        $statusFlip = array_flip($this->statusResolve());
        if (array_key_exists($this->status, $statusFlip)) {
            $this->statusId = $statusFlip[$this->status];
        } else {
            $this->statusId = '';
        }
    }

    private function statusResolve()
    {
        return [
            Orders::PENDING_ID => self::PENDING_STATUS,
            Orders::IN_PROGRESS_ID => self::IN_PROGRESS_STATUS,
            Orders::COMPLETED_ID => self::COMPLETED_STATUS,
            Orders::CANCELED_ID => self::CANCELED_STATUS,
            Orders::ERROR_ID => self::ERROR_STATUS,
        ];
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
                $this->$name = $value;
            }
        }
    }

    /**
     * Получение правил пагинации
     *
     * @return Pagination
     */
    private function paginate()
    {
        return new Pagination(['pageSizeLimit' => [1, self::PAGE_SIZE], 'defaultPageSize' => self::PAGE_SIZE]);
    }

    /**
     * Получени правил сортировки
     */
    private function sort(): array
    {
        return ['id' => SORT_DESC];
    }
}

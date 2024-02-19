<?php

namespace orders\controllers;

use orders\errors\ValidationError;
use orders\models\search\OrdersSearch;
use Yii;

/**
 * Класс контроллера заказов
 */
class OrdersController extends BaseAccessController
{
    /**
     * Обработчик ошибок
     *
     * @return string|void
     */
    public function actionError()
    {
        $exception = Yii::$app->getErrorHandler()->exception;

        if ($exception) {
            return $this->render('../layouts/main');
        }
    }

    /**
     * На основе переданных параметров запроса status, mode, service_id, search, search-type возращает вьб с данными
     *
     * @return string
     */
    public function actionList()
    {
        $model = new OrdersSearch();
        $model->loadParams(Yii::$app->request->queryParams);

        if (! ($dataProvider = $model->search())) {
            throw new ValidationError(404, $model->getErrors());
        }

        return $this->render('index', ['model' => $model, 'provider' => $dataProvider,
            'counterSer' => $model->searchFoCounter()->asArray()->all(),
            'pages' => $dataProvider->pagination, 'exception' => null]);
    }
}

<?php

namespace orders\errors;

use yii\web\HttpException;

/**
 * Ошибка валидации данных
 */
class ValidationError extends HttpException
{
    public function __construct($status, $messages = null)
    {
        $this->statusCode = $status;
        parent::__construct($status, json_encode($messages, JSON_UNESCAPED_UNICODE));
    }
}

<?php

namespace orders\widgets;

use yii\base\Widget;

class pageCounterWidget extends Widget
{
    public $provider;

    public function run()
    {
        return $this->render('pageCounter', [
            'provider' => $this->provider,
        ]);
    }
}

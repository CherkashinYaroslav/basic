<?php

namespace orders\widgets;

use yii\base\Widget;

class TableVIewWidget extends Widget
{
    public $provider;

    public function run()
    {

        return $this->render('tableView', [
            'provider' => $this->provider,
        ]);
    }
}

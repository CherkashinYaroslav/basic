<?php

namespace orders\widgets;

use yii\bootstrap5\Widget;

class ServiceFilterWidget extends Widget
{
    public $counterSer;

    public function run()
    {
        usort($this->counterSer, function ($a, $b) {
            return (int) ($a['cnt'] < $b['cnt']);
        });

        $count = 0;
        foreach ($this->counterSer as $ser) {
            $count += $ser['cnt'];
        }

        return $this->render('services', [
            'services' => $this->counterSer,
            'countServices' => $count,
        ]);
    }
}

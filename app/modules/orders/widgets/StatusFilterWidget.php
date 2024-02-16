<?php

namespace orders\widgets;

use yii\bootstrap5\Widget;

class StatusFilterWidget extends Widget
{
    public function run()
    {
        return $this->render('statuses', [
            'statuses' => [
                'orders.list.status.all' => '',
                'orders.list.status.pending' => 'Pending',
                'orders.list.status.in_progress' => 'In progress',
                'orders.list.status.completed' => 'Completed',
                'orders.list.status.canceled' => 'Canceled',
                'orders.list.status.error' => 'Error',
            ],
        ]);
    }
}

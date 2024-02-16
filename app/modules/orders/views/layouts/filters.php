<?php
use orders\widgets\SearchWidget;
use orders\widgets\StatusFilterWidget;

?>
<ul class="nav nav-tabs p-b">
    <?= StatusFilterWidget::widget()?>
    <li class="pull-right custom-search">
        <?= SearchWidget::widget() ?>
    </li>
</ul>

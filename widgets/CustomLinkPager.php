<?php

namespace app\widgets;

use yii\widgets\LinkPager;

class CustomLinkPager extends LinkPager
{
    public $activePageCssClass = 'active';

    public $disableCurrentPageButton = false;

    public $disabledPageCssClass = 'disabled';

    public $maxButtonCount = 10;

    public $nextPageLabel = 'Previous';

    public $prevPageLabel = 'Next';
}

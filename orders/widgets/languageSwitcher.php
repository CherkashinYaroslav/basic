<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Url;

class languageSwitcher extends Widget
{
    public $languages = [
        'en-US' => 'English',
        'ru-RU' => 'Russian',
    ];

    public function init()
    {
        parent::init();
        $session = Yii::$app->session;
        $languageNew = Yii::$app->request->get('language');
        if ($languageNew) {
            if (isset($this->languages[$languageNew])) {
                Yii::$app->language = $languageNew;
                $session->set('language', $languageNew);
            }
        } elseif ($session->has('language')) {
            Yii::$app->language = $session->get('language');
        }

    }

    public function run()
    {
        $languages = $this->languages;
        $current = $languages[Yii::$app->language];
        unset($languages[Yii::$app->language]);

        $items = [];
        foreach ($languages as $code => $language) {
            $temp = [];
            $temp['label'] = $language;
            $temp['url'] = Url::current(['language' => $code]);
            array_push($items, $temp);
        }

        echo ButtonDropdown::widget([
            'label' => $current,
            'dropdown' => [
                'items' => $items,
            ],
        ]);
    }
}
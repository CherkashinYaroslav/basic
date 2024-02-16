<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Url;

/**
 * Класс виджета переключения языка
 */
class languageSwitcher extends Widget
{
    /**
     * массив хранащий сопастовление намиенований языков к их iso формату
     *
     * @var string[]
     */
    public array $languages = [
        'en-US' => 'language.english',
        'ru-RU' => 'language.russian',
    ];

    /**
     * @return void
     */
    public function init()
    {
        parent::init();
        $session = Yii::$app->session;
        $languageNew = Yii::$app->request->get('language');
        if ($languageNew) {
            if (isset($this->languages[$languageNew]) and $languageNew != $session->get('language')) {
                Yii::$app->language = $languageNew;
                Yii::$app->sourceLanguage = $session->get('language');
                $session->set('language', $languageNew);
            } else {
                Yii::$app->sourceLanguage = "ln-UN";
                Yii::$app->language =  $session->get('language');
            }
        }
    }

    /**
     * @return void
     *
     * @throws \Throwable
     */
    public function run()
    {
        $languages = $this->languages;
        $current = $languages[Yii::$app->language];
        unset($languages[Yii::$app->language]);

        $items = [];
        foreach ($languages as $code => $language) {
            $temp = [];
            $temp['label'] = Yii::t("app", $language);
            $temp['url'] = Url::current(['language' => $code]);
            array_push($items, $temp);
        }

        echo ButtonDropdown::widget([
            'label' => Yii::t('app', 'language.change'),
            'dropdown' => [
                'items' => $items,
            ],
        ]);
    }
}
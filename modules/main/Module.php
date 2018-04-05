<?php

namespace modules\main;

use Yii;

/**
 * main module definition class
 */
class Module extends \yii\base\Module
{
    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => \yii\filters\RateLimiter::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\main\controllers\frontend';

    /**
     * @var boolean If the module is used for the admin panel.
     */
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // It's here to switch between the frontend and backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\main\controllers\backend';
            $this->setViewPath('@modules/main/views/backend');
        } else {
            $this->setViewPath('@modules/main/views/frontend');
        }
    }

    /**
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/main/' . $category, $message, $params, $language);
    }
}

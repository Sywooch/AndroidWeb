<?php

namespace app\controllers;

use yii\web\Controller;

class FrontendController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error')
            $this->layout = 'main.php';

        return parent::beforeAction($action);
    }
}
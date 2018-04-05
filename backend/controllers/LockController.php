<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use modules\users\models\LoginForm;
use modules\users\Module;
use yii\helpers\Url;

class LockController extends Controller
{   
    public $username;
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($previous){
        $this->layout = 'lockscreen';
        if(isset(Yii::$app->user->identity->username)){
            // save current username    
            $full_name = Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name;
            $email = Yii::$app->user->identity->email;

            if (Yii::$app->user->identity->avatar != null) {
                $upload = Yii::$app->getModule('users')->uploads;
                $path = Url::to(Yii::$app->urlManagerBackend->createUrl('') . $upload . '/' . Yii::$app->user->identity->id . '/' . Yii::$app->user->identity->avatar,true);
            }else{
                $path = null;
            }

            // force logout     
            Yii::$app->user->logout();
            // render form lockscreen
            $model = new LoginForm(); 
            $model->full_name = $full_name;    //set default value 
            $model->email = $email;    //set default value 
            return $this->render('lockscreen', [
                'model' => $model,
                'previous' => $previous,
                'path' =>$path
            ]);  
        }
        else{
            return $this->redirect(['/users/login']);
        }
    }
}
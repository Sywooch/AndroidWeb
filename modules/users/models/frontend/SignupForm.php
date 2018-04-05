<?php
namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use modules\users\widgets\passfield\Passfield;
use modules\users\widgets\passfield\assets;
use modules\users\models\User;


class SignupForm extends Model
{   
    public $username;
    public $first_name;
    public $last_name;
    public $mobile;
    public $email;
    public $mobile_otp;
    public $mobile_otp_status;
    public $last_login_ip;
    public $last_login_date;
    public $balance;
    public $permission;
    public $password;
    public $confirm_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['first_name', 'string', 'min' => 3, 'max' => 100],

            ['last_name', 'trim'],
            ['last_name', 'required'],
            ['last_name', 'string', 'min' => 3, 'max' => 100],

            ['mobile', 'trim'],
            ['mobile', 'required'],
            ['mobile', 'unique', 'targetClass' => '\modules\users\models\User', 'message' => 'This mobile no has already been taken.'],
            ['mobile', 'string','min'=>10,'max'=>10],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\modules\users\models\User', 'message' => 'This email address has already been taken.'],

            ['last_login_ip', 'trim'],
            ['last_login_date', 'trim'],

            ['permission', 'trim'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['confirm_password', 'required'],
            ['confirm_password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->mobile.'_'.$this->first_name;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->mobile = $this->mobile;
        $user->email = $this->email;

        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = User::STATUS_WAIT;

        $user->mobile_otp_status = User::STATUS_WAIT;
        $user->generateEmailConfirmToken();
                //print_r("hello");exit();

        if ($user->save(false)) {
           // print_r("hi");exit();
                Yii::$app->mailer->compose(['html' => '@common/mail/emailConfirm'], ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('The message was successfully sent!' . ' ' . Yii::$app->name)
                    ->send();

                return $user;
            }
    }
}

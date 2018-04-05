<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\Controller;
use modules\users\models\User;
use modules\rbac\models\Permission;

class AuthController extends Controller
{	
	private $_user;

	protected function verbs()
	{
	   return [
	     'login' => ['POST'],
         'signup' =>['POST'],
         
	   ];
	}
    /**
     * @return string
     */
    public function actionSignup()
    {
    $garage_owner_name = !empty($_POST['garage_owner_name'])?$_POST['garage_owner_name']:'';
    $customer_name = !empty($_POST['customer_name'])?$_POST['customer_name']:'';
    $email = !empty($_POST['email'])?$_POST['email']:'';
    $password = !empty($_POST['password'])?$_POST['password']:'';
    $phone = !empty($_POST['phone'])?$_POST['phone']:'';
    $response = [];
    if(empty($email) || empty($password) || empty($garage_owner_name) || empty($customer_name) || empty($phone)){
      $response = [
      	'status'=>404,
        'success' => false,
        'message' => 'user registration Failed ! Datas are not sufficient !',
      ];
    }
    else{
       $x = User::find()->where(['email'=>$email])->one();
       $y = User::find()->where(['mobile'=>$phone])->one();
       if($x || $y){
	       	$response = [
	      	'status'=>500,
	        'success' => false,
	        'message' => 'user with this Email or Phone Already exist !',
	      ];
       }else{
       	 $user = new User();

         $user->role = $user::RBAC_DEFAULT_ROLE;

       	$user->username = $phone.'_'.$garage_owner_name;
        $user->first_name = $garage_owner_name;
        $user->last_name = $garage_owner_name;
        $user->mobile = $phone;
        $user->email = $email;
        $user->garage_owner_name = $garage_owner_name;
        $user->customer_name = $customer_name;
        $user->type = 1;

        $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->mobile_otp_status = User::STATUS_ACTIVE;

        $data=$user->save(false) ? $user : null;
        if($data){
          $authManager = Yii::$app->getAuthManager();
          $role = $authManager->getRole($user->role);
          $authManager->assign($role, $data->id);


        $this->login($email);
        if(is_null($data)){
        	$response = [
	      	'status'=>500,
	        'success' => false,
	        'message' => 'Some error Occured!',
	      ];
        }else{
        	$response = [
	      	'status'=>200,
	        'success' => true,
	        'message' => 'user registration success',
	        'results' => Yii::$app->user->identity
	      ];
        }
      }
       }
    }

    return $response;
    }

     public function actionLogin()
    {
  
    $email = !empty($_POST['email'])?$_POST['email']:'';
    $password = !empty($_POST['password'])?$_POST['password']:'';
  
    $response = [];
    if(empty($email) || empty($password)){
      $response = [
      	'status'=>404,
        'success' => false,
        'message' => 'user Login Failed ! Datas are not sufficient !',
      ];
    }
    else{
       $x = User::find()->where(['email'=>$email])->one();

       if(!$x){
	       	$response = [
	      	'status'=>500,
	        'success' => false,
	        'message' => 'User not found.If you are a new User Please Login !',
	      ];
       }else{
       		$bool = $this->validatePassword($password,$email);
       		if($bool == false){
       			$response = [
		      	'status'=>200,
		        'success' => false,
		        'message' => 'Sorry!Password Mismatched!',
		      ];
       		}else{
       		  $this->login($email);
       			$response = [
		      	'status'=>200,
		        'success' => true,
		        'message' => 'user successfully login',
		        'results' => Yii::$app->user->identity
		      ];
       		}
    	}
    	}
    	return $response;
	}

     protected function validatePassword($password,$email)
    {
     
            $user = $this->getUser($email);
            if (!$user || !$user->validatePassword($password)) {
                return false;
            }else{
            	return true;
            }
    }

    protected function login($email)
    {	
       $rememberMe = 1;
       return Yii::$app->user->login($this->getUser($email), $rememberMe ? 3600 * 24 * 30 : 0);  
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser($email)
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsernameEmail($email);
        }
        return $this->_user;
    }

}
?>
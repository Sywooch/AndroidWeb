<?php

namespace modules\users\controllers\frontend;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use modules\users\models\frontend\User;
use modules\users\models\UploadForm;
use yii\web\UploadedFile;
use modules\users\models\frontend\SignupForm;
use modules\users\models\LoginForm;
use modules\users\models\frontend\EmailConfirmForm;
use modules\users\models\frontend\ResetPasswordForm;
use modules\users\models\frontend\PasswordResetRequestForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use modules\users\Module;
use common\models\CartData;
use common\models\Category;
use common\models\Product;

/**
 * Class ProfileController
 * @package modules\users\controllers\frontend
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'logout' => ['post'],
                    'delete' => ['post'],
                ],
            ],
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],*/
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * @return array|string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $model = $this->findModel();
        $user_role = $model->getUserRoleValue();
        $model->role = $user_role ? $user_role : $model::RBAC_DEFAULT_ROLE;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdatePassword()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
                // Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
              Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' =>Module::t('module', 'Password changed successfully.'),
              ]);
        }
        return $this->redirect(['update', 'tab' => 'password']);
    }

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateProfile()
    {
        $model = $this->findModel();
        $user_role = $model->getUserRoleValue();
        $model->role = $user_role ? $user_role : $model::RBAC_DEFAULT_ROLE;
        $model->scenario = $model::SCENARIO_PROFILE_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Yii::$app->session->setFlash('success', Module::t('module', 'Profile successfully changed.'));
            Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' => Module::t('module', 'Profile successfully changed.'),
              ]);
        }
        return $this->redirect(['update', 'tab' => 'profile']);
    }

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateAvatar()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_AVATAR_UPDATE;
        $avatar = $model->avatar;
        if ($model->load(Yii::$app->request->post()) && ($model->scenario === $model::SCENARIO_AVATAR_UPDATE)) {
            if ($model->isDel) {
                if ($avatar) {
                    $upload = Yii::$app->getModule('users')->uploads;
                    $path = str_replace('\\', '/', Url::to('@upload') . DIRECTORY_SEPARATOR . $upload . DIRECTORY_SEPARATOR . $model->id);
                    $avatar = $path . '/' . $avatar;
                    if (file_exists($avatar))
                        unlink($avatar);
                    $model->avatar = null;
                    $model->save();
                }
            }
            $uploadModel = new UploadForm();
            if ($uploadModel->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                $uploadModel->upload();
        }
        return $this->redirect(['update', 'tab' => 'avatar']);
    }

    /**
     * Deletes an existing User model.
     * This delete set status blocked, is successful, logout and the browser will be redirected to the 'home' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_PROFILE_DELETE;
        $model->status = $model::STATUS_DELETED;
        if ($model->save())
            Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //update user last login

            $user_id = Yii::$app->user->identity->id;
            $user = User::findOne($user_id);
            $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
            $user->islogged = 1;
            $user->save(false);


            //cart exist
            $cart_details = Yii::$app->session->get('cart_details');
            if(!empty($cart_details)){
                $exploded_string = explode('##', $cart_details);
            foreach ($exploded_string as $str) {
                    $exp_comma = explode(',',$str,-1);

                    if(!empty($exp_comma)){
                     $product_id = $exp_comma[0];
                     $product_quantity = $exp_comma[1];
                     $id = explode('pid:',$product_id);
                     $quan = explode('pq:',$product_quantity);
                     $prdt_id = $id[1];
                     $prdt_quantity = $quan[1];
                     //Yii::$app->runAction('site/update-cart',['id'=>$prdt_id,'quantity'=>$prdt_quantity]);
                     $this->updatecart($prdt_id,$prdt_quantity);
                    }
                   
                }
            }
            //product exist
            $cart_data = new CartData();
            $cart_details = $cart_data->getString(Yii::$app->user->identity['id']);
            
            if(!empty($cart_details)){
                $exploded_string = explode('##', $cart_details['prdt_details']);
                foreach ($exploded_string as $str) {
                    $exp_comma = explode(',',$str,-1);

                    if(!empty($exp_comma)){
                     $product_id = $exp_comma[0];
                     $product_quantity = $exp_comma[1];
                     $id = explode('pid:',$product_id);
                     $quan = explode('pq:',$product_quantity);
                     $prdt_id = $id[1];
                     $prdt_quantity = $quan[1];
                     print_r($prdt_id);

                     //Yii::$app->runAction('site/update-cart',['id'=>$prdt_id,'quantity'=>$prdt_quantity]);
                     $this->updatecart($prdt_id,$prdt_quantity);
                    }
                   
                }
            }
            //print_r($cart_details);exit();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {   
        //Yii::$app->session->set('cart_details', '');
        //update user login status
        $user_id = Yii::$app->user->identity->id;
        $user = User::findOne($user_id);
        $user->islogged = 0;
        $user->save();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                // Yii::$app->getSession()->setFlash('success', Module::t('module', 'It remains to activate the account.'));
                Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' => Module::t('module', 'It remains to activate the account.Please check your mail.'),
              ]);
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            // Yii::$app->getSession()->setFlash('success', Module::t('module', 'Thank you for registering!'));
            Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' => Module::t('module', 'Thank you for registering!'),
              ]);
        } else {
            // Yii::$app->getSession()->setFlash('error', Module::t('module', 'Error sending message!'));
             Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger',
                'message' => Module::t('module', 'Error sending message!'),
              ]);
        }

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                // Yii::$app->session->setFlash('success', Module::t('module', 'Check your email for further instructions.'));
                Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' => Module::t('module', 'Check your email for further instructions.'),
              ]);
                return $this->goHome();
            } else {
                // Yii::$app->session->setFlash('error', Module::t('module', 'Sorry, we are unable to reset password.'));
                Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger',
                'message' => Module::t('module', 'Sorry, we are unable to reset password.'),
              ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            // Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
            Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' =>Module::t('module', 'Password changed successfully.'),
              ]);

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        $id = Yii::$app->user->identity->getId();
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
        }
    }

    public function actionVerifyMobile(){
        if (Yii::$app->request->isAjax) {
        $data = Yii::$app->request->post();
        $phone = Yii::$app->user->identity->mobile;
         echo \russ666\widgets\Countdown::widget([
        'datetime' => date('Y-m-d H:i:s O', time() + 70),
        'format' => '%M:%S',
        'events' => [
            'finish' => 'function(){
             // location.reload()
             $("#verify_btn").prop("disabled", false);
             $("#test").text("Have not recived OTP yet?Please resend otp again");
            }',
        ],
        ]);
           $mobile_rand = mt_rand(100000, 999999);
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->mobile_otp = $mobile_rand;
            $user->save();
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://msg.hcit.in/ComposeSMS.aspx?username=autokartzcom&password=23208&sender=ATOKRT&to=$phone&message=".urlencode("Your OTP is : $mobile_rand ,Do not Share With anyone.")."&priority=1&dnd=1&unicode=0");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    public function actionCheckOtp(){
        if (Yii::$app->request->isAjax) {
        $otp = Yii::$app->request->post()['otp'];
        $user = User::findOne(Yii::$app->user->identity->id);
        $mobile_otp = $user->mobile_otp;
        if($mobile_otp == $otp){
            $user->mobile_otp = null;
            $user->mobile_otp_status = 1;
            $user->save();
            // Yii::$app->session->setFlash('success', 'mobile successfully verified');
             Yii::$app->getSession()->setFlash('success', [
                'type' => '',
                'message' =>'mobile successfully verified',
              ]);
        }else{
          Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger',
                'message' =>'invalid otp!',
              ]);
            // Yii::$app->session->setFlash('error', 'invalid otp!');
        }
                    
        }
    }

     public function updatecart($id = null,$quantity = null)
    {
        if (Yii::$app->request->isAjax) {
        $data = Yii::$app->request->post();
        //print_r($data);exit();
        $product_id = $data['id'];
        $no_item = $data['quantity'];
      }else{
        $data = Yii::$app->request->post();
        $product_id = $id;
        $no_item = $quantity;
      }
        $product = Product::findOne($product_id);
        if($product){
          if(yii::$app->user->isGuest){
            \Yii::$app->cart->update($product, $no_item);
                  $str = $this->cartData($product_id,1);
                    $cart_data = new CartData();
                    $session_id = Yii::$app->session->getId();
                    if($cart_data->findBysession($session_id) == 0){
                       $cart_data->saveCartData($str);
                    }else{
                       $cart_data->updateCartData($str);
                    }
                  }else{
                    $cart_data = new CartData();
                    $cart_details = $cart_data->getString(Yii::$app->user->identity['id']);
                    if(!empty($cart_details['prdt_details'])){
                      Yii::$app->session->set('cart_details', $cart_details['prdt_details']);
                    }
                    //print_r(Yii::$app->session->get('cart_details'));exit();
                    \Yii::$app->cart->update($product, $no_item);
                    $str = $this->cartData($product_id,1);
                    $cart_data = new CartData();
                    $session_id = Yii::$app->session->getId();
                    if($cart_data->findById($session_id) == 0){
                       $cart_data->saveCartDataById($str);
                    }else{
                       $cart_data->updateCartDataById($str);
                    }
                  }

            

            $cart = \Yii::$app->cart;
            $products_items = $cart->getItems();
            $array = [];
              foreach($products_items as $x){
              if($x->prdt_id == $product_id){
                    $count = $products_items[$product_id]['_quantity'];
                    $price = $products_items[$product_id]['_quantity'] * $this->getDiscountCost($product_id);
                    $total_count = \Yii::$app->cart->getCount();
                    $total_price =$this->getTotalAfterDiscount();
                    $tax_price = $this->getTaxAmount();
                    $total_price_tax_inc = $total_price+$tax_price;
                    $array = ['total_count'=>$total_count,'price'=>$price,'total_price'=>$total_price,'count'=>$count,'tax_amount'=>$tax_price,'final_price_tax_inc'=>$total_price_tax_inc];
                    echo json_encode($array);
                   }
            }
        }
    //  }
    }

    public function cartData($product_id,$qty){

      $cart = \Yii::$app->cart;
       $products_items = $cart->getItems();
       if(!empty($products_items)){
        $data = empty(Yii::$app->session->get('cart_details'))?$this->str:Yii::$app->session->get('cart_details');
        foreach ($products_items as $product) {

          $single_product_quantity = $products_items[$product_id]['_quantity'];
          $single_product_price = $this->getDiscountCost($product_id);
          if(Yii::$app->session->get('cart_details') == ''){
            $data .= 'pid:'.$product_id.','.'pq:'.$single_product_quantity.','.'pc:'.$single_product_price."##";
            Yii::$app->session->set('cart_details', $data);
          }else{

            if(preg_match('/'.'pid:'.$product_id.'/',Yii::$app->session->get('cart_details'))){
              //echo "hi";
              $exploded_string = explode('##',Yii::$app->session->get('cart_details'));
              foreach ($exploded_string as $x) {
              $data = str_replace('pid:'.$product_id.',pq:'.($single_product_quantity-$qty).',pc:'.$single_product_price, 'pid:'.$product_id.',pq:'.($single_product_quantity).',pc:'.$single_product_price,$data);
                }
              Yii::$app->session->set('cart_details', $data);
              //echo "hello";
              }else{
                $data = Yii::$app->session->get('cart_details');
                $data .= 'pid:'.$product_id.',pq:'.$single_product_quantity.',pc:'.$single_product_price."##";
              Yii::$app->session->set('cart_details', $data);
              }
           }
        }
    }
     return Yii::$app->session->get('cart_details');
  }

   public function getDiscountCost($id){
    $product = Product::findOne($id);
    $actual_cost = $product->price;
    $discount = is_null($product->discount)?null:$product->discount;
    if(!is_null($discount)){
      $cost = $actual_cost - (($actual_cost*$discount)/100);
    }else{
      $cost = $actual_cost;
    }
    return $cost;
  }

  public function getTotalAfterDiscount(){
      $cart_data =  new CartData();
      if(Yii::$app->user->isGuest){
        if($cart_data->findBysession(Yii::$app->session->getId()
)>0){
          $cart_details = $cart_data->getStringSession(Yii::$app->session->getId())['prdt_details'];
            $exploded_string = explode('##', $cart_details);
            $total_cost = 0;
            foreach ($exploded_string as $str) {
                    $exp_comma = explode(',',$str);
                    if(!empty($exp_comma)){
                      if(!empty($exp_comma[0])){
                        // print_r($exp_comma);
                        $product_id = $exp_comma[0];
                     $product_quantity = $exp_comma[1];
                     $product_cost = $exp_comma[2];
                     $id = explode('pid:',$product_id);
                     $quan = explode('pq:',$product_quantity);
                     $cost = explode('pc:',$product_cost);
                     $prdt_id = $id[1];
                     $prdt_quantity = $quan[1];
                     $prdt_cost = $cost[1];
                     $total_cost += $prdt_cost *$prdt_quantity; 
                      }
                    } 
                }

        }else{
          $total_cost = 0;
        }
      }else{
         if($cart_data->findById()>0){
          $cart_details = $cart_data->getString(Yii::$app->user->identity['id'])['prdt_details'];
            $exploded_string = explode('##', $cart_details);
            $total_cost = 0;
            foreach ($exploded_string as $str) {
                    $exp_comma = explode(',',$str);
                    if(!empty($exp_comma)){
                      if(!empty($exp_comma[0])){
                        // print_r($exp_comma);
                        $product_id = $exp_comma[0];
                     $product_quantity = $exp_comma[1];
                     $product_cost = $exp_comma[2];
                     $id = explode('pid:',$product_id);
                     $quan = explode('pq:',$product_quantity);
                     $cost = explode('pc:',$product_cost);
                     $prdt_id = $id[1];
                     $prdt_quantity = $quan[1];
                     $prdt_cost = $cost[1];
                     $total_cost += $prdt_cost *$prdt_quantity; 
                      }
                    } 
                }
      }else{
        $total_cost = 0;
      }
    }
    return $total_cost;
    }

      public function getTaxAmount(){
      $cart_data =  new CartData();
      if(Yii::$app->user->isGuest){
        if($cart_data->findBysession(Yii::$app->session->getId()
)>0){
          $cart_details = $cart_data->getStringSession(Yii::$app->session->getId())['prdt_details'];
            $exploded_string = explode('##', $cart_details);
            $total_cost = 0;
            foreach ($exploded_string as $str) {
                    $exp_comma = explode(',',$str);
                    if(!empty($exp_comma)){
                      if(!empty($exp_comma[0])){
                         //print_r($exp_comma);
                        $product_id = $exp_comma[0];
                     $product_quantity = $exp_comma[1];
                     $product_cost = $exp_comma[2];
                     $id = explode('pid:',$product_id);
                     $quan = explode('pq:',$product_quantity);
                     $cost = explode('pc:',$product_cost);
                     $prdt_id = $id[1];
                     $prdt_quantity = $quan[1];
                     $prdt_cost = $cost[1];
                     //$total_cost += $prdt_cost *$prdt_quantity;
                     $product = Product::findOne($id);
                     $product_tax = $product['tax_class'];
                     $cat_id = $product['cat_id'];
                     $cat_details = Category::findOne($cat_id);
                     $cat_tax = $cat_details['tax_class'];
                     $tax = is_null($product_tax)?$cat_tax:$product_tax;
                     $tax_amount = ($prdt_cost*$tax)/100;
                     //print_r($prdt_quantity);
                     $total_cost += $tax_amount*$prdt_quantity;
                      }
                    } 
                }

        }else{
          $total_cost = 0;
        }
      }else{
         if($cart_data->findById()>0){
          $cart_details = $cart_data->getString(Yii::$app->user->identity['id'])['prdt_details'];
            $exploded_string = explode('##', $cart_details);
            $total_cost = 0;
            foreach ($exploded_string as $str) {
                    $exp_comma = explode(',',$str);
                    if(!empty($exp_comma)){
                      if(!empty($exp_comma[0])){
                        // print_r($exp_comma);
                        $product_id = $exp_comma[0];
                     $product_quantity = $exp_comma[1];
                     $product_cost = $exp_comma[2];
                     $id = explode('pid:',$product_id);
                     $quan = explode('pq:',$product_quantity);
                     $cost = explode('pc:',$product_cost);
                     $prdt_id = $id[1];
                     $prdt_quantity = $quan[1];
                     $prdt_cost = $cost[1];
                     //$total_cost += $prdt_cost *$prdt_quantity; 
                     $product = Product::findOne($id);
                     $product_tax = $product['tax_class'];
                     $cat_id = $product['cat_id'];
                     $cat_details = Category::findOne($cat_id);
                     $cat_tax = $cat_details['tax_class'];
                     $tax = is_null($product_tax)?$cat_tax:$product_tax;
                     $tax_amount = ($prdt_cost*$tax)/100;
                     $total_cost += $tax_amount*$prdt_quantity;
                      }
                    } 
                }
      }else{
        $total_cost = 0;
      }
    }
    return $total_cost;
    }
}

<?php

namespace app\controllers;

use Yii;
use common\models\AppCarEnquiry;
use common\models\AppPart;
use common\models\AppEnquiryProducts;
use common\models\AppCarEnquirySearch;
use common\models\AppProductImage;
use common\models\AppProductSuggestion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Model;
use modules\users\models\User;
use yii\web\Response;
use common\models\AppLogs;

/**
 * CarEnquiryController implements the CRUD actions for AppCarEnquiry model.
 */
class CarEnquiryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AppCarEnquiry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppCarEnquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['app_car_enquiry.status'=>1]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendingFollowup()
    {
        $searchModel = new AppCarEnquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['app_car_enquiry.status'=>2]);

        return $this->render('pending_followup_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNotAvailable(){

        $searchModel = new AppCarEnquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['app_car_enquiry.status'=>3]);

        return $this->render('not_available_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionCompleteEnquiry(){

        $searchModel = new AppCarEnquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['app_car_enquiry.status'=>4]);

        return $this->render('complete_enquiry_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppCarEnquiry model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AppCarEnquiry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppCarEnquiry();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AppCarEnquiry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AppCarEnquiry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AppCarEnquiry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppCarEnquiry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppCarEnquiry::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionManagePendingEnquiry($id){
         $model = $this->findModel($id);
         $model1 = AppCarEnquiry::find()
                                ->joinWith(['userName'])
                                ->where(['app_car_enquiry.id'=>$id])
                                ->one();
    
       $user_data = User::find()->select(['first_name','last_name'])->where(['id'=>$model1->updated_by])->one();
       
        $model2 = AppEnquiryProducts::find()
                                ->select(['id','part_id','status'])
                                ->where(['enquiry_id'=>$id])
                                ->all();
        
     
        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->post()['AppCarEnquiry']['status'] == 3){

                 $flag =0;
                foreach ($model2 as $key) {
                    if($key['status'] == 1 || $key['status']==2){
                        $flag = 1;
                    }
                }
               // print_r($flag);exit();
                if($flag == 0){
                    $model->save(false);
                    foreach ($model2 as $key) {
                        $model3 = AppEnquiryProducts::findOne($key['id']);
                        $model3->status = 3;
                        $model3->save(false);
                        }
                        return $this->redirect(['car-enquiry/not-available']);
                }else{
                    Yii::$app->session->setFlash('error', [
                        'type' => 'error',
                        'message' => 'Suggestion available for Parts.Can not moved to Not available',
                    ]);
                      return $this->redirect(['car-enquiry/index']);
                }

            }else if(Yii::$app->request->post()['AppCarEnquiry']['status'] == 2){

                $flag =false;
                foreach ($model2 as $key) {
                    if($key['status'] != 3){
                        $flag = true;
                    }
                }
                if($flag == false){
                    Yii::$app->session->setFlash('success', [
                        'type' => 'error',
                        'message' => 'No suggestion found for all the parts!',
                    ]);
                      return $this->redirect(['car-enquiry/index']);
                }else{
                    $model->save(false);
                    return $this->redirect(['car-enquiry/pending-followup']);
                }
            }else{
                $model->save(false);
                return $this->redirect(['car-enquiry/index']);
            }
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
            'model' => $model,
            'model1'=>$model1,
            'model2'=>$model2,
            'enq_id'=>$id,
            'userData'=>$user_data,
            
            ]);
        }else{
            return $this->render('update', [
            'model' => $model,
            'model1'=>$model1,
            'model2'=>$model2,
             'enq_id'=>$id,
             'userData'=>$user_data,
            
            ]);
        }

    }

      public function actionManagePendingFollowup($id){
         $model = $this->findModel($id);
         $model1 = AppCarEnquiry::find()
                                ->joinWith(['userName'])
                                ->where(['app_car_enquiry.id'=>$id])
                                ->one();
    
       $user_data = User::find()->select(['first_name','last_name'])->where(['id'=>$model1->updated_by])->one();
       
        $model2 = AppEnquiryProducts::find()
                                ->select(['id','part_id'])
                                ->where(['enquiry_id'=>$id])
                                ->all();
      //  print_r($model2);exit();
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            if(Yii::$app->request->post()['AppCarEnquiry']['status'] == 3){
                foreach ($model2 as $key) {
                $model3 = AppEnquiryProducts::findOne($key['id']);
                $model3->status = 3;
                $model3->save(false);
                }
                return $this->redirect(['car-enquiry/not-available']);

            }else if(Yii::$app->request->post()['AppCarEnquiry']['status'] == 2){
                return $this->redirect(['car-enquiry/pending-followup']);
            }else if(Yii::$app->request->post()['AppCarEnquiry']['status'] == 4){
                return $this->redirect(['car-enquiry/complete-enquiry']);
            }else{
                return $this->redirect(['car-enquiry/index']);
            }
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('pending_followup', [
            'model' => $model,
            'model1'=>$model1,
            'model2'=>$model2,
            'enq_id'=>$id,
            'userData'=>$user_data
            ]);
        }else{
            return $this->render('pending_followup', [
            'model' => $model,
            'model1'=>$model1,
            'model2'=>$model2,
             'enq_id'=>$id,
             'userData'=>$user_data
            ]);
        }

    }

    public function actionPartDetails($part_id,$enq_id){

        $model = AppPart::find()
                             ->joinWith(['catName','subCatName'])
                             ->where(['app_part.id'=>$part_id])
                             ->one();
        $model1 = AppEnquiryProducts::find()
                                    ->where(['enquiry_id'=>$enq_id,'part_id'=>$part_id])
                                    ->one();
        $app_product_id = $model1['id'];
        $findImage = AppProductImage::find()
                                    ->where(['enquiry_product_id'=>$app_product_id])
                                    ->all();
        $appSug = AppProductSuggestion::find()
                                    ->where(['enquiry_product_id'=>$app_product_id])
                                    ->all();
         if ($model1->load(Yii::$app->request->post())) {
            $post_data = Yii::$app->request->post();
            $app_enquiry_products = AppEnquiryProducts::findOne($model1['id']);
            $app_enquiry_products->agent_remark = $post_data['AppEnquiryProducts']['agent_remark'];
            $data = $app_enquiry_products->save(false);

             $this->__saveLog($enq_id,$part_id,$post_data['AppEnquiryProducts']['agent_remark'],null);

             Yii::$app->session->setFlash('success', [
                        'type' => 'success',
                        'message' => 'Agent Remarked Successfull',
                    ]);
            return $this->redirect(['car-enquiry/index']);
        }
        return $this->renderAjax('_part_details',[
            'model'=>$model,
            'model1'=>$model1,
            'requirement_details'=>$model1['requirement_detail'],
            'image'=>$findImage,
            'enquiry_product_id'=>$app_product_id,
            'appSug'=>$appSug
        ]);
    }

    public function actionSuggestedProduct($enquiry_product_id){

        $modelsAddress = [new AppProductSuggestion];
        

            $modelsAddress = Model::createMultiple(AppProductSuggestion::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

            $valid = Model::validateMultiple($modelsAddress);
            
            if (1) {
                $flag= 0;
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                   
                        foreach ($modelsAddress as $modelAddress) {
                            $modelAddress->enquiry_product_id = $enquiry_product_id;

                            $enqprdtid = AppEnquiryProducts::findOne($enquiry_product_id);
                            $enqprdtid->status = 1;
                            $enqprdtid->save(false);


                            $enq_products = AppEnquiryProducts::findOne($enquiry_product_id);
                            $enquiry_id = $enq_products->enquiry_id;
                            $part_id = $enq_products->part_id;
                            // $this->__saveLog($enquiry_id,$part_id,null,$modelAddress->id);

                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }else{
                                $this->__saveLog($enquiry_id,$part_id,null,$modelAddress['id']);
                            }
                        }
                    if ($flag) {
                        if($transaction->commit()){
                            echo $flag;
                        }else{
                            echo $flag;
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        return $this->renderAjax('add-sugg', [
            'modelsAddress' => (empty($modelsAddress)) ? [new AppProductSuggestion] : $modelsAddress
        ]);

    }
    public function actionShowSuggestion($enquiry_product_id){
        $appSug = AppProductSuggestion::find()
                                    ->where(['enquiry_product_id'=>$enquiry_product_id])
                                    ->all();
        return $this->renderAjax('_table',['appSug'=>$appSug]);
    }

    public function actionTypeaheadPartname(){
        $post = Yii::$app->request->post();
        $part_name = AppPart::find()
                            ->select('name')
                            ->where(['like','name',$post])
                            ->all();
        foreach ($part_name as $key) {
            $array[] = $key['name'];
        }
        if(!empty($array)){
            echo json_encode($array);
        }else{
            $array = [];
            echo json_encode($array);
        }
    }

    public function actionMovePendingEnquiry($id){
        $app_car_enquiry = AppCarEnquiry::findOne($id);
        $app_car_enquiry->status = 1;
        $app_car_enquiry->save(false);

         Yii::$app->session->setFlash('success', [
                        'type' => 'success',
                        'message' => 'Successfully Moved to pending Enquiries..',
                    ]);

        return $this->redirect(['car-enquiry/index']);
    }

    public function actionCompleteEnqForm($enq_id){
        $app_car_enquiry = new AppCarEnquiry();
         if ($app_car_enquiry->load(Yii::$app->request->post())) {
            $model1 = AppCarEnquiry::findOne($enq_id);
            $data = Yii::$app->request->post();
            // print_r($data);exit();
            if($data['AppCarEnquiry']['order_id'] != ''){
                $model1->reason = $data['AppCarEnquiry']['order_id'];
                $x = $model1->save(false)?$model1:null;
                
            }else{
                if($data['AppCarEnquiry']['add_reason'] == 1){
                    $model1->reason = "Customer not Interested";
                    $x = $model1->save(false)?$model1:null;
                }else if($data['AppCarEnquiry']['add_reason'] == 2){
                    $model1->reason = "Customer purchased";
                    $x = $model1->save(false)?$model1:null;
                }else if($data['AppCarEnquiry']['add_reason'] == 3){
                     $model1->reason = "Price High";
                     $x = $model1->save(false)?$model1:null;
                }else{
                     $model1->reason = $data['AppCarEnquiry']['reason'];
                     $x = $model1->save(false)?$model1:null;
                }
            }

            if($x){
                 $model1->status = 4;
                 $model1->save(false);
                Yii::$app->session->setFlash('success', [
                        'type' => 'success',
                        'message' => 'Successfully marked as completed Followup',
                    ]);
                    return $this->redirect(['car-enquiry/complete-enquiry']);
            }else{
                Yii::$app->session->setFlash('error', [
                        'type' => 'error',
                        'message' => 'Some error Occured',
                    ]);
                      return $this->redirect(['car-enquiry/pending-followup']);
            }
         }
       return $this->renderAjax('_complete_enq_form',['model'=>$app_car_enquiry]);
    }

    //logging

    protected function __saveLog($enq_id,$part_id,$agent_remark=null,$suggestion_id=null){
        $app_logs = new AppLogs();

        $app_logs->enq_id = $enq_id;
        $app_logs->part_id = $part_id;
        $app_logs->agent_remarks = $agent_remark;
        $app_logs->suggestion_id = $suggestion_id;
        $app_logs->status = 1;

        return $app_logs->save(false)?$app_logs:null;
    }

    //show history

    public function actionAgentLogs($enquiry_product_id){
        $enq_products = AppEnquiryProducts::findOne($enquiry_product_id);
        $enquiry_id = $enq_products->enquiry_id;
        $part_id = $enq_products->part_id;

        $logs = AppLogs::find()
                      ->joinWith(['userName'])
                      ->where(['enq_id'=>$enquiry_id,'part_id'=>$part_id])
                      ->orderBy(['log_id'=>SORT_DESC])
                      ->all();
        return $this->renderAjax('_logs',['logs'=>$logs,'enquiry_product_id'=>$enquiry_product_id]);
    }
}

<?php

namespace modules\users\controllers\backend;

use Yii;
use yii\helpers\Url;
use modules\users\models\LoginForm;
use modules\users\models\backend\User;
use modules\users\models\backend\UserSearch;
use modules\users\models\backend\EmployeeSearch;
use modules\users\models\UploadForm;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\rbac\models\Permission;
use modules\users\Module;

/**
 * Class DefaultController
 * @package modules\users\controllers\backend
 */
class DefaultController extends Controller
{
    protected $jsFile;

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
                    'logout' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
						'actions' => ['employee', 'delete'],
                        'roles' => [Permission::PERMISSION_MANAGER_USERS]
                    ],
					[
                        'allow' => true,
						'actions' => ['index', 'view', 'create', 'update', 'status', 'update-profile', 'update-password', 'update-avatar'],
                        'roles' => [Permission::PERMISSION_MANAGER_POST]
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $this->jsFile = '@modules/users/views/ajax/ajax.js';

        // Publish and register the required JS file
        Yii::$app->assetManager->publish($this->jsFile);
        $this->getView()->registerJsFile(
            Yii::$app->assetManager->getPublishedUrl($this->jsFile),
            ['depends' => 'yii\web\JqueryAsset',] // depends
        );
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
     * Lists all User models.
     * @return mixed
     */
    public function actionEmployee()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('employee', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($model = $this->findModel($id)) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $uploadModel = new UploadForm();

        $model->role = $model::RBAC_DEFAULT_ROLE;
        $model->status = $model::STATUS_WAIT;
        $model->registration_type = Yii::$app->user->identity->getId();

        if ($model->load(Yii::$app->request->post())) {
            $uploadModel->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->save()) {
                $authManager = Yii::$app->getAuthManager();
                $role = $authManager->getRole($model->role);
                $authManager->assign($role, $model->id);

                $uploadModel->upload($model->id);
				Yii::$app->session->setFlash('success', [
					'type' => 'success',
					'message' => 'User successfully created.',
				]);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $model->scenario = $model::SCENARIO_ADMIN_CREATE;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ($model = $this->findModel($id)) {
            $user_role = $model->getUserRoleValue();
            $model->role = $user_role ? $user_role : $model::RBAC_DEFAULT_ROLE;

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return array|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            if ($model = $this->findModel($id)) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // We prohibit changing the status of yourself and the admin
                if ($model->id !== Yii::$app->user->identity->getId()) {
                    if ($model->status == $model::STATUS_ACTIVE) {
                        $model->status = $model::STATUS_BLOCKED;
                    } else if ($model->status == $model::STATUS_BLOCKED) {
                        $model->status = $model::STATUS_ACTIVE;
                    } else if ($model->status == $model::STATUS_WAIT) {
                        $model->status = $model::STATUS_ACTIVE;
                    } else if ($model->status == $model::STATUS_DELETED) {
                        $model->status = $model::STATUS_WAIT;
                    }
                    if ($model->save()) {
                        return [
                            'body' => $model->statusLabelName,
                            'success' => true,
                        ];
                    }
                }
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateProfile($id)
    {
        if ($model = $this->findModel($id)) {
            $model->scenario = $model::SCENARIO_ADMIN_UPDATE;

            $user_role = $model->getUserRoleValue();
            $model->role = $user_role ? $user_role : $model::RBAC_DEFAULT_ROLE;
            $_role = $model->role;

            if ($model->load(Yii::$app->request->post())) {
                // Если изменена роль
                if ($_role != $model->role) {
                    $authManager = Yii::$app->getAuthManager();
                    // Отвязываем старую роль если она существует
                    if ($role = $authManager->getRole($_role))
                        $authManager->revoke($role, $model->id);
                    // Привязываем новую
                    $role = $authManager->getRole($model->role);
                    $authManager->assign($role, $model->id);
                }
                if ($model->save())
                    Yii::$app->session->setFlash('success', [
						'type' => 'success',
						'message' => 'Profile successfully changed.',
					]);
            }
        }
        return $this->redirect(['update', 'id' => $model->id, 'tab' => 'profile']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdatePassword($id)
    {
        if ($model = $this->findModel($id)) {
            $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', [
					'type' => 'success',
					'message' => 'Password changed successfully.',
				]);
            }
        }
        return $this->redirect(['update', 'id' => $model->id, 'tab' => 'password']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateAvatar($id)
    {
        if ($model = $this->findModel($id)) {
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
						Yii::$app->session->setFlash('success', [
							'type' => 'success',
							'message' => 'Avatar Successfully Deleted.',
						]);
                    }
                }
                $uploadModel = new UploadForm();
                if ($uploadModel->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                    $uploadModel->upload($model->id);
            }
        }
        return $this->redirect(['update', 'id' => $model->id, 'tab' => 'avatar']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // Do not delete yourself
        if ($model->id !== Yii::$app->user->identity->getId()) {
            if ($model->isDeleted()) {
                if ($model->delete()) {
					Yii::$app->session->setFlash('success', [
						'type' => 'success',
						'message' => 'The user '.$model->username .' have been successfully deleted.',
					]);
                }
            } else {
                $model->scenario = $model::SCENARIO_PROFILE_DELETE;
                $model->status = $model::STATUS_DELETED;
                if ($model->save()) {
					Yii::$app->session->setFlash('success', [
						'type' => 'success',
						'message' => 'The user '.$model->username .' are marked as deleted.',
					]);
                }
            }
        } else {
			Yii::$app->session->setFlash('danger', [
				'type' => 'danger',
				'message' => 'You can not remove yourself.',
			]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin($previous="")
    {   
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = '//login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           
			//update user last login
			$user_id = Yii::$app->user->identity->id;
            $user = User::findOne($user_id);
            $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
			$user->islogged = 1;
            $user->save();
			// If access to Backend is denied, reset authorization, write a message to the session
            // and move it to the login page
            if (!Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
                Yii::$app->user->logout();
               // Yii::$app->session->setFlash('error', Module::t('module', 'You do not have rights, access is denied.'));
				Yii::$app->session->setFlash('error', [
					'type' => 'error',
					'message' => 'You do not have rights, access is denied.',
				]);
                return $this->goHome();
            }
               if(!empty($previous)){
                return $this->redirect($previous);
               }else{
                return $this->goBack();
               }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {	
		//update user login status
		$user_id = Yii::$app->user->identity->id;
		$user = User::findOne($user_id);
		$user->islogged = 0;
		$user->save();
			
        Yii::$app->user->logout();
		Yii::$app->session->setFlash('success', [
			'type' => 'success',
			'message' => 'Logged Out Successfully.',
		]);
        return $this->goHome();
    }
}

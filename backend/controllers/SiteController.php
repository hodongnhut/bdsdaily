<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use common\models\User;
use common\models\UserLocations;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use common\models\ChangePasswordForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use frontend\models\PasswordResetRequestForm;
use common\models\UserActivities;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'login', 
                            'error', 
                            'reset-password', 
                            'request-password-reset', 
                            'mobile-map'
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout', 
                            'index', 
                            'property',
                            'change-password',
                            'property-folder',
                            'property-user',
                            'login-version',
                            'save-location',
                            'clear-location-prompt',
                            'map',
                            'activity-data',
                            'map-ho-chi-minh',
                            'loan',
                            'calendar'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionLoan()
    {
        return $this->render('loan');
    }

     /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    /**
     * Returns activity data for all users for the Chart.js chart.
     * @return array JSON response with chart data
     */
    public function actionActivityData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Fetch all users
        $users = User::find()->all();
        $labels = [];
        $addNewData = [];
        $viewPhoneData = [];
        $updatePropertyData = [];
        $downloadFileData = [];

        foreach ($users as $user) {

            $labels[] = $user->full_name ?: $user->username;

   
            $activities = UserActivities::find()
                ->where(['user_id' => $user->id])
                ->andWhere(['>=', 'created_at', date('Y-m-d H:i:s', strtotime('-7 days'))])
                ->all();

            $addNew = 0;
            $viewPhone = 0;
            $updateProperty = 0;
            $downloadFile = 0;


            foreach ($activities as $activity) {
                switch ($activity->action_type) {
                    case 'add_new':
                        $addNew += $activity->count;
                        break;
                    case 'view_phone':
                        $viewPhone += $activity->count;
                        break;
                    case 'update_property':
                        $updateProperty += $activity->count;
                        break;
                    case 'download_file':
                        $downloadFile += $activity->count;
                        break;
                }
            }

            $addNewData[] = $addNew;
            $viewPhoneData[] = $viewPhone;
            $updatePropertyData[] = $updateProperty;
            $downloadFileData[] = $downloadFile;
        }

        return [
            'labels' => array_map(function ($label) {
                // Wrap labels for Chart.js (same as existing logic)
                $maxWidth = 16;
                if (strlen($label) <= $maxWidth) return $label;
                $words = explode(' ', $label);
                $lines = [];
                $currentLine = '';
                foreach ($words as $word) {
                    if (strlen($currentLine . ' ' . $word) > $maxWidth && $currentLine !== '') {
                        $lines[] = trim($currentLine);
                        $currentLine = $word;
                    } else {
                        $currentLine .= ($currentLine === '' ? '' : ' ') . $word;
                    }
                }
                $lines[] = trim($currentLine);
                return $lines;
            }, $labels),
            'datasets' => [
                [
                    'label' => 'Thêm mới',
                    'data' => $addNewData,
                    'backgroundColor' => '#6EE7B7'
                ],
                [
                    'label' => 'Xem số điện thoại',
                    'data' => $viewPhoneData,
                    'backgroundColor' => '#3B82F6'
                ],
                [
                    'label' => 'Bổ sung thông tin nhà',
                    'data' => $updatePropertyData,
                    'backgroundColor' => '#F59E0B'
                ],
                [
                    'label' => 'Tải File',
                    'data' => $downloadFileData,
                    'backgroundColor' => '#6B7280'
                ]
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        // Refresh user model to ensure latest data
        if ($user) {
            $user = User::findOne($user->id);
        }
        $role_code = $user && $user->jobTitle ? $user->jobTitle->role_code : '';
        // Show modal if force_location_update is set and user is not manager/super_admin
        $locationRequired = $role_code && $role_code !== 'manager' && $role_code !== 'super_admin' 
            && Yii::$app->session->get('force_location_update', false);

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'locationRequired' => $locationRequired,
        ]);
    }

    public function actionSaveLocation()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = Yii::$app->user->identity;

        if (!$user || !$user->jobTitle || $user->jobTitle->role_code === 'manager' || $user->jobTitle->role_code === 'super_admin') {
            return ['success' => false, 'message' => 'Không có quyền hoặc vai trò không hợp lệ'];
        }

        $latitude = Yii::$app->request->post('latitude');
        $longitude = Yii::$app->request->post('longitude');
        $deviceType = Yii::$app->request->post('device_type');
        $os = Yii::$app->request->post('os');
        $browser = Yii::$app->request->post('browser');
        $sessionId = Yii::$app->request->post('session_id');

        if ($latitude !== null && $longitude !== null && is_numeric($latitude) && is_numeric($longitude)) {
            $location = new UserLocations();
            $location->user_id = $user->id;
            $location->latitude = $latitude;
            $location->longitude = $longitude;
            $location->device_type = $deviceType;
            $location->os = $os;
            $location->browser = $browser;
            $location->session_id = $sessionId;
            if ($location->save()) {
                $user->latitude = $latitude;
                $user->longitude = $longitude;
                $user->save(false);
                Yii::$app->session->remove('force_location_update');
                return ['success' => true, 'message' => 'Lưu vị trí thành công'];
            } else {
                return ['success' => false, 'message' => 'Không thể lưu vị trí', 'errors' => $location->getErrors()];
            }
        }

        return ['success' => false, 'message' => 'Dữ liệu vị trí không hợp lệ'];
    }

    public function actionClearLocationPrompt()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->session->remove('force_location_update');
        return ['success' => true];
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'blank';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;
            if ($user) {

                $user->generateAuthKeySession();
                $user->save(false); 

                $duration = $model->rememberMe ? 30 * 60 : 0;
                Yii::$app->user->login($user, $duration);

                $role_code = !empty($user->jobTitle) && !empty($user->jobTitle->role_code) ? $user->jobTitle->role_code : '';
                if ($role_code && !in_array($role_code, ['manager', 'super_admin'])) {
                    Yii::$app->session->set('force_location_update', true);
                }

                Yii::$app->session->setFlash('success', 'Đăng nhập thành công!');

                return $this->goBack();
            } else {

                Yii::$app->session->setFlash('error', 'Lỗi hệ thống. Vui lòng thử lại.');
            }
        }

        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', 'Thông tin đăng nhập không chính xác.');
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Trang offline dành riêng cho PWA
     * Được Service Worker gọi khi không có mạng
     */
    public function actionOffline()
    {
        $this->layout = false; 
        
        Yii::$app->response->statusCode = 503;
        Yii::$app->response->headers->set('Service-Worker-Allowed', '/');

        return $this->render('offline');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionPropertyUser() {
        return $this->render('property-user');
    }

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionLoginVersion() {
        return $this->render('login-version');
    }


    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionPropertyFolder() {
        return $this->render('property-folder');
    }

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionMap() {
        return $this->render('map');
    }

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionMapHoChiMinh() {
        return $this->render('map-ho-chi-minh');
    }
    

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionMobileMap() {
        $this->layout = 'map';
        return $this->render('mobile-map');
    }
    


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Action to change the logged-in user's password.
     * @return string|\yii\web\Response
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('success', 'Mật khẩu của bạn đã được thay đổi thành công.');
                Yii::$app->user->logout();
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Có lỗi xảy ra khi thay đổi mật khẩu.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }


}

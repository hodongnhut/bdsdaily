<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\User;
use common\models\UserLocations;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login'],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $user = User::findByUsernameOrEmail($username);
        if ($user && $user->validatePassword($password)) {
            $user->generateAccessToken();

            return $this->response(true, 'Login successful', [
                'access_token' => $user->access_token,
                'expired_at' => $user->access_token_expired_at,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'full_name' => $user->full_name,
                    'role_code' => $user->jobTitle ? $user->jobTitle->role_code : ''
                ],
            ]);
        }

        return $this->response(false, 'Invalid credentials');
    }


    public function actionMe()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return $this->response(false, 'Unauthorized');
        }

        return $this->response(true, 'User info', [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role_code' => $user->jobTitle ? $user->jobTitle->role_code : ''
        ]);
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;

        if ($user) {
            $user->access_token = null;
            $user->access_token_expired_at = null;
            $user->save(false);
        }

        return $this->response(true, 'Logout successful');
    }

    private function response($status, $msg, $data = null)
    {
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ];
    }

    public function actionSaveLocation()
    {
        $request = Yii::$app->request;
        $user = Yii::$app->user->identity;

        $latitude =  $request->post('latitude');
        $longitude =  $request->post('longitude');
        $deviceType =  $request->post('device_type');
        $os =  $request->post('os');
        $browser =  $request->post('browser');
        $sessionId =  $request->post('session_id');

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
                return ['success' => true, 'message' => 'Lưu vị trí thành công'];
            } else {
                return ['success' => false, 'message' => 'Không thể lưu vị trí', 'errors' => $location->getErrors()];
            }
        }

        return ['success' => false, 'message' => 'Dữ liệu vị trí không hợp lệ'];
    }

}

<?php
namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\web\User;
use yii\web\UnauthorizedHttpException;

class SessionChecker extends Behavior
{
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin',
            User::EVENT_BEFORE_LOGOUT => 'beforeLogout',
        ];
    }

    public function afterLogin($event)
    {
        $identity = $event->identity;
        Yii::$app->session->set('auth_key_session', $identity->auth_key_session);
        Yii::info('User logged in with auth_key_session: ' . $identity->auth_key_session, __METHOD__);
    }

    public function beforeLogout($event)
    {
        Yii::$app->session->remove('auth_key_session');
    }

    public function checkAuthKeySession()
    {
        if ($this->isMobileRequest()) {
            return;
        }
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $authKeySession = Yii::$app->session->get('auth_key_session');
            if ($authKeySession !== $user->auth_key_session) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Phiên của bạn đã bị vô hiệu hóa. Vui lòng đăng nhập lại.');
                throw new UnauthorizedHttpException('Tài Khoản của bạn đang đăng nhập ở thiết bị khác.');
            }
        }
    }

    private function isMobileRequest()
    {
        // Option 1: Check for a custom header (e.g., X-Mobile-App)
        if (Yii::$app->request->headers->has('X-Mobile-App') && Yii::$app->request->headers->get('X-Mobile-App') === 'true') {
            return true;
        }

        // Option 2: Check if the request is to an API endpoint
        if (strpos(Yii::$app->request->pathInfo, 'api/') === 0) {
            return true;
        }

        // Option 3: Check User-Agent (example, adjust based on your mobile app's User-Agent)
        $userAgent = Yii::$app->request->userAgent;
        if ($userAgent && preg_match('/(Mobile|Android|iOS)/i', $userAgent)) {
            return true;
        }
        return false;
    }
}
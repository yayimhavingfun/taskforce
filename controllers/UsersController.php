<?php
namespace app\controllers;

use app\models\Performer_categories;
use app\models\Users;
use app\controllers\SecuredController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UsersController extends SecuredController
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $user = Users::findOne($id);
        if (!$user->is_performer) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        return $this->render('view', ['user' => $user]);
    }

    public function actionSettings()
    {
        /**
         * @var Users $user
         */
        $user = $this->getUser();
        if (!$user->is_performer) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
        $user->setScenario('update');

        if (\Yii::$app->request->isPost) {
            $user->load(\Yii::$app->request->post());
            $user->avatarFile = UploadedFile::getInstance($user, 'avatarFile');

            if ($user->save()) {
                $this->redirect(['users/view', 'id' => $user->id]);
            }
        }


        return $this->render('settings', ['user' => $user]);
    }
}
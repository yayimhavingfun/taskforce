<?php

namespace app\controllers;

use app\models\Reviews;
use app\models\Statuses;
use app\models\Tasks;
use app\models\Users;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ReviewController extends SecuredController
{
    public function actionCreate($id)
    {
        $task = Tasks::findOne($id);
        $review = new Reviews();
        if (Yii::$app->request->isPost) {
            $review->load(Yii::$app->request->post());
            $review->task_id = $task->id;
            $review->user_id = $task->performer_id;
            $user = Users::findOne(['id' => $review->user_id]);
            $review->author_id = Yii::$app->user->getId();
            $user->success_count += 1;
            if ($review->validate()) {
                $task->link('reviews', $review);
                $status = Statuses::findOne(['id' => 4]);
                $task->link('status', $status);
            }
            $user->save();
            $review->save();
            $task->save();
        }

        var_dump($review->getErrors());
    }

    public function actionValidate()
    {
        $review = new Reviews();

        if (Yii::$app->request->isAjax && $review->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($review);
        }
    }
}

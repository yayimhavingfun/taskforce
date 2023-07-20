<?php
 namespace app\controllers;

 use app\models\Responses;
 use app\models\Statuses;
 use app\models\Tasks;
 use Yii;
 use yii\web\Response;
 use yii\widgets\ActiveForm;

 class ResponseController extends SecuredController {

     public function actionApprove($id)
     {
         $response = Responses::findOne($id);
         $task = $response->task;

         $response->rejected = 0;
         $response->save();

         $task->performer_id = $response->performer_id;
         $status = Statuses::findOne(['id' => 3]);
         $task->link('status', $status);
         $task->save();

         return $this->redirect(['tasks/view', 'id' => $response->task_id]);
     }

     public function actionReject($id)
     {
         $response = Responses::findOne($id);

         $response->rejected = 1;
         $response->save();

         return $this->redirect(['tasks/view', 'id' => $response->task_id]);
     }

     public function actionCreate($id)
     {
         $task = Tasks::findOne($id);

         if (Yii::$app->request->isPost) {
             $response = new Responses();
             $response->task_id = $task->id;
             $response->performer_id = Yii::$app->user->getId();
             $response->load(Yii::$app->request->post());

             if ($response->validate()) {
                 $task->link('responses', $response);
             }

             return $this->redirect(['tasks/view', 'id' => $task->id]);
         }
     }

     public function actionValidate($id)
     {
         $response = new Responses();
         $response->task_id = $id;
         $response->performer_id = $this->getUser()->getId();

         if (Yii::$app->request->isAjax && $response->load(Yii::$app->request->post())) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($response);
         }
     }
 }
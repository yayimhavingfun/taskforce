<?php

namespace app\controllers;

use app\helpers\Helpers;
use app\models\AddTaskForm;
use app\models\Categories;
use app\models\Files;
use app\models\Responses;
use app\models\Reviews;
use app\models\Statuses;
use app\models\Tasks;
use app\models\Users;
use app\src\ex\AddTaskException;
use Throwable;
use yii\data\Pagination;
use yii\helpers\Url;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class TasksController extends SecuredController
{

    public function actionIndex(): string
    {
        if (Yii::$app->user->getIdentity() == null) {
            $this->redirect(['site/index']);
        }

        $tasks = new Tasks();
        $tasks->load(Yii::$app->request->post());

        $tasks_query = $tasks->getSearchQuery();
        $categories = Categories::find()->all();

        $count_query = clone $tasks_query;
        $pages = new Pagination(['totalCount' => $count_query->count(), 'pageSize' => 5]);
        $models = $tasks_query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['models' => $models, 'pages' => $pages, 'tasks' => $tasks, 'categories' => $categories]);
    }

    public function actionMy($status = null)
    {
        $menu_items = Helpers::getMyTasksMenu($this->getUser()->is_performer);

        if (!$status) {
            $this->redirect($menu_items[0]['url']);
        }

        $tasks = $this->getUser()->getTasksByStatus($status)->all();

        return $this->render('my', ['menu_items' => $menu_items, 'tasks' => $tasks]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $tasks = Tasks::findOne($id);
        $files = Files::find()->where(['task_id' => $tasks->id]);
        $responses = new Responses();
        $reviews = new Reviews();

        if (!$tasks) {
            throw new NotFoundHttpException("Задача с ID $id не найдена");
        }

        return $this->render('view', ['model' => $tasks, 'responses' => $responses, 'reviews' => $reviews, 'files' => $files]);
    }

    /**
     * @throws Throwable
     * @throws AddTaskException
     */
    public function actionCreate(): Response|array|string
    {
        if ($this->getUser()->is_performer == 1) {
            $this->redirect(Yii::$app->request->baseUrl.Url::to('tasks/index'));
        }
        $form = new AddTaskForm();
        $categories = Categories::find()->all();

        if (Yii::$app->request->getIsPost()) {

            if ($form->load(Yii::$app->request->post())){
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;

                    return ActiveForm::validate($form);
                }
                $new_task = $form->addTask();
                $new_task_save = $new_task->save();
                $form->files = UploadedFile::getInstances($form, 'files');

                if ($form->files) {
                    foreach ($form->files as $file) {
                        $new_file = new Files();
                        $new_name = uniqid('upload') . '.' . $file->getExtension();
                        $file->saveAs('@webroot/uploads/' . $new_name);
                        $new_file->task_id = $new_task->id;
                        $new_file->user_id = Yii::$app->user->getId();
                        $new_file->path = $new_name;
                        $new_file->name = $file->baseName . '.' . $file->getExtension();
                        $new_file->size = $file->size;
                        $new_file->save();
                    }
                }
                if (empty($form->errors)) {
                    if ($new_task_save){
                        return $this->redirect(['tasks/view', 'id' => $new_task->id]);
                    }
                }
            }
        }

        return $this->render('create', ['model' => $form, 'categories' => $categories]);
    }

    public function actionDecline($id)
    {
        $task = Tasks::findOne($id);
        $status = Statuses::findOne(['id' => 5]);
        $task->link('status', $status);

        $performer = Users::findOne(['id' => Yii::$app->user->getId()]);
        $performer->fail_count += 1;

        $performer->update();
        $task->update();

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }

    public function actionCancel($id)
    {
        $task = Tasks::findOne($id);

        $status = Statuses::findOne(['id' => 2]);
        $task->link('status', $status);
        $task->save();

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }


}
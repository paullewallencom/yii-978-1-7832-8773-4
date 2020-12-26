<?php

class TasksController extends CController
{
	public $layout = 'main';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSave($id=NULL)
	{
		if ($id == NULL)
			$model = new Tasks;
		else
			$model = $this->loadModel($id);

		if (isset($_GET['Tasks']))
			$model->attributes = $_GET['Tasks'];

		if (isset($_POST['Tasks']))
		{
			$model->attributes = $_POST['Tasks'];
			$model->due_date = strtotime($_POST['Tasks']['due_date']);
			$model->save();
		}

		$this->render('save', array('model' => $model));
	}

	public function actionComplete($id)
	{
		$model = $this->loadModel($id);
		$model->completed ^= 1;
		$model->save();
		$this->redirect($this->createUrl('/projects/tasks', array('id' => $id)));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		if ($model->delete())
			$this->redirect($this->createUrl('/projects'));

		throw new CHttpException('500', 'There was an error deleting the model.');
	}

	private function loadModel($id)
	{
		$model = Tasks::model()->findByPk($id);
		if ($model == NULL)
			throw new CHttpException('404', 'No model with that ID could be found.');
		return $model;
	}
}
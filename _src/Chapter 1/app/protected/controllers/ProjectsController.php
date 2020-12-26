<?php

class ProjectsController extends CController
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

	public function actionIndex()
	{
		$model = new Projects('search');
        $this->render('index', array('model' => $model));
	}

	public function actionSave($id=NULL)
	{
		if ($id == NULL)
			$model = new Projects;
		else
			$model = $this->loadModel($id);

		if (isset($_POST['Projects']))
		{
			$model->attributes = $_POST['Projects'];
			$model->due_date = strtotime($_POST['Projects']['due_date']);
			$model->save();
		}

		$this->render('save', array('model' => $model));
	}

	public function actionComplete($id)
	{
		$model = $this->loadModel($id);
		$model->completed ^= 1;
		$model->save();
		$this->redirect($this->createUrl('/projects'));
	}

	public function actionTasks($id=NULL)
	{
		if ($id == NULL)
			throw new CHttpException(400, 'Missing ID');

		$project = $this->loadModel($id);
		if ($project === NULL)
			throw new CHttpException(400, 'No project with that ID exists');

		$model = new Tasks('search');
        $model->attributes = array('project_id' => $id);

		$this->render('tasks', array('model' => $model, 'project' => $project));
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
		$model = Projects::model()->findByPk($id);
		if ($model == NULL)
			throw new CHttpException('404', 'No model with that ID could be found.');
		return $model;
	}
}

<?php

class EventController extends CController
{
	/**
	 * AccessControl filter
	 * @return array
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * AccessRules, only authenticated users can access this page
	 * @return array
	 */
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

	/**
	 * Handles displaying and searching of events
	 */
	public function actionIndex()
	{
		$model = new Events('search');
        $model->unsetAttributes(); 

        if (isset($_GET['Events']))
            $model->attributes = $_GET['Events'];

        // Only search for events belonging to this user
        $model->user_id = Yii::app()->user->id;

        $this->render('index', array('model' => $model));
	}

	/**
	 * Handles updating of Events and Adding of Reminders
	 * @param  int $id The model ID
	 */
	public function actionSave($id = NULL)
	{
		if ($id != NULL)
			$model = $this->loadModel($id);
		else
			$model = new Events;

		if (isset($_POST['Events']))
		{
			$model->attributes = $_POST['Events'];

			if ($model->save())
				$this->redirect($this->createUrl('/event/save', array('id' => $model->id)));
		}

		$this->render('save', array('model' => $model));
	}

	/**
	 * Ajax rendering of partial
	 * @param  int $id The model ID
	 */
	public function actionDetails($id = NULL)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$model = $this->loadModel($id);

			$this->renderPartial('details', array('model' => $model));
			Yii::app()->end();
		}
		throw new CHttpException(400, 'Bad Request');
	}

	/**
	 * Deletes an event
	 * @param  int     $id    The Model ID
	 */
	public function actionDelete($id = NULL)
	{
		$model = $this->loadModel($id);

		if ($model->delete())
			$this->redirect($this->createUrl('/event'));

		throw new CHttpException(400, 'Bad Request');
	}

	/**
	 * Returns a model, or throws an exception if it is not found
	 * @param  int            $id    The ID of the model to find
	 * @return Events::model
	 */	
	private function loadModel($id)
	{
		if ($id == NULL)
			throw new CHttpException(400, 'Bad Request');

		$model = Events::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No model with that ID was found');

		return $model;
	}
}
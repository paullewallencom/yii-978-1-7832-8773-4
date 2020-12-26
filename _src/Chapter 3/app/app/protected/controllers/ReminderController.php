<?php

class ReminderController extends CController
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
	 * BeforeAction, verifies that the request in an Ajaxy one.
	 * @param  CAction $action The Action
	 * @see CController::beforeAction($action)
	 */
	public function beforeAction($action)
	{
		if (!Yii::app()->request->isPostRequest)
			throw new CHttpException(400, 'Bad Request');

		return parent::beforeAction($action);
	}
	
	/**
	 * Handles updating of Reminders
	 * @param  int $id The model ID
	 */
	public function actionSave($id = NULL)
	{
		if ($id != NULL)
			$model = $this->loadModel($id);
		else
			$model = new Reminders;

		if (isset($_POST['Reminders']))
		{
			$model->attributes = $_POST['Reminders'];

			// Prevent modification of the model if the user does not own this event
			if (!$this->loadEvent($model->event_id))
				return false;

			if ($model->save())
				return true;
			else
				throw new CHttpException(400, print_r($model->getErrors(), true));
		}

		return true;
	}

	/**
	 * Deletes an event
	 * @param  int     $id    The Model ID
	 */
	public function actionDelete($id = NULL)
	{
		$model = $this->loadModel($id);

		// Prevent modification of the model if the user does not own this event
		if (!$this->loadEvent($model->event_id))
			return false;

		if ($model->delete())
			return true;

		throw new CHttpException(400, 'Bad Request');
	}

	/**
	 * Loads an Event model associated to this reminder, and verifies that the current user has access to it
	 * @param  int $event_id     The Event Id
	 * @return boolean
	 */
	private function loadEvent($event_id)
	{
		$event = Events::model()->findByPk($event_id);
		if ($event == NULL)
			return false;

		if ($event->user_id != Yii::app()->user->id)
			return false;

		return true;
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

		$model = Reminders::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No model with that ID was found');

		return $model;
	}
}
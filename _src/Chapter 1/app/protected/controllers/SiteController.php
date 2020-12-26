<?php

class SiteController extends CController
{
	public $layout = 'signin';
	
	public function actionLogin()
	{
		$model = new LoginForm;

		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			if ($model->login())
				$this->redirect($this->createUrl('/projects'));
		}
		$this->render('login', array('model' => $model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('/site/login'));
	}
}
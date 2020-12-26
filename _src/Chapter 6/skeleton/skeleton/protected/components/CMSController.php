<?php

class CMSController extends CController
{
	public function beforeAction($action)
	{
		Yii::app()->setTheme('main');
		parent::beforeAction($action);
	}
}
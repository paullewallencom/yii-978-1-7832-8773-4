<?php

class ContentController extends CMSController
{
	public function beforeAction($action)
	{
		// Modify routing here
		return parent::beforeAction($action);
	}
	
	public function actionIndex() {}
	public function actionView($id) {}
	public function actionSearch() {}
	public function actionSitemap() {}
}
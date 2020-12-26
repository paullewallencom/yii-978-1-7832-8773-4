<?php

class TimelineController extends CController
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
	 * AccessRules
	 * @return array
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'search'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Main timeline action
	 * Allows the user to see a timeline of a particular user
	 */
	public function actionIndex($id = NULL) {}

    /**
     * Searches for stuff
     */
    public function actionSearch() {}
}

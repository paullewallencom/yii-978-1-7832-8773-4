<?php

class UserController extends CController
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
				'actions' => array('register', 'forgot', 'verify', 'activate', 'resetpassword'),
				'users' => array('*')
			),
			array('allow',
				'actions' => array('index', 'follow', 'unfollow'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

     /**
     * Allows one user to follow another
     * @param int $id     The ID of the user to follow
     */
    public function actionFollow($id=NULL) {}

    /**
     * Allows one user to unfollow another
     * @param int $id     The ID of the user to follow
     */
    public function actionUnFollow($id=NULL) {}

    /**
     * Allows a user to change their personal information
     */
	public function actionIndex() {}

    /**
     * Verifies that a user's NEW email address is valid
     * @param string $id     The verification ID
     */
	public function actionVerify($id=NULL) {}

	/**
	 * Allows new users to register an account
	 */
	public function actionRegister() {}

	/**
	 * Allows us to verify that the email address belonging to the user is 1. Valid and 2. Belongs to them
	 * @param string $id 	The activation ID that was emailed to the user
	 */
	public function actionActivate($id=NULL) {}

	/**
	 * This action allows a user to request a password reset link if they forgot their password
	 */
	public function actionForgot() {}

	/**
	 * Allows the user to change their password if provided with a valid activation ID
	 * @param string $id 	The activation ID that was emailed to the user
	 */
	public function actionResetPassword($id = NULL) {}
}

<?php

class ShareController extends CController
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
				'actions' => array('view', 'getshares'),
				'users'=>array('*'),
			),
            array('allow',
                'actions' => array('create', 'reshare', 'like', 'delete'),
                'users' => array('@')
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    /**
     * Likes a share
     * @param int $id     The share ID
     */
    public function actionLike($id=NULL) {}

    /**
     * Reshares a post, if it exists
     * @param int $id     The share ID
     */
    public function actionReshare($id=NULL) {}

    /**
     * Deletes a share, if it belongs to the current user
     * @param int $id     The share ID
     */
    public function actionDelete($id=NULL) {}

    /**
     * Allows us to view a particular share, and the associated replies
     * @param int $id     The ID of the share
     */
	public function actionView($id=NULL) {}

    /**
     * Retrieves the shares for a given user
     * @param int $id     The ID of the user we want to retrieve the shares for
     */
    public function actionGetShares($id=NULL) {}

    /**
     * Allows authenticated users to share something
     * @return JSON response
     */
    public function actionCreate() {}

    /**
     * Returns a share model
     * @param int $id           The Share ID
     * @return Share $model     The Share Model
     */
    private function loadModel($id=NULL)
    {
        if ($id == NULL)
            throw new CHttpException(400, 'Missing Share ID');

        return Share::model()->findByPk($id);
    }
}

<?php

class CategoryController extends CMSController
{
	/**
	 * Layout
	 * @var string $layout
	 */
	public $layout = 'default';

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
				'actions' => array('index', 'view', 'rss'),
				'users' => array('*')
			),
			array('allow',
				'actions' => array('admin', 'save', 'delete'),
				'users'=>array('@'),
				'expression' => 'Yii::app()->user->role==2'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays all posts within a given category provided by $id
	 * @param  int $id 
	 */
	public function actionIndex($id=1, $page=1)
	{
		$category = $this->loadModel($id);
		$this->setPageTitle('All Posts in ' . $category->name);
		
		// Model Search without $_GET params
		$model = new Content('search');
		$model->unsetAttributes();
		$model->attributes = array(
			'published' => 1,
			'category_id' => $id
		);

		$_GET['page'] = $page;

		$this->render('//content/all', array(
			'dataprovider' => $model->search()
		));
	}

	/**
	 * Displays either all posts or all posts for a particular category_id if an $id is set in RSS Format
	 * So that RSS Readers can access the website
	 * @param  int $id
	 */
	public function actionRss($id=NULL)
	{
		Yii::app()->log->routes[0]->enabled = false; 

		ob_end_clean();
		header('Content-type: text/xml; charset=utf-8');

		$this->layout = false;
		$criteria = new CDbCriteria;                 
		if ($id != NULL)
			$criteria->addCondition("category_id = " . $id);
					
		$criteria->order = 'created DESC';
		$data = Content::model()->findAll($criteria);
		
		$this->renderPartial('rss', array(
			'data'	=> $data, 
			'url'	=> 'http://'.Yii::app()->request->serverName . Yii::app()->baseUrl
		));
	}

	/**
	 * Admin for listing content
	 * @return [type] [description]
	 */
	public function actionAdmin()
	{
		$model = new Category('search');
		$model->unsetAttributes();

		if (isset($_GET['Category']))
			$model->attributes = $_GET;

		$this->render('admin', array(
			'model' => $model
		));
	}

	/**
	 * Created/Update an existing article
	 * @param  int $id
	 */
	public function actionSave($id=NULL)
	{
		if ($id == NULL)
			$model = new Category;
		else
			$model = $this->loadModel($id);

		if (isset($_POST['Category']))
		{
			$model->attributes = $_POST['Category'];

			if ($model->save())
			{
				Yii::app()->user->setFlash('info', 'The category was saved');
				$this->redirect($this->createUrl('category/admin'));
			}
		}

		$this->render('save', array(
			'model' => $model
		));
	}

	/**
	 * Delete action
	 * @param  int $id
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		$this->redirect($this->createUrl('content/admin'));
	}
	
	/**
	 * Load Model method
	 * @param  int $id
	 * @return Category $model
	 */
	private function loadModel($id=NULL)
	{
		if ($id == NULL)
			throw new CHttpException(404, 'No category with that ID exists');

		$model = Category::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No category with that ID exists');

		return $model;
	}
}
<?php

class ContentController extends CMSController
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
				'actions' => array('index', 'view', 'search'),
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
	 * Verifies that our request does not produce duplicate content (/about == /content/index/2), and prevents direct access to the controller action
	 * protecting it from possible attacks.
	 * Better for SEO to prevent duplicate contents
	 * @param $id	- The content ID we want to verify before proceeding
	 **/
	private function beforeViewAction($id=NULL)
	{
		// If we do not have an ID, consider it to be null, and throw a 404 error
		if ($id == NULL)
			throw new CHttpException(404,'The specified post cannot be found.');
		
		// Retrieve the HTTP Request
		$r = new CHttpRequest();
		
		// Retrieve what the actual URI
		$requestUri = str_replace($r->baseUrl, '', $r->requestUri);
		
		// Retrieve the route
		$route = '/' . $this->getRoute() . '/' . $id;
		$requestUri = preg_replace('/\?(.*)/','',$requestUri);
		
		// If the route and the uri are the same, then a direct access attempt was made, and we need to block access to the controller
		if ($requestUri == $route)
			throw new CHttpException(404, 'The requested post cannot be found.');
        
        return str_replace($r->baseUrl, '', $r->requestUri);
	}

	/**
	 * Displays all the posts on the site in a paginated view
	 */
	public function actionIndex($page=1)
	{
		$this->setPageTitle('All Content');	
		
		// Model Search without $_GET params
		$model = new Content('search');
		$model->unsetAttributes();
		$model->published = 1;

		// Allow for dynamic routing
		$_GET['page'] = $page;

		$this->render('//content/all', array(
			'dataprovider' => $model->search()
		));
	}

	/**
	 * Viewing of a particular article by it's slug
	 * @param  int $id
	 */
	public function actionView($id=NULL)
	{
		Yii::app()->user->setReturnUrl($this->beforeViewAction($id));
        
		// Retrieve the data
		$content = Content::model()->findByPk($id);

		// beforeViewAction should catch this
		if ($content == NULL || !$content->published)
			throw new CHttpException(404, 'The article you specified does not exist.');
		
		$this->setPageTitle($content->title);

		$this->render('view', array(
			'id'   => $id, 
			'post' => $content
		));
	}

	/**
	 * Provides functionality for searching through our database
	 */
	public function actionSearch()
	{
		$param = Yii::app()->request->getParam('q');

		$criteria = new CDbCriteria;

        $criteria->addSearchCondition('title',$param,'OR');
        $criteria->addSearchCondition('body',$param,'OR');

        $dataprovider = new CActiveDataProvider('Content', array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 5,
                'pageVar'=>'page'
            )
        ));

        $this->render('//content/all', array(
			'dataprovider' => $dataprovider
		));
	}

	/**
     * Provides basic sitemap functionality via XML
     */
	public function actionSitemap()
	{
		Yii::app()->log->routes[0]->enabled = false; 

		ob_end_clean();
		header('Content-type: text/xml; charset=utf-8');
		
		$this->layout = false;

		$content = Content::model()->findAllByAttributes(array('published' => 1));
		$categories = Category::model()->findAll();
		$this->renderPartial('sitemap', array(
			'content'		=> $content, 
			'categories'	=> $categories, 
			'url' 			=> 'http://'.Yii::app()->request->serverName . Yii::app()->baseUrl
		));
	}

	/**
	 * Admin for listing content
	 * @return [type] [description]
	 */
	public function actionAdmin()
	{
		$model = new Content('search');
		$model->unsetAttributes();

		if (isset($_GET['Content']))
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
			$model = new Content;
		else
			$model = $this->loadModel($id);

		if (isset($_POST['Content']))
		{
			$model->attributes = $_POST['Content'];
			$model->author_id = Yii::app()->user->id;

			if ($model->save())
			{
				Yii::app()->user->setFlash('info', 'The articles was saved');
				$this->redirect($this->createUrl('content/admin'));
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

		$model = Content::model()->findByPk($id);

		if ($model == NULL)
			throw new CHttpException(404, 'No category with that ID exists');

		return $model;
	}
}
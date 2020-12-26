<?php

class SiteController extends CController
{
	public function actionIndex()
	{
		$location = $places = array();

		if (isset($_GET['id']))
		{
			$location = Location::model()->findByPk($_GET['id']);
			$places = $this->getPlaces($location);
		}

		$this->render('index', array('location' => $location, 'places' => $places));
	}

	private function getPlaces(&$location)
	{
		$hash = md5($location->lat . '-' . $location->long);
		$cache = Yii::app()->cache->get($hash);
		if ($cache === false)
		{
			Yii::import('ext.GooglePlaces');
			$places = new GooglePlaces(Yii::app()->params['PlacesApi']['apiKey']);
			$places->radius = 200;
			$places->location = array($location->lat, $location->long);
			$cache = $places->search();
			Yii::app()->cache->set($hash, $cache);
		}
		return $cache;
	}
}
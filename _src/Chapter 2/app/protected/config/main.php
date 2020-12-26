<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Places Nearby',

	'import'=>array(
		'application.models.*',
	),

	'components'=>array(

		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/locations.db',
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'cache' => array(
			'class' => 'CFileCache'
		)
	),

	'params' => array(
		'PlacesApi' => array(
			'apiKey' => 'AIzaSyDABnRserK39LrfpCdaBB2aioN6LR-edsQ'
		)
	)
);
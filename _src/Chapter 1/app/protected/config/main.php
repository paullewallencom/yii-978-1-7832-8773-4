<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Task Application',
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'components'=>array(
		'user' => array(
			'allowAutoLogin' => true
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'login' => 'site/login',
				'logout' => 'site/logout',
				'/'		=> 'projects/index'
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/tasks.db',
		)
	)
);
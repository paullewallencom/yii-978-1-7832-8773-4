<?php return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Scheduled Reminders',

	'import'=>array(
		'application.models.*',
	),

	'components'=>array(
		// CREATE USER 'ch3_reminders'@'localhost' IDENTIFIED BY 'ch3_reminders';
		// CREATE DATABASE IF NOT EXISTS  `ch3_reminders` ;
		// GRANT ALL PRIVILEGES ON  `ch3\_reminders` . * TO  'ch3_reminders'@'localhost';
		'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=ch3_reminders',
            'emulatePrepare' => true,
            'username' => 'ch3_reminders',
            'password' => 'ch3_reminders',
            'charset' => 'utf8',
            'schemaCachingDuration' => '3600',
            'enableProfiling' => true,
        ),

		'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'/' => 'event/index',
				'event/date/<date:[\w-]+>' => 'event/index',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		)
	),

	'params' => array(
		'smtp' => require __DIR__ . '/params.php'
	)
);
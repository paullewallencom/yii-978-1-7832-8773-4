<?php

class m140215_180807_users extends CDbMigration
{
	public function safeUp()
	{
		// Abstract Column types
		// http://www.yiiframework.com/doc/api/1.1/CDbSchema#getColumnType-detail
		$this->createTable('users', array(
			'id' 		=> 'pk',
			'email'	 	=> 'string',
			'password' 	=> 'string',
			'created' 	=> 'integer',
			'updated' 	=> 'integer'
		));

		// Create a unique index on the email column
		$this->createIndex('email_index', 'users', 'email', true);
	}

	public function safeDown()
	{
		$this->dropTable('users');
	}
}
<?php

class m140215_180816_reminders extends CDbMigration
{
	public function safeUp()
	{
		// Abstract Column types
		// http://www.yiiframework.com/doc/api/1.1/CDbSchema#getColumnType-detail
		$this->createTable('events', array(
			'id' 		=> 'pk',
			'user_id'	=> 'integer',
			'title'		=> 'string',
			'data'		=> 'text',
			'time'		=> 'integer',
			'created' 	=> 'integer',
			'updated' 	=> 'integer'
		));

		// Add a foreign key relationship events::user_id => users::id
		$this->addForeignKey('event_users', 'events', 'user_id', 'users', 'id', NULL, 'CASCADE', 'CASCADE');

		$this->createTable('reminders', array(
			'id' 		=> 'pk',
			'event_id'	=> 'integer',
			'offset'	=> 'integer',
			'time'		=> 'integer',
			'created' 	=> 'integer',
			'updated' 	=> 'integer'
		));

		// Add a foreign key relationship reminders::event_id => events::id
		$this->addForeignKey('reminder_events', 'reminders', 'event_id', 'events', 'id', NULL, 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		// Truncate the tables
		$this->dropForeignKey('event_users', 'events');
		$this->dropForeignKey('reminder_events', 'reminders');

		// Then drop them
		$this->dropTable('events');
		$this->dropTable('reminders');
	}
}
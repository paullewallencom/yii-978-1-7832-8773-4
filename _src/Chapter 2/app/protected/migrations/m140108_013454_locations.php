<?php

class m140108_013454_locations extends CDbMigration
{
	public function safeUp()
	{
		return $this->createTable('locations', array(
			'id' => 'INTEGER PRIMARY KEY',
			'name' => 'TEXT',
			'lat' => 'TEXT',
			'long' => 'TEXT',
			'city' => 'TEXT',
			'state' => 'TEXT',
			'created' => 'INTEGER',
			'updated' => 'INTEGER'
		));
	}

	public function safeDown()
	{
		return $this->dropTable('locations');
	}
}
<?php

class m131213_013354_tasks extends CDbMigration
{
	public function up()
	{
		$this->createTable('tasks', array(
			'id' => 'INTEGER PRIMARY KEY',
			'title' => 'TEXT',
			'data' => 'TEXT',
			'project_id' => 'INTEGER',
			'completed' => 'INTEGER',
			'due_date' => 'INTEGER',
			'created' => 'INTEGER',
			'updated' => 'INTEGER'
		));

		$this->createTable('projects', array(
			'id' => 'INTEGER PRIMARY KEY',
			'name' => 'TEXT', 
			'completed' => 'INTEGER',
			'due_date' => 'INTEGER',
			'created' => 'INTEGER',
			'updated' => 'INTEGER'
		));

	}

	public function down()
	{
		$this->dropTable('projects');
		$this->dropTable('tasks');
		return true;
	}
}
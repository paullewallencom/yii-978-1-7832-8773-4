<?php

class Tasks extends CActiveRecord
{
	public function tableName()
	{
		return 'tasks';
	}

	public function rules()
    {
        return array(
            array('project_id, completed, due_date, created, updated', 'numerical', 'integerOnly'=>true),
            array('project_id, title, data, completed', 'required'),
            array('title, data', 'safe'),
            array('id, title, data, project_id, completed, due_date, created, updated', 'safe', 'on'=>'search'),
        );
    }

	public function relations()
	{
		return array(
			'project' => array(self::BELONGS_TO, 'project', 'project_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'data' => 'Data',
			'due_date' => 'Due Date',
			'completed' => 'Completed?',
			'created' => 'Created',
			'updated' => 'Updated',
			'project_id' => 'Project',
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord)
			$this->created = time();

		$this->updated = time();

		return parent::beforeSave();
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('due_date', $this->due_date);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('project_id',$this->project_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

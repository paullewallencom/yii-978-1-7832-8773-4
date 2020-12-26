<?php

class Location extends CActiveRecord
{
	public function tableName()
	{
		return 'locations';
	}

	public function rules()
    {
        return array(
            array('created, updated', 'numerical', 'integerOnly'=>true),
            array('name, lat, long, city, state', 'required'),
            array('title, data', 'safe'),
            array('name, lat, long, city, state, created, updated', 'safe', 'on'=>'search'),
        );
    }

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'lat' => 'Latitude',
			'long' => 'Longitude',
			'city' => 'City',
			'state' => 'State',
			'created' => 'Created',
			'updated' => 'Updated',
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
		$criteria->compare('name',$this->title,true);
		$criteria->compare('lat',$this->data,true);
		$criteria->compare('long',$this->data,true);
		$criteria->compare('city',$this->data,true);
		$criteria->compare('state',$this->data,true);

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

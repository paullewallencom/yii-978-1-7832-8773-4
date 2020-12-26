<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $data
 * @property integer $time
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Reminders[] $reminders
 */
class Events extends CActiveRecord
{
	/**
	 * Retrieves the $_GET['date'] parameter
	 */
	private function getDate()
	{
        if (isset($_GET['date']))
        	return $_GET['date'];
        
        return gmdate("Y-m-d");
	}

	/**
	 * Adds the CTimestampBehavior to this class
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			'CTimestampBehavior' => array(
				'class' 			=> 'zii.behaviors.CTimestampBehavior',
				'createAttribute' 	=> 'created',
				'updateAttribute' 	=> 'updated',
				'setUpdateOnCreate' => true
			)
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, time, created, updated', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, data, time, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'reminders' => array(self::HAS_MANY, 'Reminders', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'title' => 'Title',
			'data' => 'Data',
			'time' => 'Time',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	/**
	 * Before validation, convert the $_POST-ed date to an unix timestmap
	 * @return [type] [description]
	 */
	public function beforeValidate()
	{
		$this->time = (int)strtotime($this->time);

		// Set the user_id to be the current user
		$this->user_id = Yii::app()->user->id;

		return parent::beforeValidate();
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
	public function search($between = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);

		if ($between)
			$criteria->addBetweenCondition('time', strtotime($this->getDate() . ' 00:00:00'), strtotime($this->getDate() . ' 23:59:59'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

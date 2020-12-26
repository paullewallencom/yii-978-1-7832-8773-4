<?php

class CMSActiveRecord extends CActiveRecord
{
	public $_oldAttributes = array();

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
	 * After finding a user and getting a valid result
	 * store the old attributes in $this->_oldAttributes
	 * @return parent::afterFind();
	 */
	public function afterFind()
	{
		if ($this !== NULL)
			$this->_oldAttributes = $this->attributes;
		return parent::afterFind();
	}
}
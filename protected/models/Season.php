<?php

class Season extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{season}}';
	}

	public static function listData() {
		return CHtml::listData(self::model()->findAll(),'id','name');
	}
 

	public function rules()
	{

		return array(
			array('name', 'required'),
 
		);
	}

	 
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
 
		);
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
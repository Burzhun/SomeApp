<?php

class V8Status extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'v8_status';
	}
	
	public function rules()
	{
		return array(
			array('kod, status', 'safe'),
		);
	}
	
	public function relations()
	{
		return array(
			
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'kod' => 'Код',
			'status' => 'Статус',
		);
	}
	
	public function search($serchCriteria = array())
	{
		$criteria=new CDbCriteria;
		
		$criteria->compare('kod',$this->kod, true);
		$criteria->compare('status',$this->status, true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

 
class Goodcolor extends CActiveRecord
{
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return 'goodcolor';
	}

 
	public function rules()
	{
 
		return array(
			array('goodkod, colorkod, numpos, default', 'required'),
			array('numpos, default', 'numerical', 'integerOnly'=>true),
			array('goodkod, colorkod', 'length', 'max'=>13),
 
			array('goodkod, colorkod, numpos, default', 'safe', 'on'=>'search'),
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
			'goodkod' => 'Goodkod',
			'colorkod' => 'Colorkod',
			'numpos' => 'Numpos',
			'default' => 'Default',
		);
	}

 
	public function search()
	{
 
		$criteria=new CDbCriteria;

		$criteria->compare('goodkod',$this->goodkod,true);
		$criteria->compare('colorkod',$this->colorkod,true);
		$criteria->compare('numpos',$this->numpos);
		$criteria->compare('default',$this->default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
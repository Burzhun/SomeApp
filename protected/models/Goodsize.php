<?php

 
class Goodsize extends CActiveRecord
{
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'goodsize';
	}

 
	public function rules()
	{
 
		return array(
			array('goodkod, numpos, size, default', 'required'),
			array('numpos, default', 'numerical', 'integerOnly'=>true),
			array('size', 'numerical'),
			array('goodkod', 'length', 'max'=>13), 
			array('goodkod, numpos, size, default', 'safe', 'on'=>'search'),
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
			'numpos' => 'Numpos',
			'size' => 'Size',
			'default' => 'Default',
		);
	}
 
	public function search()
	{
 
		$criteria=new CDbCriteria;

		$criteria->compare('goodkod',$this->goodkod,true);
		$criteria->compare('numpos',$this->numpos);
		$criteria->compare('size',$this->size);
		$criteria->compare('default',$this->default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
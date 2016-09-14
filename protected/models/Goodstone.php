<?php

class Goodstone extends CActiveRecord
{
	public $primaryKey = array( 'id' );
	public $name;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return 'goodstone';
	}

	public function rules()
	{
		return array(
			array('goodkod, stonekod, numpos, count, can_choose, default, mainstone', 'required'),
			array('numpos, count, can_choose, default, mainstone', 'numerical', 'integerOnly'=>true),
			array('goodkod, stonekod', 'length', 'max'=>13),
			
			array('description', 'safe'),
			array('goodkod, stonekod, numpos, count, can_choose, default, mainstone,description', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'st'=>array(self::BELONGS_TO, 'Stone', 'stonekod'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'goodkod' => 'id товара',
			'stonekod' => 'Код камня',
			'numpos' => 'Numpos',
			'count' => 'Количество',
			'can_choose' => 'Can Choose',
			'default' => 'Default',
			'mainstone' => 'Mainstone',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('goodkod',$this->goodkod,true);
		$criteria->compare('stonekod',$this->stonekod,true);
		$criteria->compare('numpos',$this->numpos);
		$criteria->compare('count',$this->count);
		$criteria->compare('can_choose',$this->can_choose);
		$criteria->compare('default',$this->default);
		$criteria->compare('mainstone',$this->mainstone);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
				),
		));
	}
}
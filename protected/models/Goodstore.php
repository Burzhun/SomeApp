<?php

class Goodstore extends CActiveRecord
{
	public $primaryKey = array( 'goodkod' );
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'goodstore';
	}

	public function rules()
	{
		return array(
			array('goodkod, goodsize, kolvo, weight', 'required'),
			array('kolvo', 'numerical', 'integerOnly'=>true),
			array('goodsize, weight', 'numerical'),
			array('goodkod', 'length', 'max'=>13),
			
			array('goodkod, goodsize, kolvo, weight, serialkod, stonekod, price', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'goods'=>array(self::BELONGS_TO, 'Goods', 'goodkod'),
			'stone'=>array(self::BELONGS_TO, 'Stone', 'stonekod'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'goodkod' => 'id товара',
			'goodsize' => 'Размер кольца',
			'kolvo' => 'Количество на складе',
			'weight' => 'Вес',
			'serialkod' => 'Код',
			'stonekod' => 'Код камня',
			'price' => 'Цена',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('goodkod',$this->goodkod,true);
		$criteria->compare('goodsize',$this->goodsize,true);
		$criteria->compare('kolvo',$this->kolvo);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('serialkod',$this->serialkod,true);
		$criteria->compare('stonekod',$this->stonekod,true);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
				),
		));
	}
}
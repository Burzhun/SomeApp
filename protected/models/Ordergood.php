<?php

 
class Ordergood extends CActiveRecord
{
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return 'ordergood';
	}

	public function relations()
	{
		return array(
			//'item'=>array(self::BELONGS_TO, 'Goods', 'goodkod//'),
			//'good'=>array(self::BELONGS_TO, 'Goods', 'item_id'),
		);
	}
 
	public function rules()
	{ 
		return array(
			array('orderkod, goodkod, size, stonecolor, stonetype, count, price, sum, pricemetal, pricework', 'safe'));
	}
}
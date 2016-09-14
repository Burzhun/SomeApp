<?php
 
class Orders extends CActiveRecord
{
 

	public static function getStatusList()
	{
		return array(
			1 => 'Создан',
			2 => 'Создан',
			3 => 'Создан',
			4 => 'Создан',
			);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return 'orders';
	}
 
	public function rules()
	{
 
		return array(
			array('name, orderdate, goodcount, weight, sum, agentkod', 'safe'   ),
		);
	}


	public function relations()
	{
		return array(
			
		);
	}
 
 
}
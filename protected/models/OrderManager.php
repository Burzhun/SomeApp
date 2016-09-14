<?php

class OrderManager extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'order_manager';
	}

	public function rules()
	{
		return array(
			array('order_id, manager_v8name', 'safe'),
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
			'order_id' => 'Заказ',
			'manager_v8name' => 'Менеджер',
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('manager_v8name',$this->manager_v8name);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			),
		));
	}

	public static function create($order_id, $manager_id)
	{
		$orderManager = new OrderManager();
		$orderManager->order_id = $order_id;
		$orderManager->manager_v8name = $manager_id;
		$orderManager->save();
	}
}
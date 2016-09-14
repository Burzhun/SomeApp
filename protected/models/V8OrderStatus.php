<?php

class V8OrderStatus extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'v8_order_status';
	}

	public function rules()
	{
		return array(
			array('docdate, docname, ordername, orderid, curstatus, agentkod', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'order'=>array(self::BELONGS_TO, 'Order', 'orderid'),//таблица заказов используемая Yii
			'v8order'=>array(self::BELONGS_TO, 'Orders', 'ordername'),//таблица заказов используемая 1C
			'current_status'=>array(self::BELONGS_TO, 'V8Status', 'curstatus'),//$this->current_status->name возврящает название статуса
		);
	}

	public function attributeLabels()
	{
		return array(
			'docdate' => 'Kod',
			'docname' => 'Name',
			'ordername' => 'Полное название',
			'orderid' => 'Marking',
			'curstatus' => 'Hallmark',
			'agentkod' => 'Goodtype',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('docdate',$this->docdate);
		$criteria->compare('docname',$this->docname);
		$criteria->compare('ordername',$this->ordername);
		$criteria->compare('orderid',$this->orderid);
		$criteria->compare('curstatus',$this->curstatus);
		$criteria->compare('agentkod',$this->agentkod);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 100),
		));
	}
}
<?php

class V8OrderStatusItem extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'v8_order_status_item';
	}
 
	public function rules()
	{
		return array(
			array('id_v8_order_status, position, v8_status_kod, done', 'safe'),
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
			'id_v8_order_status' => 'Номер статуса в таблице отношений статусов и заказов 1С',
			'position' => 'Позиция',
			'v8_status_kod' => 'Название статуса',
			'done' => 'Процесс завершен',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_v8_order_status',$this->id_v8_order_status);
		$criteria->compare('position',$this->position);
		$criteria->compare('v8_status_kod',$this->v8_status_kod);
		$criteria->compare('done',$this->done);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 100),
		));
	}
}
<?php

/**
 * This is the model class for table "{{order_item}}".
 *
 * The followings are the available columns in table '{{order_items}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $item_id
 * @property integer $num
 */
class OrderItem extends CActiveRecord
{
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return '{{order_item}}';
	} 
	public function rules()
	{
 
		return array(
			array('order_id, item_id, num', 'required'), 
 
			array('id, order_id, item_id, num, comment, weight, serialkod', 'safe',  ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'item'=>array(self::BELONGS_TO, 'Goods', 'item_id'),
			'order'=>array(self::BELONGS_TO, 'Order', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'item_id' => 'Item',
			'num' => 'Количество',
			'comment' => 'Примечание',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('num',$this->num);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
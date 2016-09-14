<?php

/**
 * This is the model class for table "{{kubachinka_collection_goods}}".
 *
 * The followings are the available columns in table '{{kubachinka_collection_goods}}':
 * @property string $id
 * @property string $goods_kod
 * @property string $collection_id
 */
class KubachinkaCollectionGoods extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{kubachinka_collection_goods}}';
	}

	public function rules()
	{
		return array(
			array('goods_kod, collection_id', 'required'),
			
			array('goods_kod, collection_id', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'goods_kod' => 'ID товара',
			'collection_id' => 'ID коллекции',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('goods_kod',$this->goods_kod,true);
		$criteria->compare('collection_id',$this->collection_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
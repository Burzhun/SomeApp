<?php

/**
 * This is the model class for table "{{kubachinka_collection}}".
 *
 * The followings are the available columns in table '{{kubachinka_collection}}':
 * @property string $id
 * @property string $name
 * @property string $pos
 */
class KubachinkaCollection extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return '{{kubachinka_collection}}';
	}


	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name, alias', 'length', 'max'=>255),
			array('alias','ext.LocoTranslitFilter','translitAttribute'=>'name','setOnEmpty'=>true), 
			array('name, pos', 'safe'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id'    => 'ID',
			'name'  => 'Название',
			'pos'   => 'Позиция',
			'alias' => 'Алиас',
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pos',$this->pos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function listData(){
		return CHtml::listData(self::model()->findAll(), 'id', 'name');
	}
}
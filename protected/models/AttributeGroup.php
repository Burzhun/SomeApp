<?php

class AttributeGroup extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{attribute_group}}';
	}

	public static function listData() {
		
$models = AttributeGroup::model()->findAll();
return CHtml::listData($models,'id', 'name');
	}

	public function rules()
	{

		return array(
			array('name', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('id, name, position', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'attr'=>array(self::HAS_MANY, 'Attribute', 'group_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'position' => 'Позиция',
		);
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
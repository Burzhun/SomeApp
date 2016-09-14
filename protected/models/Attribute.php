<?php

class Attribute extends CActiveRecord
{

	const TYPE_TEXT          = 1;
	const TYPE_TEXTAREA      = 2;
	const TYPE_TEXTAREAWG    = 3;
	const TYPE_CHECKBOX      = 4;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return '{{attribute}}';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, required, type, position', 'required'),
			array('required, type, position', 'numerical', 'integerOnly'=>true),
			array('unique', 'unique'),
			array('unique', 'match',
				'pattern'=>'/^([a-z0-9_])+$/i',
				'message'=>'Название может содержать только буквы, цифры и подчеркивания.',
			),			
			array('id, name, unique, required, type, position,group_id', 'safe'),
		);
	}

	public static function getTypesList($id=0)
	{

		$arr =  array(
			self::TYPE_TEXT           => 'Поле ввода',
			self::TYPE_TEXTAREA       => 'Text Area',
			self::TYPE_TEXTAREAWG       => 'WYSIWYG',
			self::TYPE_CHECKBOX       => 'CheckBox',
		);
		if($id)
			return $arr[$id];
		else
			return $arr;
	}

	public function relations()
	{

		return array(
'group'=>array(self::BELONGS_TO, 'AttributeGroup', 'group_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'unique' => 'Идентификатор',
			'required' => 'Обязательно?',
			'type' => 'Тип',
			'position' => 'Позиция',
			'group_id' => 'Группа',
		);
	}

	public function renderField($value = null)
	{
		$name = 'Attribute['.$this->unique.']';
		switch ($this->type):
			case self::TYPE_TEXT:
				return CHtml::textField($name, $value);
			break;
			case self::TYPE_TEXTAREA:
				return CHtml::textArea($name, $value);
			break;
			case self::TYPE_TEXTAREAWG:
				return CHtml::textArea($name, $value, array('class' => 'ckeditor'));
			break;
			case self::TYPE_CHECKBOX:
				return CHtml::checkBox($name, $value);
			break;	
		endswitch;
	}


	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('unique',$this->unique,true);
		$criteria->compare('required',$this->required);
		$criteria->compare('type',$this->type);
		$criteria->compare('position',$this->position);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('group.name',$this->group->name);

		$criteria->with = array('group');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				'pagination'=>array(
												'pageSize'=>100,
											),
		));
	}


}
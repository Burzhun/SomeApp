<?php


class City extends CActiveRecord
{
	public function tableName(){
		return '{{city}}';
	}

	public function rules(){

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
		);
	}

	public function attributeLabels(){
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'position' => 'Position',
		);
	}

	public function search(){

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'id ASC',
			),
		));
	}

	public static function ListData(){
		return CHtml::ListData(self::model()->findAll(),'id','name');
	}


	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function getCreateUrl(){
		return Yii::app()->createurl('city/view', array('alias' => $this->alias));
	}
}

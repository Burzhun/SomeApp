<?php


class Collection extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'collection';
	}

	
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			array('id, name, description, seo_title, seo_keywords, seo_description,description_roz, seo_title_roz, seo_keywords_roz, seo_description_roz', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			//'group'=>array(self::HAS_MANY, 'Group', 'collection_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
			'description_roz' => 'Описание',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getGroups(){
		$groups = Group::model()->findAll('collection_id=:id',array(':id'=>$this->id));
		
		return $groups;
	}

	public static function listData(){
		return CHtml::listData(self::model()->findAll(), 'id', 'name');
	}

	public function createUrl()
	{
		return "catalog/".$this->alias;
	}
}
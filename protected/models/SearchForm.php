<?php

class SearchForm extends CFormModel {
	public $collection;
	public $group;
	public $type;
	
	public function rules(){
		return array(
			//array('brand', 'required'),
			array('collection, group, type', 'safe'),
		);
	}
	
	public function attributeLabels(){
		return array(
			'collection'=> 'Коллекция',
			'group'=> 'Группа',
			'type'=> 'Тип',
		);
	}
	
}
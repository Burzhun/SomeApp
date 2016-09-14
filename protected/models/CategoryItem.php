<?php


class CategoryItem extends CActiveRecord
{
	// Если загружается картинка
	/*public $file;
	public $removeImage; // если непустое(название картинки), то удаляем картинку
	public $dir='uploads/category-item/';*/


	public function tableName(){
		return '{{category_item}}';
	}

	public function rules(){

		return array(
			array('category_id, item_id', 'required'),
			//array('category_id', 'numerical', 'integerOnly'=>true),
			//array('file', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png'),
			array('id, category_id, item_id', 'safe', 'on'=>'search'),
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
			'category_id' => 'Category',
			'item_id' => 'Item',
		);
	}

	public function search(){

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('item_id',$this->item_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'id ASC',
			),
		));
	}


	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function getCreateUrl(){
		return Yii::app()->createurl('category-item/view', array('alias' => $this->alias));
	}

	/*
	protected function beforeSave(){
		// сначало выполню родительские ивенты
		if(parent::beforeSave() === false) {
		    return false;
		}
		// удалить картинку 
		if($this->removeImage){
			@unlink($this->dir."/".$this->removeImage);
		}
		return true;
	}

	protected function afterSave(){
		if($this->image){
			Functions::BigImageResize($this->dir.$this->image, 1000, 1000);
		}
		parent::afterSave();
	}

	protected function afterDelete(){
		@unlink($this->dir."/".$this->image); // удалить оригинал
		return parent::afterDelete();
	}
	*/
}

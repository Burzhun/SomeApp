<?php


class Shops extends CActiveRecord
{
	public function tableName(){
		return '{{shops}}';
	}

	public function rules(){

		return array(
			array('name, address', 'required'),
			array('name, address, phone, map_coords', 'length', 'max'=>255),
			array('city_id', 'safe'),
			array('id,positon, name, address', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'city'=>array(self::BELONGS_TO, 'City', 'city_id'),
		);
	}

	public function attributeLabels(){
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'address' => 'Адрес',
			'phone' => 'Телефон',
			'city_id' => 'Город',
			'map_coords' => 'Координаты',
			'positon' => 'Позиция',
		);
	}

	public function search(){

		$criteria=new CDbCriteria;
		$criteria->with = array('city');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('city.name',$this->city_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 't.position, t.id ASC',
			),
		));
	}


	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public static function ListData(){
		return CHtml::ListData(self::model()->findAll(),'id','name');
	}

	public function getCreateUrl(){
		return Yii::app()->createurl('shops/view', array('alias' => $this->alias));
	}

	public static function getColorShops($colorId, $itemId){
		$shops = Yii::app()->db->createCommand()
			->select('sms.shop_id, ss.name')
			->from('tbl_size_shop ss')
			->join('tbl_size_many_shops sms','sms.size_id=ss.id')
			->where('ss.color_id=:id AND ss.item_id = :item_id',array(':id'=>$colorId, ':item_id'=>$itemId))
			->order('ss.name ASC')
			->queryAll();
			
		return $shops;
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

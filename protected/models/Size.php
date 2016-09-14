<?php

class Size extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{size}}';
	}

	public static function listData() {
		
$models = self::model()->findAll();
return CHtml::listData($models,'id', 'name');
	}

	public function rules()
	{

		return array(
			array('name', 'required'),
			array('id, name, description', 'safe'),
		);
	}

	public function relations()
	{
		return array(
	
		);
	}

	public function getSizeArray() {

$sizeArr = array();
$arr = explode(", ",$this->description);
foreach ($arr as $key => $value) {
  $temp = explode("-", $value);
  $sizeArr[$temp[0]] = $temp[1];
}
	
	return $sizeArr;
	}	

	public function getRange()
	{
		$arr = explode("-", $this->name);
		$res = array();
		for ($i=$arr[0]; $i <= $arr[1]; $i++) { 
			$res[$i] = $i;
		}
 
		return $res;
	}
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
		);
	}
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
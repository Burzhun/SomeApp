<?php

class Stone extends CActiveRecord
{
	public $primaryKey = array( 'kod' );
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'stone';
	}

	public function rules()
	{
		return array(
			array('cost, weight, size1, size2, price1, price2, price3, price4', 'numerical'),
			array('kod', 'length', 'max'=>13),
			array('name, shape', 'length', 'max'=>250),
			
			array('kod, name, cost, weight, size1, size2, shape, color, price1, price2, price3, price4', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'imageStone' => array(self::HAS_ONE, 'StoneImage', 'stonekod'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'kod' => 'Код',
			'name' => 'Имя',
			'cost' => 'Cost',
			'weight' => 'Weight',
			'size1' => 'Size1',
			'image' => 'Фото',
			'size2' => 'Size2',
			'shape' => 'Shape',
			'color' => 'Цвет',
			'price1' => 'Price1',
			'price2' => 'Price2',
			'price3' => 'Price3',
			'price4' => 'Price4',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('size1',$this->size1);
		$criteria->compare('size2',$this->size2);
		$criteria->compare('shape',$this->shape,true);
		$criteria->compare('price1',$this->price1);
		$criteria->compare('price2',$this->price2);
		$criteria->compare('price3',$this->price3);
		$criteria->compare('price4',$this->price4);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	protected function afterDelete()
	{
	    parent::afterDelete();
	    StoneImage::model()->deleteAll('stonekod='.$this->kod);
	}

	public static function getStoneByKod($kod)
	{
		$stone = Stone::model()->find(array("condition"=>"kod='$kod'"));
		return $stone->image;
	}

	public static function getAllStoneInStore($_id = 0)
	{
		$stones = "";
		
		if($_id)
		{
			
		} else {

		}
		//$stones = Goodstore::model()->findAll(array("condition"=>"goodkod IN (SELECT kod FROM goods WHERE groupkod LIKE '%".$_id."')", "group"=>"stonekod"));
		$stones = Stone::model()->findAll(array("group"=>"color"));


		return $stones;
	}

	public function getImageStone()
	{
		$filename = "allcolor.png";
		switch($this->color)
		{
			 case "красный": $filename = "red.jpg"; break;
			 case "голубой": $filename = "whiteblue.jpg"; break;
			 case "синий": $filename = "blue.jpg"; break;
			 case "зеленый": $filename = "green.jpg"; break;
			 case "коричневый": $filename = "broun.jpg"; break;
			 case "белый": $filename = "white.jpg"; break;
			 case "желтый": $filename = "yellow.jpg"; break;
			 case "черный": $filename = "black.jpg"; break;
			 case "фиолетовый": $filename = "violet.jpg"; break;
			 case "розовый": $filename = "pink.jpg"; break;
			case "жемчуг": $filename = "pearls.jpg"; break;
		}
		return "/images/".$filename;
	}
}
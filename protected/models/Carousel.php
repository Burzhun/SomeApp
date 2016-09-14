<?php

/**
 * This is the model class for table "{{carousel}}".
 *
 * The followings are the available columns in table '{{carousel}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $image
 * @property integer $position
 */
class Carousel extends CActiveRecord
{

	public $image_form;
	public $image_form2;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{carousel}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{ 
		return array( 
			array('position', 'numerical', 'integerOnly'=>true),
			array('name, description, url', 'length', 'max'=>255), 
			array('id,type, name, description, url, image, position,start,end', 'safe', ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}



public static function getByType($type, $active=false)
{	
	$criteria = new CDbCriteria;
	if($active){
		$criteria->condition = "type = $type AND start<:param AND end>:param";
		$criteria->params =  array(':param'=>time());
	}else{
		$criteria->condition = "type = $type";
	}
	$criteria->order = "position ASC";
	return self::model()->findAll($criteria); 	
}

public static function getOneByType($type)
{
	return self::model()->find("type = $type"); 	
}

public function getImageLink ($attribute = "image")
{
	return "/uploads/".$this->$attribute;
}

public static function getTypesArray() {

	return array(
		0 => 'Категории на главной',
		);
}

public static function getTypesArrayStore() {

	return array(
		1 => 'Баннер на главной',
		2 => 'Баннер на главной внизу',
		);
}
public function getTypeText() {
	$array = Carousel::getTypesArray();
	return $array[$this->type];
}
	public static function getActive() {
return $carousel=Carousel::model()->findAll('start<:param AND end>:param ORDER by position', array(':param'=>time())); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Номер',
			'name' => 'Заголовок',
			'description' => 'Описание',
			'url' => 'Ссылка',
			'image' => 'Картинка',
			'image_form' => 'Картинка',
			'image_form2' => 'Черно-белая картинка',
			'image2' => 'Картинка',
			'position' => 'Позиция',
			'type' => 'Расположение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
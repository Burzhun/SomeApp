<?php

/**
 * This is the model class for table "{{manufacter}}".
 *
 * The followings are the available columns in table '{{manufacter}}':
 * @property integer $id
 * @property string $name
 * @property integer $position
 */
class Manufacter extends CActiveRecord
{
	public $image_form;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Manufacter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{manufacter}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image_form,image, position, description', 'safe'),
		);
	}
 

	public function getCount()
	{

$count = Yii::app()->cache->get("manufactercount".$this->id);
if($count===false)
{

$count = $this->itemCount;
Yii::app()->cache->set("manufactercount".$this->id, $count, 400);
}

return $count;

	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'itemCount'=>array(self::STAT, 'Item', 'manufacter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название производителя',
			'position' => 'Position',
			'description' => 'О компании',
			'image_form' => 'Картинка',
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
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
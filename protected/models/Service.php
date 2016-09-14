<?php

/**
 * This is the model class for table "{{service}}".
 *
 * The followings are the available columns in table '{{service}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $image
 * @property integer $date
 * @property integer $position
 * @property string $seokeywords
 * @property string $seotitle
 * @property string $seodescription
 */
class Service extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Service the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function getcreateurl() 
	{
return Yii::app()->createurl('service/view', array('id' => $this->id, 'translit' => Translit::url($this->title)));
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content', 'required'),
			array('date, position', 'numerical', 'integerOnly'=>true),
			array('title, image, seokeywords, seotitle, seodescription', 'length', 'max'=>255),
			array('content, short', 'length', 'max'=>99999),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, short,image, date, position, seokeywords, seotitle, seodescription', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'short' => 'Кратко',
			'content' => 'Услуга',
			'image' => 'Картинка',
			'date' => 'Дата',
			'position' => 'Позиция',
			'seokeywords' => 'Ключевые слова',
			'seotitle' => 'Заголовок страницы',
			'seodescription' => 'Описание страницы',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('position',$this->position);
		$criteria->compare('seokeywords',$this->seokeywords,true);
		$criteria->compare('seotitle',$this->seotitle,true);
		$criteria->compare('seodescription',$this->seodescription,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
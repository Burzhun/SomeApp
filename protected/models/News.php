<?php


class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function getcreateurl() 
	{
return Yii::app()->createurl('news/view', array('id' => $this->id, 'translit' => Translit::url($this->title)));
	}

	public function getTitleLink() {
$str = $this->title;
$str = str_replace("((", "<a href=".$this->createurl.">", $str);
$str = str_replace("))", "</a>", $str);
if($str != $this->title)
return $str;
else
return CHtml::link($str,$this->createurl);
	}

	public function getTitleText() {
$str = $this->title;
$str = str_replace("((", "", $str);
$str = str_replace("))", "", $str);
return $str;	
	}


	public function tableName()
	{
		return '{{news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, long', 'required'),
			array('date', 'numerical', 'integerOnly'=>true),
			array('title, short, keywords, description', 'length', 'max'=>255),
			array('long', 'length', 'max'=>993399),
			array('image', 'length', 'max'=>266),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, short, long, date, image, keywords, description', 'safe'),
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
			'short' => 'Коротко',
			'long' => 'Полная статья',
			'date' => 'Дата',
			'image' => 'Фото',
			'keywords' => 'Ключевые слова',
			'description' => 'Описание',
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
		$criteria->compare('short',$this->short,true);
		$criteria->compare('long',$this->long,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	

}
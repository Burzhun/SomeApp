<?php

/**
 * This is the model class for table "{{tire}}".
 *
 * The followings are the available columns in table '{{tire}}':
 * @property integer $id
 * @property string $size
 * @property string $pr
 * @property string $type
 * @property string $image
 * @property string $models
 */
class Tire extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tire the static model class
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
		return '{{tire}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size', 'required'),
			array('size, pr, type, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, size, pr, type, image, models, manufacter_id, type_id, description', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function types()
	{
		return array(
			'1' => 'Для экскаваторов-погрузчиков',
			'2' => 'Для колесных экскаваторов',
			'3' => 'Для фронтальных погрузчиков',
			'4' => 'Для минипогрузчиков с бортовым поворотом',
			'5' => 'Для вилочных погрузчиков'
		);
	}

public function typeLabel ($id)

{
$types = $this->types();
return $types[$id];

}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'manufacter'=>array(self::BELONGS_TO, 'TireManufacter', 'manufacter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'size' => 'Типоразмер',
			'pr' => 'Слойность / PR',
			'type' => 'Тип рисунка',
			'type_id' => 'Тип шин',
			'image' => 'Вид',
			'models' => 'Шины для следующих моделей',
			'description' => 'Дополнительная информация',
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
		$criteria->compare('size',$this->size,true);
		$criteria->compare('pr',$this->pr,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('models',$this->models,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
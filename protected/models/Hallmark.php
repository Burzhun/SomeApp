<?php

/**
 * This is the model class for table "hallmark".
 *
 * The followings are the available columns in table 'hallmark':
 * @property string $kod
 * @property string $name
 * @property double $hallmark
 * @property double $price_gr
 * @property double $alloy
 * @property string $pure_hallmark
 */
class Hallmark extends CActiveRecord
{
		public $primaryKey = array( 'kod' );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Hallmark the static model class
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
		return 'hallmark';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kod, name, hallmark, price_gr, alloy, pure_hallmark', 'required'),
			array('hallmark, price_gr, alloy', 'numerical'),
			array('kod, pure_hallmark', 'length', 'max'=>13),
			array('name', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kod, name, hallmark, price_gr, alloy, pure_hallmark', 'safe', 'on'=>'search'),
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
			'kod' => 'Kod',
			'name' => 'Name',
			'hallmark' => 'Hallmark',
			'price_gr' => 'Price Gr',
			'alloy' => 'Alloy',
			'pure_hallmark' => 'Pure Hallmark',
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

		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('hallmark',$this->hallmark);
		$criteria->compare('price_gr',$this->price_gr);
		$criteria->compare('alloy',$this->alloy);
		$criteria->compare('pure_hallmark',$this->pure_hallmark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "user_goodgroup".
 *
 * The followings are the available columns in table 'user_goodgroup':
 * @property string $userkod
 * @property string $groupkod
 * @property double $discount
 */
class UserGoodgroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserGoodgroup the static model class
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
		return 'user_goodgroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userkod, groupkod, discount', 'required'),
			array('discount', 'numerical'),
			array('userkod, groupkod', 'length', 'max'=>13),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userkod, groupkod, discount', 'safe', 'on'=>'search'),
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
			'group'=>array(self::BELONGS_TO, 'Group', 'groupkod'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userkod' => 'Userkod',
			'groupkod' => 'Groupkod',
			'discount' => 'Discount',
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

		$criteria->compare('userkod',$this->userkod,true);
		$criteria->compare('groupkod',$this->groupkod,true);
		$criteria->compare('discount',$this->discount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getDiscount($id){
		$criteria = new CDbCriteria;
		$criteria->condition = 'userkod = :userid';
		$criteria->order = 'groupkod desc';
		$criteria->params = array(':userid'=>$id);
		$discounts = self::model()->findAll($criteria);
		return $discounts;
	}
}
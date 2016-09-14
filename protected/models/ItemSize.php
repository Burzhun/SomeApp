<?php

 
class ItemSize extends CActiveRecord
{
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return '{{item_size}}';
	}
 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
  
			array('id, item_id, size, count', 'safe',  ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		  'item'=>array(self::BELONGS_TO, 'Item', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Товар',
			'size' => 'Описание',
			'count' => 'Количество',
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
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('size',$this->name);
		$criteria->compare('count',$this->filename);
 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
		protected function afterDelete()
{
parent::afterDelete();
Functions::dbupdate();
}
}
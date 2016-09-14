<?
class Goodgroup extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'goodgroup';
	}

	public function rules()
	{
		return array(
			array('kod, name', 'safe'),
		);
	}

	

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'goodgroup'=>array(self::HAS_MANY, 'Goods', 'groupkod'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'kod' => 'Код коллекции',
			'name' => 'Название коллекции',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('kod',$this->kod);
		$criteria->compare('name',$this->name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*public function createUrl()
	{
		return "catalog/".$this->collection->alias."/".$this->alias;
	}*/
}
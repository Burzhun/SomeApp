<?
class Group extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{group}}';
	}

	public function rules()
	{
		return array(
			array('collection_id, name', 'required'),
			array('collection_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			
			array('id, collection_id, name, description, seo_title, seo_keywords, seo_description, seotitle, seokeywords, seodescription', 'safe'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'collection'=>array(self::BELONGS_TO, 'Collection', 'collection_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'collection_id' => 'Collection',
			'name' => 'Название',
			'description' => 'Описание',
			'image' => 'Картинка',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('collection_id',$this->collection_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);
		$criteria->compare('seo_description',$this->seo_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function createUrl()
	{
		return "catalog/".$this->collection->alias."/".$this->alias;
	}
}
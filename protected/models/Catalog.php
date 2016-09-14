<?php


class Catalog extends CActiveRecord
{	




	public $image_form;
	// public $image_form2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catalog the static model class
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
		return '{{catalog}}';
	}

	public static function listData()
	{
		$array = array();
		$models=Catalog::model()->findAll('parent_id=:parent_id', array(':parent_id'=>0)); 
		foreach ($models as $model) {
			$array[$model->id] = "<b>$model->name</b>";
			foreach ($model->Sub as $child) {
				$array[$child->id] = "&nbsp&nbsp$child->name";
			}
		}
		return $array;
	}

	public function getCreateUrl()
	{
		$urlFromCache = Yii::app()->cache->get("catalog".$this->id);
		if($urlFromCache===false)
		{
			$catalog = $this;
			$urls[] = $this->alias;
			while ($catalog->Parent) {
				$catalog = $catalog->Parent;
				$urls[] = $catalog->alias;
			}
			$urls = array_reverse($urls);
			$url = implode("/", $urls);
			$url = "/catalog/".$url;
			Yii::app()->cache->set("catalog".$this->id, $url, 400);
			$urlFromCache = $url;
		}
		return $urlFromCache;
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('parent_id, position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('alias', 'unique'),
			
			array('id, name, parent_id, position, description,one, image, image_form, path', 'safe'),
		);
	}

	public function relations()
	{
		return array(
		'Items'=>array(self::HAS_MANY, 'Item', 'catalog_id'),
		'Sub'=>array(self::HAS_MANY, 'Catalog', 'parent_id',
										'order'=>'position, id DESC'),
		'SubActive'=>array(self::HAS_MANY, 'Catalog', 'parent_id',
										'order'=>'position, id DESC', 'condition'=> 'count>0'),
	 	'Parent'=>array(self::BELONGS_TO, 'Catalog', 'parent_id'),
		'ItemsCount'=>array(self::STAT, 'Item', 'catalog_id'),
       'itemsCount'=>array(self::STAT, 'Item', 'tbl_item_catalog(catalog_id,item_id)'),	
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'parent_id' => 'Родитель',
			'position' => 'Позиция',
			'description' => 'Описание',
			'one' => 'Название в ед.ч',
			'image_form' => 'Картинка',
			'alias' => 'URL',
		);
	}


	public function items()
	{
		$count = Yii::app()->cache->get("catalogcount".$this->id);
		if($count===false)
		{
			$sum = 0;
			$catalog = $this;
			if(!empty($catalog->Sub))
				foreach ($catalog->Sub as $item) {
							if(!empty($item->Sub)) {
								foreach ($item->Sub as $parent) {
									$sum+=$parent->itemsCount;				
								}
							}
							$sum+=$item->itemsCount;
					}
			$sum+=$catalog->itemsCount;

			$catalog->count = $sum;
			
			if($catalog->save())
		    {}
			$count = $sum;
			Yii::app()->cache->set("catalogcount".$this->id, $count, 400);
		}

		return $count;
	}

	public function getCount()
	{
		return $this->items();
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getChilds()
	{
		$model = $this;
		$childs = array();
		if(!empty($model->Sub))
		foreach ($model->Sub as $key => $level1) {
			$childs[] = $level1->id;
			if(!empty($level1->Sub))
				foreach ($level1->Sub as $key => $level2) {
					$childs[] = $level2->id;
					if(!empty($level3->Sub))
						foreach ($level2->Sub as $key => $level3) {
							$childs[] = $level3->id;
						}
				}
		}
		return $childs;
	}

	public function getItemIds()
	{
		$catalogs = $this->childs;
		$catalogs[] = $this->id;
		$ids = Yii::app()->db->createCommand()->select('item_id')->from('tbl_item_catalog')->where(array('in', 'catalog_id', $catalogs))->queryAll();
		$ids_item = Yii::app()->db->createCommand()->select('id')->from('tbl_item')->where(array('in', 'catalog_id', $catalogs))->queryAll();
		
		foreach ($ids as $key => $value)
			$items[] = $value['item_id'];
		
		foreach ($ids_item as $key => $value)
			$items[] = $value['id'];
		
		if(is_array($items))
			$items = array_unique($items);
		
		return $items;
	}

public function countZet()
{
$count = Yii::app()->cache->get("catalog3count".$this->id);
if($count===false)
{
	$count =  count($this->itemids);
	Yii::app()->cache->set("catalog3count".$this->id, $count, 400);
}

	
	
	protected function afterDelete()
{
    parent::afterDelete();
Functions::dbupdate();

	Item::model()->deleteAll('catalog_id='.$this->id);


}
}
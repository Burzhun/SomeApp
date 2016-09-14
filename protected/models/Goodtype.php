<?php


class Goodtype extends CActiveRecord
{
	public $primaryKey = array( 'idgoodtype' );
	public function getId()
	{
		return $this->idgoodtype;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return 'goodtype';
	}
	public function getcreateUrl()
	{
		return Yii::app()->controller->createUrl('catalog/view', array('idgoodtype' => $this->idgoodtype));
	}
	public function getcreateUrlByGroup($idGroup)
	{
		return Yii::app()->controller->createUrl('catalog/viewGroup', array('idgoodtype' => $this->idgoodtype,'idGroup' => $idGroup));
	}
 
	public function rules()
	{
 
		return array(
			//array('idgoodtype, name', 'required'),
			array('idgoodtype', 'length', 'max'=>13),
			array('name', 'length', 'max'=>250),
 
			array('idgoodtype, name, seo_title, seo_keywords, seo_description', 'safe'),
		);
	}

	/*public function countZet() {
		if(!$this->itemsCount)
			$count='';
		else $count=$this->itemsCount;
			return $count;
	}*/

	public function countGoods($id)
	{
		$count = Yii::app()->cache->get("cataloggood".$this->id."g".$id);
		if($count===false){
			$sql = "SELECT id FROM tbl_group_item WHERE item_id IN (SELECT kod FROM goods WHERE goodtype=".$this->id." AND publ = 0) AND group_id=".$id;
			$sqlCount = "SELECT COUNT(*) FROM ( ".$sql." ) AS result";
			$count=Yii::app()->db->createCommand($sqlCount)->queryScalar();
			if(!$count) 
				$count='';
			Yii::app()->cache->set("cataloggood".$this->id."g".$id, $count, 86400);
		}
		return $count;	
	}

	public function countInStock($groupId)
	{
		$count = Yii::app()->cache->get("instock"."g".$groupId);
		if($count===false){

			$count = count(Yii::app()->db->createCommand()->
			select('item_id')->
			from('tbl_group_item t')->join('goodstore gs', 't.item_id=gs.goodkod')->
			where('group_id='.$groupId)->
			queryColumn());

			/*$sql = "SELECT id FROM tbl_group_item WHERE item_id IN (SELECT kod FROM goods WHERE goodtype=".$this->id.") AND group_id=".$id;
			$sqlCount = "SELECT COUNT(*) FROM ( ".$sql." ) AS result";
			$count=Yii::app()->db->createCommand($sqlCount)->queryScalar();*/
			if(!$count) 
				$count='';
			Yii::app()->cache->set("instock"."g".$groupId, $count, 86400);
		}
		return $count;	
	}

	public function countInStockType($groupId, $goodtype){
		/*$count = Yii::app()->cache->get("instockType"."g".$groupId);
		if($count===false){*/

			$count = count(Yii::app()->db->createCommand()
				->select('t.item_id')
				->from('tbl_group_item t')
				->join('goodstore gs', 't.item_id=gs.goodkod')
				->join('goods g', 't.item_id=g.kod')
				->where('group_id='.$groupId.' AND g.goodtype='.$goodtype)
				->group('gs.goodkod')
				->queryColumn());

			/*$sql = "SELECT id FROM tbl_group_item WHERE item_id IN (SELECT kod FROM goods WHERE goodtype=".$this->id.") AND group_id=".$id;
			$sqlCount = "SELECT COUNT(*) FROM ( ".$sql." ) AS result";
			$count=Yii::app()->db->createCommand($sqlCount)->queryScalar();*/
			if(!$count) 
				$count='';
			/*Yii::app()->cache->set("instock"."g".$groupId, $count, 86400);
		}*/
		return $count;	
	}

	public function relations()
	{ 
		return array(
			'items'=>array(self::HAS_MANY, 'Goods', 'goodtype'),
			'itemsCount'=>array(self::STAT, 'Goods', 'goodtype'),

		);
	}

	public function getItemIds() {
		$ids_item = Yii::app()->db->cache(100000)->createCommand()->select('kod')->from('goods')->where('goodtype='.$this->idgoodtype)->queryColumn();
		
		return $ids_item;
	}

	public function attributeLabels()
	{
		return array(
			'idgoodtype' => 'Idgoodtype',
			'name' => 'Name',
		);
	}

	public function search()
	{
 
		$criteria=new CDbCriteria;

		$criteria->compare('idgoodtype',$this->idgoodtype,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function createUrl()
	{
		$collection = Yii::app()->request->getParam('collection');
		$group = Yii::app()->request->getParam('group');
		
		return "/catalog/".$collection."/".$group."/".$this->alias;
	}

	public static function ListData(){
		return CHtml::ListData(self::model()->findAll(), 'idgoodtype', 'name');
	}
	
	protected function afterFind()
	{
		parent::afterFind();
		
		
		if($this->alias == '')
		{
			$this->alias = strtolower(Functions::makeUrl($this->name));
			$this->save();
		}
		
		return true;
	}
}
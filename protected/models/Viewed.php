<?php

 
class Viewed extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	public function tableName()
	{
		return 'viewed';
	}
 
 	public static function getSession()
 	{
		$session=new CHttpSession;
		$session->open();
		$sess = $session->getsessionID(); 		
 		return $sess;
 	}

	public static function addProduct($product)
	{
		self::clear($product);
		$temp = new self;
		$temp->session = self::getSession();
		$temp->product = $product;
		$temp->date = time();
		$temp->save();
	}

	public static function clear($product)
	{
		self::model()->deleteAll("session ='".self::getSession()."' AND product = '".$product."'");
	}

	public function getLastProducts($count)
	{
		$products = Yii::app()->db->createCommand()->
			select('product, date')->
			from('viewed')->
			where("`session`='".self::getSession()."'")->
			limit($count)->
			order('date DESC')->
			queryColumn();
		return $products;
	}
}
<?php

class ShopsController extends Controller
{
	public function actionIndex()
	{	

		$criteria = new CDbCriteria;
		 
		$criteria->order = 'position, id ASC';
		$shops = Shops::model()->findAll($criteria);

		

		$shopsCity = Yii::app()->db->createCommand('SELECT DISTINCT city_id FROM `tbl_shops` ')
														->queryColumn();
														
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $shopsCity);
		  

		$city = City::model()->findAll($criteria);

		$this->render('index',array(
				'shops'=>$shops,
				'city'=>$city,

			));
	}
}
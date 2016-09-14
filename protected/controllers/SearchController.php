<?php

class SearchController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionIndex($query = "")
	{
		$criteria = new CDbCriteria;
		$criteria->compare('name',$query,true,'OR');
		$criteria->compare('marking',$query,true,'OR');
		$criteria->compare('description',$query,true,'OR');
		
		$pageSize = 50;
		if(Yii::app()->theme->name == 'roznica')
		{
			$goods = Yii::app()->db->createCommand()
				->select('goodkod')
				->from('goodstore gs')
				//->join('goods g', 't.item_id=g.kod')
				->group('gs.goodkod')
				->queryColumn();

			$pageSize = 20;
			$criteria->addInCondition('kod', $goods);
		}

		$criteria->addCondition('publ = 0');

		$dataProvider =  new CActiveDataProvider('Goods', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize,
			)
		));		
 
		$this->render('index', array(
			'dataProvider'=>$dataProvider,					
		));
	}
	
	public function actionSearchForm($query = "")
	{
		$pageSize = 20;
		if(isset($_POST['SearchForm'])){
			$criteria = new CDbCriteria;
			/*$criteria->compare('name',$query,true,'OR');
			$criteria->compare('marking',$query,true,'OR');
			$criteria->compare('description',$query,true,'OR');*/
			
			$group = str_pad($_POST['SearchForm']['group'], 9, "0", STR_PAD_LEFT);
			$type = $_POST['SearchForm']['type'];
					
			if(Yii::app()->theme->name == 'roznica'){
		
				$goods = Yii::app()->db->createCommand()
					->select('goodkod')
					->from('goodstore gs')
					->join('goods g', 'gs.goodkod=g.kod')
					->join('tbl_group_item gi', 'gs.goodkod=gi.item_id')
					->where('g.goodtype=:type AND gi.group_id=:group', array(':type'=>$type, ':group'=>$group))
					->group('gs.goodkod')
					->queryColumn();

					
				//$pageSize = 20;
				$criteria->addInCondition('kod', $goods);
			}
			$criteria->addCondition('publ = 0');
		}
		$dataProvider =  new CActiveDataProvider('Goods', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize,
				)
		));
 
		$this->render('index', array(
			'dataProvider'=>$dataProvider,					
		));
	}
}
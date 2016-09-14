<?php

class CollectionController extends Controller
{
	public $layout='//layouts/column2';
	public $name='Коллекции';

	public function actionView($alias){



		$collection = $this->loadModelByAlias($alias);

		if(!$collection){
			throw new CHttpException(404,'The requested page does not exist.');
		}

		if($_GET['price']){
			$price = $_GET['price'];
			$price = explode(';', $price);
			$priceFrom = $price[0];
			$priceTo = $price[1];

		}

		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			// unset($_GET['pageSize']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		if (isset($_GET['sort'])) {
			Yii::app()->user->setState('sort', $_GET['sort']);
			//unset($_GET['sort']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

	
			//$this->breadcrumbs[$collection->name] = Category::getBreadcrumbs($category->id, false);
			$this->breadcrumbs += array($collection->name);

			$sort = new CSort();
			$sort->sortVar = 'sort';
			$sort->defaultOrder = 't.marking DESC';
			$sort->attributes = array(
				'kod'=>array(
					'label'=>'новизне',
					'asc'=>'kod ASC',
					'desc'=>'kod DESC',
					'default'=>'desc',
				),
				'marking'=>array(
					'asc'=>'marking ASC',
					'desc'=>'marking DESC',
					'default'=>'desc',
					'label'=>'артикулу',
				),
				'price'=>array(
					'asc'=>'gs.price ASC',
					'desc'=>'gs.price DESC',
					'default'=>'desc',
					'label'=>'Цене',
				),
			);



			$criteria = new CDBcriteria;

			$ids = Goods::CollectionGoodsID($collection->id);


			$criteria->join = 'JOIN goodstore gs ON gs.goodkod = t.kod ';
			$criteria->join .= 'JOIN goodimage gi ON gi.good = t.kod';
			$criteria->addCondition('gi.filename <> ""');
			if($priceFrom){
				$criteria->addCondition("gs.price >= ".$priceFrom);
			}
			if($priceTo){
				$criteria->addCondition("gs.price <= ".$priceTo);
			}
			$criteria->distinct = true;
			$criteria->addInCondition('kod',$ids);

			$dataProvider = new CActiveDataProvider('Goods',array(
				'criteria'=>$criteria,
				'sort' => $sort,
				'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				)
			));

		
			$this->render('view',array(
				'collection'=>$collection,
				'dataProvider'=>$dataProvider,
				//'chields'=>$chields,
			));
	}

	public function loadModelByAlias($alias){
		$model = KubachinkaCollection::model()->find('alias=:alias',array(':alias'=>$alias));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}
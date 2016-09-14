<?php
class GoodsController extends Controller {
	
	public function actionPrice($kod, $stone = 0,$size = 0, $checkStone = 0)
	{
		$item = $this->loadModel($kod);
		$price = $item->getCalculatedPrice(array("stone"=>$stone, "size"=>$size, "checkStone"=>$checkStone));
		echo $price;
	}

	public function actionView($kod)
	{
		
		$model = $this->loadModel($kod); 
		Viewed::addProduct($kod);

		/*$sort = new CSort();
		$sort->defaultOrder = 'date DESC'; // устанавливаем сортировку по умолчанию
		$sort->attributes['id'] = array( // добавляем сортировку по postTitle
				'asc' => 'viewedGood.date',
				'desc' => 'viewedGood.date desc',
			);*/

		/*$criteriaLast = new CDbCriteria;
		$criteriaLast->addInCondition('kod',Viewed::getLastProducts(10));
		$criteriaLast->with = "viewedGood";
		$criteriaLast->order = 'date DESC';

		$dataProviderLast=new CActiveDataProvider('Goods', array('criteria' => $criteriaLast,
																));*/
		$cache_prev_id = "prev_".$model->kod;
		$cache_next_id = "next_".$model->kod;
		$prev_id=Yii::app()->cache->get($cache_prev_id);
		$next_id=Yii::app()->cache->get($cache_next_id);
		if($prev_id===false || $next_id===false)
		{
			$arr = $model->catalog->itemids;
			$criteria = new CDbCriteria;
			$criteria->addInCondition('kod',$arr);
			$criteria->order = "kod DESC";
			$models = Goods::model()->findAll($criteria);
			unset($arr);

			foreach ($models as $m)
			{
				$arr[] = $m->kod;
			}

			$key = array_search($model->kod, $arr);

			$prev_id = $arr[$key-1];
			$next_id = $arr[$key+1];
			Yii::app()->cache->set($cache_prev_id, $prev_id, 100000);
			Yii::app()->cache->set($cache_next_id, $next_id, 100000);
		}
			
		if($prev_id)
			$prev = $this->loadModel($prev_id);
		if($next_id)
			$next = $this->loadModel($next_id);


		/*$criteria = new CDbCriteria;
		$criteria->condition = "goodtype=".$model->catalog->id;
		$criteria->limit=10;
		$criteria->addCondition('kod !='.$model->id); 
		$dataProvider=new CActiveDataProvider('Goods', array('criteria' => $criteria));*/

		$groupItem = GroupItem::model()->cache(100000)->find('item_id=:kod',array(':kod'=>$kod));
		if($groupItem){
			$group = Group::model()->cache(100000)->findByPk($groupItem->group_id);
			$collection = $group->collection;

			/*$breadcrumbs = array('Коллекции' => array('/catalog'),
				$collection->name => array($collection->createUrl()),
				$group->name => array($group->createUrl()),
				$model->catalog->name => array($group->createUrl()."/".$model->catalog->alias),
				$model->name,
			);*/
			$breadcrumbs = array(
				0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
				1=>array("name"=>"Коллекции", "link"=>"/catalog", "title"=>"Коллекции ювелирных изделий"),
				2=>array("name"=>$collection->name, "link"=>'/'.$collection->createUrl(), "title"=>$collection->seo_title),
				3=>array("name"=>$group->name, "link"=>'/'.$group->createUrl(), "title"=>$group->seo_title),
				4=>array("name"=>$model->catalog->name, "link"=>'/'.$group->createUrl()."/".$model->catalog->alias, "title"=>$model->catalog->name." - ".$group->name." - продажа оптом"),
				5=>array("name"=>$model->name, "link"=>"", "title"=>""),
			);
		}else{
			$breadcrumbs = array('Каталог' => array('/catalog'),
				$model->catalog->name => $model->catalog->createurl,
				$model->name,
			);
		}

		if($model->catalog->name == 'Кольцо'){
			$isRing = true;
		}else{
			$isRing = false;
		}


		$this->activeCatalog = '/'.$group->createUrl();
		
		
		$this->render('view',array(
			//'dataProvider'=>$dataProvider,
			//'dataProviderLast'=>$dataProviderLast,
			'model'=>$model,
			'prev'=>$prev,
			'next'=>$next,
			'breadcrumbs'=>$breadcrumbs,
			'isRing' => $isRing,
		));
	}

	public function loadModel($kod)
	{
		$model = Goods::model()->cache(100000)->findByPk($kod);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionGetLastGoods()
	{
		$criteriaLast = new CDbCriteria;
		$criteriaLast->addInCondition('kod',Viewed::getLastProducts(10));
		$criteriaLast->addCondition('publ = 0');
		$criteriaLast->with = "viewedGood";
		$criteriaLast->order = 'date DESC';
		$criteriaLast->limit = '10';

		$dataProviderLast=new CActiveDataProvider('Goods', array('criteria' => $criteriaLast, 'pagination' => false));

		echo $this->renderPartial('lastgoods', array('dataProviderLast'=>$dataProviderLast), true);
	}

	public function actionGetLiketoo()
	{
		$criteria = new CDbCriteria;
		$criteria->condition = "publ = 0 AND goodtype=".$_POST['catalog_id'];
		$criteria->limit=10;
		$criteria->addCondition('kod !='.$_POST['model_id']);
		$dataProvider=new CActiveDataProvider('Goods', array('criteria' => $criteria));

		echo $this->renderPartial('liketoo', array('dataProvider'=>$dataProvider), true);
	}


	public function actionAjax()
	{
		$id = $_GET['id'];
		$model = $this->loadModel($id);
		  // $arr = $model->catalog->itemids;
		  // $criteria = new CDbCriteria;
		  // $criteria->addInCondition('id',$arr);
		  // $criteria->order = "position,id DESC";  
		  // unset($arr); 
		  // foreach ($models as $m) {
		  //   $arr[] = $m->id;
		  // } 
		  // $key = array_search($model->id, $arr);
		  // if($arr[$key-1])
		  // $prev = Item::model()->findByPk($arr[$key-1]);
		  // if($arr[$key+1])
		  // $next = Item::model()->findByPk($arr[$key+1]);
		
		$this->renderPartial('ajaxGoods',array(
		             'model'=>$model,
		              
		),false,false);		
	}

}
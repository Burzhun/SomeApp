<?php

class CatalogController extends Controller
{

	public $layout='//layouts/column2';

	public function actionGetGroup(){
		if(Yii::app()->request->isAjaxRequest){
			$id = Yii::app()->request->getParam('id');
			$collection = Collection::model()->findByPk($id);
			if(count($collection->groups)!=1)
				$select.='<option value="0">Выберите группу</option>';
			foreach ($collection->groups as $data) {
				$select.='<option value="'.$data->id.'">'.$data->name.'</option>';
			}
			echo $select;
		}
	}

	public function actionGetType(){
		if(Yii::app()->request->isAjaxRequest){
			$cid = Yii::app()->request->getParam('cid');
			$gid = Yii::app()->request->getParam('gid');

			Group::model()->findByPk();

			$models = Goodtype::model()->cache(100000)->findAll();
			$group = Group::model()->cache(100000)->find(array('condition'=>"id = '".$gid."' AND collection_id = '".$cid."'"));
			//$this->group = $group;

			$select.='<option value="0">Выберите группу</option>';
			foreach ($models as $parent) {
				$parentSize = $parent->countInStockType($group->id, $parent->id);
				if($parentSize){
					$select.='<option value="'.$parent->id.'">'.$parent->name.'</option>';
				}
			}


			echo $select;
		}
	}

	/*public function actionTest(){
		for($i=0; $i<1000000000000; $i++){
			//
		}
	}*/

	public function actionView($idgoodtype)
	{
		
		$model = $this->loadAlias($idgoodtype);
		$models = Goodtype::model()->findAll();
		$breadcrumbs["Каталог"] = array("index");
		$criteria = new CDbCriteria;
		$criteria->condition = "goodtype = '$idgoodtype' AND publ = 0";
		$criteria->order = "kod DESC";

		$dataProvider=new CActiveDataProvider('Goods', array(
			'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>20,
				)
		));

		$this->render('view', array(
			'model' => $model,
			'models' => $models,
			'breadcrumbs' => $breadcrumbs,
			'dataProvider' => $dataProvider,
		));
	}

	public function actionViewGroup()
	{
		//Проверяем правильность адреса
		//Для коллекции
		$collection_alias = Yii::app()->request->getParam('collection');
		$collection = Collection::model()->cache(100000)->find(array('condition'=>"alias = '".$collection_alias."'"));

		if(!$collection)
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

		//Для группы относительно коллекции
		$group_alias = Yii::app()->request->getParam('group');
		$group = Group::model()->cache(100000)->find(array('condition'=>"alias = '".$group_alias."' AND collection_id = '".$collection->id."'"));

		if(!$group)
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

		//Для группы относительно коллекции
		$goodType_alias = Yii::app()->request->getParam('goodtype');
		$goodType = Goodtype::model()->cache(100000)->find(array('condition'=>"alias = '".$goodType_alias."'"));

		if(!$goodType)
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

		if (isset($_GET['pageSize']))
		{
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			// unset($_GET['pageSize']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		if (isset($_GET['sort']))
		{
			Yii::app()->user->setState('sort',$_GET['sort']);
			//unset($_GET['sort']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		$sort = new CSort();
		$sort->defaultOrder = str_replace('.', ' ', Yii::app()->user->getState('sort', 'kod DESC'));
		$sort->attributes = array(
			'new'=>array(
				'label'=>'новизне',
				'asc'=>'kod ASC',
				'desc'=>'kod DESC',
				'default'=>'kod DESC',
			),
			'marking'=>array(
				'label'=>'артикулу',
				'asc'=>'marking ASC',
				'desc'=>'marking DESC',
				'default'=>'ASC',
			),
		);
		$pagination = array('pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']));

		$model = $goodType;
		//$models = Goodtype::model()->findAll();

		//$breadcrumbs["Каталог"] = array("index");

		/*$breadcrumbs = array(
			//'Каталог' => array('/catalog'),
			'Коллекции' => array('/catalog'),
			$collection->name => array($collection->createUrl()),
			$group->name => array($group->createUrl()),
			$model->name,
		);*/

		$breadcrumbs = array(
			0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
			1=>array("name"=>"Коллекции", "link"=>"/catalog", "title"=>"Коллекции ювелирных изделий"),
			2=>array("name"=>$collection->name, "link"=>'/'.$collection->createUrl(), "title"=>$collection->seo_title),
			3=>array("name"=>$group->name, "link"=>'/'.$group->createUrl(), "title"=>$group->seo_title),
			4=>array("name"=>$model->name, "link"=>"", "title"=>$model->name." - ".$group->name." - продажа оптом"),
		);

		if(Yii::app()->theme->name == 'roznica')
		{
			$models = Goodtype::model()->cache(100000)->findAll();
			$this->categoryModels = $models;
			$this->group = $group;

			$sort = new CSort();
			$sort->sortVar = 'sort';
			$sort->defaultOrder = 't.name ASC';
			$sort->attributes = array(
						'name'=>array(
							'label'=>'названию',
							'asc'=>'name ASC',
							'desc'=>'name DESC',
							'default'=>'desc',
						),
						'price'=>array(
							'asc'=>'gs.price ASC',
							'desc'=>'gs.price DESC',
							'default'=>'desc',
							'label'=>'цене',
						),
					);

			if($_GET['price'])
			{
				$price = $_GET['price'];
				$price = explode(';', $price);
				$priceFrom = $price[0];
				$priceTo = $price[1];
			}

			$dataProvider = Goods::getGroupDataProviderItemByCatInStock($group->id, $model->id, $sort, $pagination,  $priceFrom, $priceTo);
		} else {
			$dataProvider = Goods::getGroupDataProviderItemByCat($group->id, $model->id, $sort, $pagination);
		}

		$this->render('view', array(
			'model' => $model,
			'group' => $group,
			//'models' => $models,
			'breadcrumbs' => $breadcrumbs,
			'dataProvider' => $dataProvider,
		));
	}



	public function actionIndex()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(date) FROM tbl_order');

		if(Yii::app()->theme->name == 'roznica'){

			$popularGoods = Yii::app()->db->cache(100000, $dependency)->createCommand()
				->select('  `item_id` , COUNT( item_id ) AS  `count_item`')
				->from('tbl_order_item')
				->join('goodstore gs', 'gs.goodkod=item_id')
				->group('item_id')
				->order('count_item DESC')
				->limit(8)
				->queryColumn();
		}else{
			$popularGoods = Yii::app()->db->cache(100000, $dependency)->createCommand()->
				select('  `item_id` , COUNT( item_id ) AS  `count_item`')->
				from('tbl_order_item')->
				group('item_id')->
				order('count_item DESC')->
				limit(8)->
				queryColumn();
		}

		$criteria = new CDbCriteria;// print_r($groupGoods);

		$criteria->addInCondition('kod',$popularGoods);
		$criteria->addCondition('publ = 0');

		$popularDataProvider=new CActiveDataProvider('Goods', array(
											'criteria'=>$criteria,
											'pagination'=>array(
												'pageSize'=>20,
											)
										));

		$dependecy = new CDbCacheDependency('SELECT MAX(kod) FROM goods');

		$month = date('Y-m-d H:m:s', time() - Goods::$noveltiLeftTime);
		if(Yii::app()->theme->name == 'roznica') {
			$noveltyDataProvider = new CActiveDataProvider('Goods',
															array(
																'criteria'=>array(
																	'condition'=>'publ = 0 AND new > :month',
																	'join'=>'INNER JOIN goodstore gs ON gs.goodkod=t.kod',
																	'order'=>'RAND()',
																	'params' => array(':month' => $month),
																	//'limit'=>1,
																),
																'pagination'=>array(
																	'pageSize'=> 8,
																),
																'totalItemCount'=>8,
															));
		} else {
			$noveltyDataProvider = new CActiveDataProvider(Goods::model()->cache(10000, $dependecy),
															array(
																'criteria'=>array(
																	'condition'=>'publ = 0 AND new > :month',
																	'order'=>'RAND()',
																	'params' => array(':month' => $month),
																	//'limit'=>1,
																),
																'pagination'=>array(
																	'pageSize'=> 8,
																),
																'totalItemCount'=>8,
															));
		}

		$breadcrumbs = array(
			0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
			1=>array("name"=>"Коллекции", "link"=>"", "title"=>"Коллекции ювелирных изделий"),
		);

		$this->render('collection',array(
			'popularDataProvider'=>$popularDataProvider,
			'noveltyDataProvider'=>$noveltyDataProvider,
			'breadcrumbs' => $breadcrumbs,
		));
	}

	public function actionStore()
	{	//print_r($_GET);

		$collectionGoodsStoreIDs = array();
		$collection_alias = Yii::app()->request->getParam('collection');
		$collection = Collection::model()->cache(40000)->find(array('condition'=>"alias = '".$collection_alias."'"));
//echo $collection->alias;
		if(!$collection)
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

		//Для группы относительно коллекции
		$group_alias = Yii::app()->request->getParam('group'); //echo $group_alias; die('Ok');

		if($group_alias){
			$group = Group::model()->cache(40000)->find(array('condition'=>"alias = '".$group_alias."' AND collection_id = '".$collection->id."'"));

			if(!$group)
				throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

			$groupId = $group->id; //die($groupId);

			//$breadcrumbs["Каталог"] = array("index");

			/*$breadcrumbs = array(
				//'Каталог' => array('/catalog'),
				'Коллекции' => array('/catalog'),
				$collection->name => array($collection->createUrl()),
				$group->name => array($group->createUrl()),
				'В наличии',
			);*/

			$breadcrumbs = array(
				0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
				1=>array("name"=>"Коллекции", "link"=>"/catalog", "title"=>"Коллекции ювелирных изделий"),
				2=>array("name"=>$collection->name, "link"=>'/'.$collection->createUrl(), "title"=>$collection->seo_title),
				3=>array("name"=>$group->name, "link"=>'/'.$group->createUrl(), "title"=>$group->seo_title),
				4=>array("name"=>"В наличии", "link"=>"", "title"=>$group->name." в наличии - продажа оптом"),
			);
			// $groupId = 4;
			/*$criteria = new CDbCriteria;
			$criteria->select = 'item_id';
			$criteria->condition = 'group_id=:id';
			$criteria->params = array(':id'=>$groupId);*/
			
			//$groupGoods = GroupItem::model()->findAll($criteria);

			

		}else{ 
			$criteria = new CDbCriteria;
			$collectionGoodsStoreIDs = Goods::getCollectionGoodStoreIDs($collection->id); //print_r($collectionGoodsStoreIDs);
			$criteria->addInCondition('kod', $collectionGoodsStoreIDs);
			$breadcrumbs = array(
				0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
				1=>array("name"=>"Коллекции", "link"=>"", "title"=>$collection->name),
			);
		}

		$addCriteriaStart = "";
			$addCriteriaEnd = "";

			if(isset($_GET['filter-size-start']))
			{
				if($_GET['filter-size-start'])
					$addCriteriaStart = " AND gs.goodsize >= '".$_GET['filter-size-start']."'";
			}
			if(isset($_GET['filter-size-end']))
			{
				if($_GET['filter-size-end'])
					$addCriteriaEnd = " AND gs.goodsize <= '".$_GET['filter-size-end']."'";
			}

			if($_GET['filterPriceTo'] || $_GET['filterPriceFrom']){
				$priceFrom = $_GET['filterPriceFrom'];
				$priceTo = $_GET['filterPriceTo'];
				if((Yii::app()->session->get("admin") == 1)) {
					if(isset($priceFrom)) $queryPriceFrom = ' AND gs.price > '.$priceFrom.'*2 ';
					if(isset($priceTo)) $queryPriceTo = ' AND gs.price < '.$priceTo.'*2 ';
					$addSql = $queryPriceFrom.$queryPriceTo;
				}else{
					if(!empty($priceFrom)) $queryPriceFrom = ' AND gs.price > '.$priceFrom.' ';
					if(!empty($priceTo)) $queryPriceTo = ' AND gs.price < '.$priceTo.' ';
					$addSql = $queryPriceFrom.$queryPriceTo;
				}

			}

				if($groupId){
					$groupIdstr = 'group_id='.$groupId;
				}else{
					$groupIdstr = '1=1 ';
				}
				
			if($_GET['filter-stonekod']) {//die('1');

				$colorName = $_GET['filter-stonekod'];
				$groupGoodsSql = Yii::app()->db->/*cache(40000)->*/createCommand()
					->select('t.item_id, t.group_id, gs.price, gs.serialkod')
					->from('tbl_group_item t')
					->join('goodstore gs', 't.item_id=gs.goodkod')
					->join('stone st', 'gs.stonekod=st.kod')
					->where($groupIdstr.$addCriteriaStart.$addCriteriaEnd.' AND st.color="'.$colorName.'"'.$addSql)
					->order('gs.goodsize DESC')
					->queryAll();
			} else { 
				$groupGoodsSql = Yii::app()->db->/*cache(40000)->*/createCommand()
					->select('t.item_id, t.group_id, gs.price, gs.serialkod')
					->from('tbl_group_item t')
					->join('goodstore gs', 't.item_id=gs.goodkod')
					->where($groupIdstr.$addCriteriaStart.$addCriteriaEnd.$addSql)
					->order('gs.goodsize DESC')
					->queryAll();
			}

			//echo $groupIdstr.$addCriteriaStart.$addCriteriaEnd.$addSql; die();

			if((Yii::app()->session->get("admin") == 1)&&($price)) {
				foreach ($groupGoodsSql as $data) {
					$item = Goods::model()->findByPk($data['item_id']);
					$pricegood = $item->getCalculatedPrice(array("serialkod"=>$data['serialkod'], "withoutRub"=>true));

					if($pricegood<$price){
						$groupGoods[]=$data['item_id'];
					}
				}
			} else {
				if(!isset($_GET['group'])){ //die('dddd');
					if(count($collectionGoodsStoreIDs)){
						$groupGoods = $collectionGoodsStoreIDs;
					} else {
						$groupGoods[] = -1;
					}
				} else {
					foreach ($groupGoodsSql as $data) {
						$groupGoods[]=$data['item_id'];
					}
				}
			}

			//print_r($groupGoods);


				/*$criteria = new CDbCriteria;
			$criteria->addInCondition('kod',$groupGoods);
			/*$criteria->with = array('goodstore');
			$criteria->order = 'goodstore.goodsize DESC';*/

			/*$criteria = new CDbCriteria;
			$criteria->join = 'INNER JOIN tbl_group_item gd ON t.kod = gd.item_id
							  INNER JOIN goodstore gs ON gs.goodkod = t.kod';
			$criteria->order = 'gs.goodsize DESC';
			$criteria->condition = 'gd.group_id=:id';
			$criteria->params = array(':id'=>$groupId);*/

			$criteria = new CDbCriteria;// print_r($groupGoods);

			$addCriteria = "1=1";
			if(isset($_GET['filterArticul']))
			{
				//if($_GET['filterArticul'])
					$addCriteria = "marking LIKE '%".$_GET['filterArticul']."%'";

			}

			//print_r($groupGoods);

			$criteria->addInCondition('kod',$groupGoods);
			$criteria->addCondition('publ = 0');
			$criteria->addCondition($addCriteria);

			/*if(in_array('0002115', $groupGoods))
				die('Ok');*/

			//print_r($criteria); die();

		$criteria->order = 'new DESC';
		$dataProvider=new CActiveDataProvider('Goods', array(
											'criteria'=>$criteria,
											'pagination'=>array(
											'pageSize'=>20,)
										));

		$this->render('store',array(
			'dataProvider'=>$dataProvider,
			'breadcrumbs'=>$breadcrumbs,
			'group'=>$group,
		));
	}


	/*Товары коллекции в наличии*/
	public function actionCollectionStore($collection){

		$collection = Collection::model()->find('alias=:alias',array(':alias'=>$collection));

		$collectionGoodsStoreIDs = Goods::getCollectionGoodStoreIDs($collection->id);

		$criteria = new CDbCriteria;
		$criteria->addInCondition('kod', $collectionGoodsStoreIDs);
		$dataProvider=new CActiveDataProvider('Goods', array(
											'criteria'=>$criteria,
											'pagination'=>array(
											'pageSize'=>20,)
										));

		$breadcrumbs = array(
			0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
			1=>array("name"=>"Коллекции", "link"=>"", "title"=>$collection->name),
		);

		$this->render('collection',array(
			'dataProvider'=>$dataProvider,
			'breadcrumbs'=>$breadcrumbs,
			'collection'=>$collection,
		));
	}

	public function actionCollection(){

		 $collection = Collection::model()->cache(40000)->findAll();
		 $this->render('collection',array(
			'collection'=>$collection));
	}

	/*public function actionGroup(){
		$collection_id = Yii::app()->request->getParam('id');
		$collection = Collection::model()->findByPk($collection_id);
		$groups = Group::model()->findAll('collection_id=:id',array(':id'=>$collection_id));

		if($groups){
			$this->render('group',array(
			'groups'=>$groups,
			'collection'=>$collection));
		}else{
			$this->redirect(array('index'));
		}
	}*/


	public function actionGroup()
	{

		$collection_alias = Yii::app()->request->getParam('collection');
		$collection = Collection::model()->find(array('condition'=>"alias = '".$collection_alias."'"));

		if(!$collection)
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

		$groups = $collection->getGroups();

		/*if(count($groups) == 1)
		{
			$this->redirect(array('catalog/groupItem', 'collection'=>$collection->alias, 'group'=>$groups[0]->alias));
		}*/

		//$groups = Group::model()->cache(100000)->findAll('collection_id=:id',array(':id'=>$collection->id));

		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			// unset($_GET['pageSize']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		if (isset($_GET['sort'])) {
			Yii::app()->user->setState('sort', $_GET['sort']);
			//unset($_GET['sort']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		$sort = new CSort();
		$sort->defaultOrder = str_replace('.', ' ', Yii::app()->user->getState('sort', 'kod DESC'));
		$sort->attributes = array(
			'new'=>array(
				'label'=>'новизне',
				'asc'=>'kod ASC',
				'desc'=>'kod DESC',
				'default'=>'kod DESC',
			),
			'marking'=>array(
				'label'=>'артикулу',
				'asc'=>'marking ASC',
				'desc'=>'marking DESC',
				'default'=>'ASC',
			),
		);

		//зависимость от колличества товара. Не нужно, так как колличество может остаться такое же, а цена может поменяться
		//$dependecy = new CDbCacheDependency('SELECT MAX(kod) FROM goods');

		//Если сайт розничный, кубачинка
		if(Yii::app()->theme->name == 'roznica')
		{
			$goods = Yii::app()->db->createCommand()
				->select('goodkod')
				->from('goodstore gs')
				//->join('goods g', 't.item_id=g.kod')
				->group('gs.goodkod')
				->queryColumn();

			$criteria = new CDbCriteria;
			$criteria->condition = "publ = 0 AND collection_id = ".$collection->id;
			$criteria->addInCondition('kod', $goods);

			$dataProvider = new CActiveDataProvider('Goods',
														array(
															'criteria'=>$criteria,
															'sort'=>$sort,
															'pagination'=>array(
																'pageSize'=> Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
															),
														));
		}else{ // если оптовый, агра голд
			$dataProvider = new CActiveDataProvider('Goods',
														array(
															'criteria'=>array(
																'condition' => "publ = 0 AND collection_id = ".$collection->id,
															),
															'sort'=>$sort,
															'pagination'=>array(
																'pageSize'=> Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
															),
														));
		}


		$breadcrumbs = array(
			0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
			1=>array("name"=>"Коллекции", "link"=>"/catalog", "title"=>"Коллекции ювелирных изделий"),
			2=>array("name"=>$collection->name, "link"=>"", "title"=>$collection->seo_title),
		);

		$this->render('group',array(
			'dataProvider'=>$dataProvider,
			'collection' => $collection,
			'groups' => $groups,
			'breadcrumbs' => $breadcrumbs,
		));
	}


	public function actionGroupItem()
	{
		$breadcrumbs=array();

		//Проверяем правильность адреса
		//Для коллекции
		$collection_alias = Yii::app()->request->getParam('collection');
		$collection = Collection::model()->cache(100000)->find(array('condition'=>"alias = '".$collection_alias."'"));

		if(!$collection)
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

		//Если есть параметр количества записей на страницу, то принимаем и запоминаем его
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		   // unset($_GET['pageSize']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		//Если есть параметр сортировка, то принимаем и запоминаем его
		if (isset($_GET['sort'])) {
			Yii::app()->user->setState('sort',$_GET['sort']);
			//unset($_GET['sort']);  // сбросим, чтобы не пересекалось с настройками пейджера
		}

		//сортировка
		$sort = new CSort();
		//по умолчанию сортируем по артикулу
		$sort->defaultOrder = str_replace('.', ' ', Yii::app()->user->getState('sort', 'kod DESC'));
		$sort->attributes = array(
			'new'=>array(
				'label'=>'новизне',
				'asc'=>'kod ASC',
				'desc'=>'kod DESC',
				'default'=>'kod DESC',
			),
			'marking'=>array(
				'asc'=>'marking ASC',
				'desc'=>'marking DESC',
				'default'=>'ASC',
				'label'=>'артикулу',
			),
		);

		//массив постраничной навигации. На всякий случай пихаем дефаултное колличество заданное в config/params
		$pagination = array('pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']));

		$models = Goodtype::model()->cache(100000)->findAll();

		//если параметр group равен novelty то нам нужно показать новинки из данной коллекции
		$group_alias = Yii::app()->request->getParam('group');
		if($group_alias == 'novelty')
		{
			$month = date('Y-m-d H:m:s', time() - Goods::$noveltiLeftTime);
			$criteria = new CDbCriteria;
			$criteria->addCondition("collection_id = '".$collection->id."' AND new > :month"); //echo
			$criteria->order = 'new DESC';
			$criteria->params = array(':month' => $month);
			$groupData = $dataprovider = new CActiveDataProvider("Goods",array(
							'criteria'=>$criteria,
							'sort'=>$sort,
							'pagination'=>$pagination
						));


			$breadcrumbs = array(
				0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
				1=>array("name"=>"Коллекции", "link"=>"/catalog", "title"=>"Коллекции ювелирных изделий"),
				2=>array("name"=>$collection->name, "link"=>'/'.$collection->createUrl(), "title"=>$collection->seo_title),
				3=>array("name"=>'Новинки', "link"=>"", "title"=>'Новинки'),
			);

			$this->render('groupnovelty',array(
				'dataProvider'=>$groupData,
				'models'=>$models,
				'groupM'=>$group,
				'collection'=>$collection,
				'breadcrumbs'=>$breadcrumbs,
			));

		} else {
			//Проверяем правильность адреса
			//Для группы относительно коллекции
			$group = Group::model()->cache(100000)->find(array('condition'=>"alias = '".$group_alias."' AND collection_id = '".$collection->id."'"));

			if(!$group)
				throw new CHttpException(404,'Запрашиваемой страницы не найдено!');

			$idGroup = $group->id;

			// если сайт розничный, кубачинка
			if(Yii::app()->theme->name == 'roznica')
			{
				$this->categoryModels = $models;
				$this->group = $group;

				if($_GET['price']){
					$price = $_GET['price'];
					$price = explode(';', $price);
					$priceFrom = $price[0];
					$priceTo = $price[1];

					/*if((Yii::app()->session->get("admin") == 1)&&($price)){
						$price = $price*2;
					}else{
						$price = $price;
					}*/
				}

				$sort = new CSort();
				$sort->sortVar = 'sort';
				$sort->defaultOrder = 't.name ASC';
				$sort->attributes = array(
							'name'=>array(
								'label'=>'названию',
								'asc'=>'name ASC',
								'desc'=>'name DESC',
								'default'=>'desc',
							),
							'price'=>array(
								'asc'=>'gs.price ASC',
								'desc'=>'gs.price DESC',
								'default'=>'desc',
								'label'=>'цене',
							),
							/*'article'=>array(
								'asc'=>'t.article ASC',
								'desc'=>'t.article DESC',
								'default'=>'desc',
								'label'=>'умолчанию',
							),

							'date'=>array(
								'asc'=>'created ASC',
								'desc'=>'created DESC',
								'default'=>'desc',
								'label'=>'дате',
							),*/
						);
				$groupData = Goods::getGroupDataProviderItemInStock($idGroup, $sort, $pagination, $priceFrom, $priceTo);
			} else {
				$groupData = Goods::getGroupDataProviderItem($idGroup, $sort, $pagination);
			}

			$breadcrumbs = array(
				0=>array("name"=>"Главная", "link"=>"/", "title"=>"Агра голд"),
				1=>array("name"=>"Коллекции", "link"=>"/catalog", "title"=>"Коллекции ювелирных изделий"),
				2=>array("name"=>$collection->name, "link"=>'/'.$collection->createUrl(), "title"=>$collection->seo_title),
				3=>array("name"=>$group->name, "link"=>"", "title"=>$group->seo_title),
			);

			$this->render('groupgoods',array(
				'dataProvider'=>$groupData,
				'models'=>$models,
				'groupM'=>$group,
				'collection'=>$collection,
				'breadcrumbs'=>$breadcrumbs,
			));
		}
	}

	/*
	Эта функция мне нужна была когда я перекидывал товары из agra-gold.ru на alania-gold.ru
	Конкретное предназначение:
	Формирование цены для каждого товара и сохраненние ее для каждой записи временной таблицы(temp_goods) сформированной ранее на основе таблицы goods
	*/
	/*public function actionSetDefaultPrice(){
		$temp_goods = TempGoods::model()->findAll();
		foreach($temp_goods as $goodtempitem){
			$good = Goods::model()->find('kod = :id',array(':id'=>$goodtempitem->kod));
			$price = trim($good->getCalculatedPrice(),'р.');
			$price = trim($price);
			$price = str_replace(" ","",$price);
			$goodtempitem->price = (int)$price;
			$goodtempitem->save(false);

		}
		echo 'Success!';
	} */


	public function loadAlias($idgoodtype)
	{

		$model=Goodtype::model()->find('idgoodtype=:idgoodtype', array(':idgoodtype'=>$idgoodtype));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
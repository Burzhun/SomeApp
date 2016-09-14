<?php

class CategoryController extends Controller
{
	public $layout='//layouts/column2';

	public function actionView($alias)
	{
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


		if($alias == 'raznoe'){
			$dataProvider = Goods::StoreGoodsDataProviderOther($priceFrom, $priceTo);
			$this->breadcrumbs += array('Разное');
		}else{
			$category = Category::getCategoryByFullUrl('/category/'.$alias);

			if(!$category){
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}

			$chields = $category->children();


			$this->breadcrumbs = Category::getBreadcrumbs($category->id, false);
			$this->breadcrumbs += array($category->name);

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
			//$criteria->condition = "category_id=:category_id";
			//$criteria->params = array(':category_id'=>$category->id);

			$ids = Goods::CategoryGoodsID($category->id);

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
			/*if($category->extraCategory){
				foreach ($category->extraCategory as $data)
				{
					$extraCategory[] = $data->item_id;
				}
				$criteria->addInCondition('id', $extraCategory, 'OR');
			}*/


			$dataProvider = new CActiveDataProvider('Goods',array(
				'criteria'=>$criteria,
				'sort' => $sort,
				'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				)
			));
		}

		$this->activeCatalogId = $category->id;

		/*if(Yii::app()->request->isAjaxRequest)
		{
			$this->renderPartial('view',array(
				//'category'=>$category,
				'dataProvider'=>$dataProvider,
				//'chields'=>$chields,
			), false, false);
		} else {*/
			
			$this->render('view',array(
				'category'=>$category,
				'dataProvider'=>$dataProvider,
				'chields'=>$chields,
			));
		//}
	}

	public function actionIndex(){

		$categoryes = Category::model()->findAll('parent_id=0');
		$this->breadcrumbs += array('Коллекции');
		$this->render('index',array(
			'categoryes'=>$categoryes,
		));
	}

	public function actionNew()
	{
		$time = time()-(86400*2*7);
		$criteria = new CDbCriteria;
		$criteria->condition = "created>$time";

		if(!Yii::app()->request->getParam('Item_sort')){
			$criteria->order = "created DESC";
		}

		$sort = new CSort();
		$sort->sortVar = 'sort';
		$sort->defaultOrder = 't.created DESC';
		$sort->attributes = array(
			'name'=>array(
				'label'=>'Названию',
				'asc'=>'name ASC',
				'default'=>'desc',
				'desc'=>'name DESC',
			),
			'price'=>array(
				'asc'=>'price ASC',
				'desc'=>'price DESC',
				'default'=>'desc',
				'label'=>'Цене',
			),
			'created'=>array(
				'asc'=>'created ASC',
				'desc'=>'created DESC',
				'default'=>'desc',
				'label'=>'Дате',
			),
			'article'=>array(
				'asc'=>'t.article ASC',
				'desc'=>'t.article DESC',
				'default'=>'desc',
				'label'=>'Артикул',
			),
		);

		$dataProvider=new CActiveDataProvider('Item', array(
			'criteria'=>$criteria,
			'sort' => $sort,
			'pagination'=>array(
			'pageSize'=>30,)
		));



		$this->breadcrumbs += array('Новинки');


		$this->render('view', array(
			'dataProvider' => $dataProvider,
		));
	}
}
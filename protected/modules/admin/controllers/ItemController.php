<?php

class ItemController extends Controller
{
 


	public $layout='/layouts/column2';

	protected function processAttributes(Item $model)
	{
		$attributes = new CMap(Yii::app()->request->getPost('Attribute', array()));
		if(empty($attributes))
			return false;

		$deleteModel = Item::model()->findByPk($model->id);
		$deleteModel->deleteEavAttributes(array(), true);

		// Delete empty values
		foreach($attributes as $key=>$val)
		{
			if(is_string($val) && $val === '')
				$attributes->remove($key);
		}

		return $model->setEavAttributes($attributes->toArray(), true);
	}


	protected function processSizes(Item $model)
	{
 		return 1;
	}


	public function actionView($catalog_id)
	{


	$model = Catalog::model()->findByPk($catalog_id);		
	//вычисление динамических хлебных крошек

		$breadcrumbs = array();

		// текущие
		$breadcrumbs["Товары"] = array('item/view','catalog_id' => $model->id);
		$breadcrumbs[$model->name] = array('catalog/index','parent_id' => $model->id);
		
		
		$parent_id = $model->parent_id;
		while ($parent_id != 0) {
			$temp = Catalog::model()->findByPk($parent_id);
			$parent_id = $temp->parent_id;
			$breadcrumbs[$temp->name] = array('catalog/index', parent_id => $temp->id);
		}
		$breadcrumbs["Каталог"] = array('catalog/index');
		$breadcrumbs["Админка"] = array('/admin');
		//и реверс
		$breadcrumbs = array_reverse($breadcrumbs);





		$dataProvider=new CActiveDataProvider('Item',array(
											'criteria'=>array(
												'condition'=>'catalog_id='.$catalog_id,
												'order'=>'position, id DESC',
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));
		
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'breadcrumbs'=>$breadcrumbs,
					'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->performAjaxValidation($model);	
		$catalog_id = (int)$_GET['catalog_id'];
		$model = Catalog::model()->findByPk($catalog_id);	
		//вычисление динамических хлебных крошек
		$breadcrumbs = array();
		// текущие
		$breadcrumbs[$model->name] = " ";
		$parent_id = $model->parent_id;
		while ($parent_id != 0) {
			$temp = Catalog::model()->findByPk($parent_id);
			$parent_id = $temp->parent_id;
			$breadcrumbs[$temp->name] = array('catalog/index', id => $temp->id);
		}
		$breadcrumbs["Каталог"] = array('catalog/index');
		$breadcrumbs["Админка"] = array('/admin');
		//и реверс
		$breadcrumbs = array_reverse($breadcrumbs);
		$subcatalog = Catalog::model()->findByPk($catalog_id);
		$catalog = Catalog::model()->findByPk($subcatalog->parent_id);
		$model=new Item;
		$model->catalog_id = $catalog_id;
		$model->country_id = 0;
		$model->manufacter_id = 0;

		if(isset($_POST['Item']))
		{
			$model->attributes =$_POST['Item'];
			if(!empty($_POST['Item']['catalogs']))
			$model->catalogs = $_POST['Item']['catalogs'];

		if(!$model->alias) $model->alias = Translit::url($model->name);

		if($model->saveWithRelated('catalogs')){
			$this->processAttributes($model);
			$this->processSizes($model);

		if($_POST['main'] ==1)
		{	
			$a = new ItemMain;
			$a->item_id = $model->id;
			$a->save();	
		}	

		if(isset($_FILES['files']))
		{
			foreach($_FILES['files']['name'] as $key=>$filename) {
					$itemimg = new ItemImage;					
			$name  =  ImageFuck::save($_FILES['files']['tmp_name'][$key]);
			$itemimg->filename = $name;	
			$itemimg->item_id = $model->id;
			$itemimg->save();
				//move_uploaded_file($_FILES['files']['tmp_name'][$key],Yii::app()->params['uploadDir'].$filename);
		}}
		 Yii::app()->user->SetFlash('success', "Товар <b>$model->name</b> добавлен!");	
			$this->redirect(array('catalog/index','parent_id'=>$catalog_id));
		}
		
		}
		$this->render('create',array(
			'model'=>$model,
			'subcatalog'=>$subcatalog,
			'breadcrumbs'=>$breadcrumbs,
			'catalog'=>$catalog,
		));
	}

		public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {
            $model = Item::model()->findByPk($item);
            $model->position = $i;
            $model->save();
            $i++;
        }
      }
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

 		$this->performAjaxValidation($model);
		$model1=$this->loadModel($id);

		if($_POST['main'] ==1)
		{	
			$a = new ItemMain;
			$a->item_id = $model1->id;
			$a->save();	
		}	

		$dataProvider=new CActiveDataProvider('ItemImage',array(
                            'criteria'=>array(
                                'condition'=>'item_id='.$model1->id,
                                'order'=>'position, id DESC',
                            ),
                            'pagination'=>array(
                                'pageSize'=>100,
                            ),
		));

		$model = Catalog::model()->findByPk($model1->catalog_id);		
		//вычисление динамических хлебных крошек
		$breadcrumbs = array();
		// текущие
		$breadcrumbs["Изменить товар $model1->name"] = " ";
		$breadcrumbs[$model->name] = array('catalog/index', 'parent_id' => $model1->catalog_id);
		
		$parent_id = $model->parent_id;
		while ($parent_id != 0) {
			$temp = Catalog::model()->findByPk($parent_id);
			$parent_id = $temp->parent_id;
			$breadcrumbs[$temp->name] = array('catalog/index', id => $temp->id);
		}
		$breadcrumbs["Каталог"] = array('catalog/index');
		$breadcrumbs["Админка"] = array('/admin');
		//и реверс
		$breadcrumbs = array_reverse($breadcrumbs);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Item']))
		{	
			$model1->attributes=$_POST['Item'];
			if(!empty($_POST['Item']['catalogs']))
			$model1->catalogs = $_POST['Item']['catalogs'];
			
			if(!$model->alias)
			$model->alias = Translit::url($model->name);

			if($model1->saveWithRelated('catalogs')){
		$this->processAttributes($model1);
				$this->processSizes($model1);
		if(isset($_FILES['files']))
		{
			foreach($_FILES['files']['name'] as $key=>$filename) {
					$itemimg = new ItemImage;					
			$name  =  ImageFuck::save($_FILES['files']['tmp_name'][$key]);
			$itemimg->filename = $name;	
			$itemimg->item_id = $model1->id;
			$itemimg->save();
//move_uploaded_file($_FILES['files']['tmp_name'][$key],Yii::app()->params['uploadDir'].$filename);
		}}
			Yii::app()->user->SetFlash('success', "Товар <b>$model1->name</b> изменен!");			
			$this->redirect(array('catalog/index','parent_id'=>$model1->catalog_id));
		}}

		$this->render('update',array(
			'breadcrumbs'=>$breadcrumbs,
			'model'=>$model1,
			'dataProvider'=>$dataProvider,
		));
	}

//для товаров без каталога, так нельзя делать, но похуй

	public function actionCreateitem()
	{
		$this->performAjaxValidation($model);	
		$breadcrumbs = array();
		$breadcrumbs["Каталог"] = array('catalog/index');
		$breadcrumbs["Админка"] = array('/admin');
		$breadcrumbs["Товары"] = array('admin');
		$model=new Item;
		$model->catalog_id = $catalog_id;
		$model->country_id = 0;
		$model->manufacter_id = 0;

		if(isset($_POST['Item']))
		{
			$model->attributes = $_POST['Item'];

			if(!$model->alias) $model->alias = Translit::url($model->name);
		
			if(!empty($_POST['Item']['catalogs']))
			$model->catalogs = $_POST['Item']['catalogs'];
			if($model->saveWithRelated('catalogs')){
				$this->processAttributes($model);
				$this->processSizes($model);
				if($_POST['main'] ==1) {	
					$a = new ItemMain;
					$a->item_id = $model->id;
					$a->save();	
				}	

			if(isset($_FILES['files']))
			{
			foreach($_FILES['files']['name'] as $key=>$filename) {
					$itemimg = new ItemImage;					
			$name  =  ImageFuck::save($_FILES['files']['tmp_name'][$key]);
			$itemimg->filename = $name;	
			$itemimg->item_id = $model->id;
			$itemimg->save();
				//move_uploaded_file($_FILES['files']['tmp_name'][$key],Yii::app()->params['uploadDir'].$filename);
		}}
		 Yii::app()->user->SetFlash('success', "Товар <b>$model->name</b> добавлен!");	
			$this->redirect(array('item/admin'));
		}
		}
		$this->render('create',array(
			'model'=>$model,
			'breadcrumbs'=>$breadcrumbs,
		));
	}
	public function actionUpdateitem($id)
	{

 $this->performAjaxValidation($model);
		$model1=$this->loadModel($id);
							if($_POST['main'] ==1)
		{	
		$a = new ItemMain;
		$a->item_id = $model1->id;
		$a->save();	
				}	
		        $dataProvider=new CActiveDataProvider('ItemImage',array(
                                            'criteria'=>array(
                                                'condition'=>'item_id='.$model1->id,
                                                'order'=>'position, id DESC',
                                            ),
                                            'pagination'=>array(
                                                'pageSize'=>100,
                                            ),
        ));
$model = Catalog::model()->findByPk($model1->catalog_id);		
//вычисление динамических хлебных крошек
$breadcrumbs = array();
		$breadcrumbs = array();
		$breadcrumbs["Админка"] = array('/admin');
		$breadcrumbs["Товары"] = array('admin');
		$breadcrumbs["Изменить товар $model1->name"] = " ";

		$parent_id = $model->parent_id;
		if(isset($_POST['Item']))
		{	


			$model1->attributes=$_POST['Item'];
									if(!$model1->alias)
			$model1->alias = Translit::url($model1->name);

			if(!empty($_POST['Item']['catalogs']))
			$model1->catalogs = $_POST['Item']['catalogs'];
			if($model1->saveWithRelated('catalogs')){
$this->processAttributes($model1);
				$this->processSizes($model1);
		if(isset($_FILES['files']))
		{
			foreach($_FILES['files']['name'] as $key=>$filename) {
					$itemimg = new ItemImage;					
			$name  =  ImageFuck::save($_FILES['files']['tmp_name'][$key]);
			$itemimg->filename = $name;	
			$itemimg->item_id = $model1->id;
			$itemimg->save();
//move_uploaded_file($_FILES['files']['tmp_name'][$key],Yii::app()->params['uploadDir'].$filename);
		}}
			Yii::app()->user->SetFlash('success', "Товар <b>$model1->name</b> изменен!");			
			$this->redirect(array('item/admin'));
		}}

		$this->render('update',array(
			'breadcrumbs'=>$breadcrumbs,
			'model'=>$model1,
			'dataProvider'=>$dataProvider,
		));
	}


//******************








	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
			
			
			if($model->images[0]->id == null) {} else {
			foreach($model->images as $image)
			{
			ImageFuck::delete($image->filename);
			}}
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Item');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Item('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Item::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

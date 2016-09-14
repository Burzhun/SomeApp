<?php

class CategoryController extends Controller
{
	public $layout='column1';
	public $name='Категории';

	public function actionCreate(){

		$parent_id = Yii::app()->request->getParam('pid');
		if($parent_id){
			$this->breadcrumbs = Category::getBreadcrumbs($parent_id);
			$category = Category::model()->findByPk($parent_id);
			$this->breadcrumbs[$category->name] = '/admin/category/index?pid='.$category->id;
		}else{
			$this->breadcrumbs[$this->name] = '/admin/category';
		}

		$model=new Category;
		$model->parent_id = Yii::app()->request->getParam('pid');

		if(isset($_POST['Category'])){
			$model->attributes=$_POST['Category'];

			if($model->save()){
				//$model->saveCategoryImages();
				Yii::app()->user->setFlash('success', 'Пункт <b>'.$model->name.'</b> успешно добавлен');
				$this->redirect(array('index','pid'=>$model->parent_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id){

		$model=$this->loadModel($id);
		
		if($model->parent_id){
			$this->breadcrumbs = Category::getBreadcrumbs($model->parent_id);
			$category = Category::model()->findByPk($model->parent_id);
			$this->breadcrumbs[$category->name] = '/admin/category/index?pid='.$category->id;
		}else{
			$this->breadcrumbs[$this->name] = '/admin/category';
		}
		

		if(isset($_POST['Category'])){
			$model->attributes=$_POST['Category'];

			if($model->save()){
				//$model->saveCategoryImages();
				Yii::app()->user->setFlash('success', 'Пункт <b>'.$model->name.'</b> успешно изменен');
				$this->redirect(array('index','pid'=>$model->parent_id));
			}
		}

		// картинки товара
		/*$dataProvider=new CActiveDataProvider('CategoryImages',array(
									'criteria'=>array(
										'condition'=>'category_id='.$model->id,
										'order'=>'position ASC',
									),
									'pagination'=>array(
										'pageSize'=>100,
									),
		));*/

		$this->render('update',array(
			'model'=>$model,
			//'dataProvider'=>$dataProvider,
		));
	}

	public function actionUpdatePrice(){
		$id = Yii::app()->request->getParam('pk');
		$value = (int)Yii::app()->request->getParam('value');

		if(!is_int($value)){
			echo 'Значение должно быть числом';
			die();
		}

		$category = Category::model()->findByPk($id);
		foreach ($category->items as $data) {
			$data->price = (int)$data->price + (int)$value;
			$data->save(false);
		}
		echo 'Цены изменены!';
		die();
	}

	public function actionUpdatePricePercent(){
		$id = Yii::app()->request->getParam('pk');
		$value = (int)Yii::app()->request->getParam('value');

		if(!is_int($value)){
			echo 'Значение должно быть числом';
			die();
		}

		$category = Category::model()->findByPk($id);
		foreach ($category->items as $data) {
			$plus = $data->price * $value / 100;
			
			$data->price = (int)$data->price + (int)$plus;
			$data->save(false);
		}
		echo 'Цены изменены!';
		die();
	}

	public function actionDeleteImage($id){
		$model=CategoryImages::model()->findByPk($id);
		$model->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionDelete($id){
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex(){

		$parent_id = Yii::app()->request->getParam('pid');
		if(!$parent_id){
			$this->breadcrumbs+=array($this->name);
		}else{
			$category = Category::model()->findByPk($parent_id);
			$this->breadcrumbs += Category::getBreadcrumbs($parent_id);
			$this->breadcrumbs[] = $category->name;
		}

		$model=new Category('search');
		$model->unsetAttributes();  
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		// Товары категории

		/*$itemModel=new Item('search');
		$itemModel->unsetAttributes();  
		$itemModel->category_id = $parent_id;
		if(isset($_GET['Item']))
			$itemModel->attributes=$_GET['Item'];*/

		$this->render('index',array(
			'model'=>$model,
			'itemModel'=>$itemModel,
		));
	}

	public function actionView($id){
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function loadModel($id){
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSort(){
	    if (isset($_POST['items']) && is_array($_POST['items'])) {
	        $i = 0;
	        foreach ($_POST['items'] as $item) {
	            $model = Category::model()->findByPk($item);
	            $model->position = $i;
	            $model->save();
	            $i++;
	        }
	    }
	}

	public function actionSortImage(){
	    if (isset($_POST['items']) && is_array($_POST['items'])) {
	        $i = 0;
	        foreach ($_POST['items'] as $item) {
	            $model = CategoryImages::model()->findByPk($item);
	            $model->position = $i;
	            $model->save();
	            $i++;
	        }
	    }
	}
}

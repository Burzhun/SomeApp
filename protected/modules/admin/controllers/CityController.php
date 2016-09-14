<?php

class CityController extends Controller
{
	public $layout='//layouts/column1';
	public $name = 'Города';

	public function actionCreate(){
		$this->breadcrumbs[$this->name]='/admin/city'; 

		$model=new City;

		if(isset($_POST['City'])){
			$model->attributes=$_POST['City'];

			if($model->save()){
				Yii::app()->user->setFlash('success', 'Пункт <b>'.$model->name.'</b> успешно добавлен');
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id){
		$this->breadcrumbs[$this->name]='/admin/city'; 
		$model=$this->loadModel($id);

		if(isset($_POST['City'])){
			$model->attributes=$_POST['City'];

			if($model->save()){
				Yii::app()->user->setFlash('success', 'Пункт <b>'.$model->name.'</b> успешно добавлен');
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id){
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex(){
		/*$dataProvider=new CActiveDataProvider('City');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		$model=new City('search');
		$model->unsetAttributes();  
		if(isset($_GET['City']))
			$model->attributes=$_GET['City'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionView($id){
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function loadModel($id){
		$model=City::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSort(){
	    if (isset($_POST['items']) && is_array($_POST['items'])) {
	        $i = 0;
	        foreach ($_POST['items'] as $item) {
	            $model = City::model()->findByPk($item);
	            $model->position = $i;
	            $model->save();
	            $i++;
	        }
	    }
	}
}

<?php

class ServiceController extends Controller
{

	public $layout='//layouts/column2';


	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionIndex()
	{
		$news = Service::model()->findAll(array(
									'order' => 'position, date DESC'));
		$this->render('index',array(
			'news'=>$news,
		));
	}

	public function loadModel($id)
	{
		$model=Service::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

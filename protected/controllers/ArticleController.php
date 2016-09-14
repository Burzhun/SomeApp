<?php

class ArticleController extends Controller
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
		$news = Article::model()->findAll(array(
									'order' => 'position, date DESC',
									'condition' => 'theme='.$this->themeId,
									));
		$this->render('index',array(
			'news'=>$news,
		));
	}

	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
